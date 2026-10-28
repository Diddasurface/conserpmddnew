<?php

namespace Tests\Feature;

use App\Filament\Resources\CertificateResource\Pages\CreateCertificate;
use App\Filament\Resources\CertificateResource\Pages\EditCertificate;
use App\Filament\Resources\CertificateResource\Pages\ListCertificates;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Livewire\Livewire;
use Tests\TestCase;

class CertificateManagementTest extends TestCase
{
    use RefreshDatabase {
        refreshDatabase as protected refreshIsolatedDatabase;
    }

    protected function setUp(): void
    {
        parent::setUp();
        config(['app.url' => 'http://localhost', 'certificates.public_url' => 'https://conserpmdd.com']);
        app('url')->forceRootUrl('http://localhost');
        Filament::setCurrentPanel(Filament::getPanel('admin'));
        Storage::fake('local');
    }

    public function refreshDatabase(): void
    {
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
        $this->refreshIsolatedDatabase();
    }

    private function signIn(): void
    {
        $user = User::factory()->create();
        $this->actingAs(CertificateAdministrator::findOrFail($user->id));
    }

    private function certificate(array $attributes = []): Certificate
    {
        $image = UploadedFile::fake()->image('constancia.png');
        Storage::disk('local')->put('certificates/evidence/constancia.png', file_get_contents($image->getRealPath()));

        return Certificate::create(array_merge([
            'recipient_name' => 'Participante de prueba', 'training_title' => 'Prevención de riesgos',
            'issued_at' => today(), 'status' => 'valid',
            'evidence_image' => 'certificates/evidence/constancia.png',
        ], $attributes));
    }

    public function test_admin_can_create_edit_and_publish_a_certificate_with_a_private_image(): void
    {
        $this->signIn();
        Livewire::test(CreateCertificate::class)->fillForm([
            'recipient_name' => 'Ana Ejemplo', 'training_title' => 'Capacitación SST',
            'issued_at' => today()->toDateString(), 'status' => 'draft',
            'evidence_image' => UploadedFile::fake()->image('constancia.jpg'),
        ])->call('create')->assertHasNoFormErrors();

        $certificate = Certificate::sole();
        Storage::disk('local')->assertExists($certificate->evidence_image);
        $this->assertMatchesRegularExpression('/^CMDD-[0-9A-Z]{26}$/', $certificate->code);
        $this->assertSame('https://conserpmdd.com/certificados/'.$certificate->code, $certificate->verification_url);

        Livewire::test(EditCertificate::class, ['record' => $certificate->id])
            ->assertSee('Descargar QR PNG')
            ->fillForm(['status' => 'valid', 'public_notes' => 'Constancia emitida por ConserpMDD.'])
            ->call('save')->assertHasNoFormErrors();

        $this->get('/certificados/'.$certificate->code)->assertOk()->assertSee('Ana Ejemplo')->assertSee('Capacitación SST');
        $this->get('/certificados/'.$certificate->code.'/documento')->assertOk()->assertHeader('Content-Type', 'image/jpeg');
    }

    public function test_drafts_and_their_images_are_not_public_and_downloads_require_login(): void
    {
        $certificate = $this->certificate(['status' => 'draft']);
        $this->get('/certificados/'.$certificate->code)->assertNotFound()->assertDontSee('Participante de prueba');
        $this->get('/certificados/'.$certificate->code.'/documento')->assertNotFound();
        $this->get('/admin/certificados/'.$certificate->id.'/qr/png')->assertRedirect('/admin/login');
        $this->get('/admin/certificados/'.$certificate->id.'/documento')->assertRedirect('/admin/login');
        $this->get('/admin/certificados/create')->assertRedirect('/admin/login');
    }

    public function test_revocation_keeps_the_same_url_and_clearly_invalidates_the_certificate(): void
    {
        $this->signIn();
        $certificate = $this->certificate();
        $url = $certificate->verification_url;
        Livewire::test(ListCertificates::class)->callTableAction('revoke', $certificate);
        $certificate->refresh();
        $this->assertSame('revoked', $certificate->status);
        $this->assertSame($url, $certificate->verification_url);
        $this->get('/certificados/'.$certificate->code)->assertOk()->assertSee('Revocado')->assertSee('ya no es válido')
            ->assertDontSee('está registrado como válido');
    }

    public function test_expiration_and_expiration_day_are_handled_correctly(): void
    {
        $certificate = $this->certificate(['expires_at' => today()]);
        $this->get('/certificados/'.$certificate->code)->assertOk()->assertSee('está registrado como válido');
        $certificate->update(['expires_at' => today()->subDay()]);
        $this->get('/certificados/'.$certificate->code)->assertOk()->assertSee('Vencido')->assertDontSee('está registrado como válido');
    }

    public function test_codes_are_unique_and_the_course_can_be_deleted_without_breaking_verification(): void
    {
        $course = Course::create(['title' => 'SST', 'description' => 'Curso de SST']);
        $first = $this->certificate(['course_id' => $course->id]);
        $second = $this->certificate();
        $this->assertNotSame($first->code, $second->code);
        $code = $first->code;
        $first->update(['recipient_name' => 'Nombre corregido']);
        $this->assertSame($code, $first->fresh()->code);
        $course->delete();
        $this->assertNull($first->fresh()->course_id);
        $this->get('/certificados/'.$code)->assertOk()->assertSee('Prevención de riesgos');
    }

    public function test_the_generated_code_cannot_be_changed(): void
    {
        $certificate = $this->certificate();
        $certificate->code = 'REPLACEMENT';
        $this->expectException(ValidationException::class);
        $certificate->save();
    }

    public function test_search_unknown_codes_and_escaped_public_notes(): void
    {
        $certificate = $this->certificate(['public_notes' => '<script>alert(1)</script>']);
        $this->get('/certificados')->assertOk()->assertDontSee('Participante de prueba');
        $this->get('/certificados?code='.strtolower($certificate->code))->assertRedirect('/certificados/'.$certificate->code);
        $this->get('/certificados/UNKNOWN')->assertNotFound()->assertSee('Certificado no encontrado');
        $this->get('/certificados?code=%3Cscript%3E')->assertRedirect('/certificados')->assertSessionHasErrors('code');
        $this->get('/certificados/'.$certificate->code)->assertOk()->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false)
            ->assertDontSee('<script>alert(1)</script>', false);
    }

    public function test_admin_can_download_real_png_and_svg_qr_images(): void
    {
        $this->signIn();
        $certificate = $this->certificate();
        $png = $this->get('/admin/certificados/'.$certificate->id.'/qr/png')->assertOk()
            ->assertHeader('Content-Type', 'image/png');
        $this->assertStringStartsWith("\x89PNG\r\n\x1a\n", $png->getContent());
        $this->assertStringContainsString('QR-'.$certificate->code.'.png', $png->headers->get('Content-Disposition'));
        $this->get('/admin/certificados/'.$certificate->id.'/qr/svg')->assertOk()
            ->assertHeader('Content-Type', 'image/svg+xml')->assertSee('<svg', false);
    }

    public function test_invalid_uploads_and_expiration_dates_are_rejected(): void
    {
        $this->signIn();
        Livewire::test(CreateCertificate::class)->fillForm([
            'recipient_name' => 'Persona', 'training_title' => 'SST', 'issued_at' => '2026-10-28',
            'expires_at' => '2026-10-27', 'status' => 'valid',
            'evidence_image' => UploadedFile::fake()->create('script.svg', 1, 'image/svg+xml'),
        ])->call('create')->assertHasFormErrors(['expires_at', 'evidence_image']);
        $this->assertDatabaseCount('certificates', 0);
    }
}

class CertificateAdministrator extends User implements FilamentUser
{
    protected $table = 'users';

    public function canAccessPanel(Panel $panel): bool
    {
        return $panel->getId() === 'admin';
    }
}
