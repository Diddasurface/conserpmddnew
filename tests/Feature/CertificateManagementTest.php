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
use Livewire\Features\SupportFileUploads\FileUploadController;
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
            'training_title' => 'Prevención de riesgos',
            'issued_at' => today(), 'status' => 'valid',
            'evidence_image' => 'certificates/evidence/constancia.png',
        ], $attributes));
    }

    private function pdf(): UploadedFile
    {
        $content = "%PDF-1.4\n";
        $stream = 'BT /F1 18 Tf 30 150 Td (Lista de participantes - ConserpMDD) Tj ET';
        $objects = [
            '<< /Type /Catalog /Pages 2 0 R >>',
            '<< /Type /Pages /Kids [3 0 R] /Count 1 >>',
            '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 500 200] /Resources << /Font << /F1 4 0 R >> >> /Contents 5 0 R >>',
            '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>',
            '<< /Length '.strlen($stream).">>\nstream\n".$stream."\nendstream",
        ];
        $offsets = [];
        foreach ($objects as $index => $object) {
            $offsets[] = strlen($content);
            $content .= ($index + 1)." 0 obj\n".$object."\nendobj\n";
        }
        $xref = strlen($content);
        $content .= "xref\n0 6\n0000000000 65535 f \n";
        foreach ($offsets as $offset) {
            $content .= sprintf("%010d 00000 n \n", $offset);
        }
        $content .= "trailer\n<< /Size 6 /Root 1 0 R >>\nstartxref\n".$xref."\n%%EOF\n";

        return UploadedFile::fake()->createWithContent('lista-participantes.pdf', $content);
    }

    public function test_pdf_can_be_created_without_a_participant_and_viewed_or_downloaded(): void
    {
        $this->signIn();
        $pdf = $this->pdf();
        Livewire::test(CreateCertificate::class)->assertFormFieldDoesNotExist('recipient_name')->fillForm([
            'training_title' => 'Capacitación con listado', 'issued_at' => today()->toDateString(),
            'status' => 'valid', 'evidence_image' => $pdf,
        ])->call('create')->assertHasNoFormErrors();

        $certificate = Certificate::sole();
        $this->assertTrue($certificate->evidence_is_pdf);
        $this->get('/certificados/'.$certificate->code)->assertOk()->assertSee('Abrir PDF')->assertSee('Descargar PDF')
            ->assertSee('data-certificate-pdf', false)->assertSee('js/certificate-pdf.js', false)
            ->assertDontSee('<object', false)->assertDontSee('<dt>Participante</dt>', false);
        $response = $this->get('/certificados/'.$certificate->code.'/documento')->assertOk()
            ->assertHeader('Content-Type', 'application/pdf')->assertStreamedContent(file_get_contents($pdf->getPathname()));
        $this->assertStringStartsWith('inline;', $response->headers->get('Content-Disposition'));
        $download = $this->get('/certificados/'.$certificate->code.'/documento?download=1')->assertOk();
        $this->assertStringStartsWith('attachment;', $download->headers->get('Content-Disposition'));

        $certificate->update(['status' => 'draft']);
        $this->get('/certificados/'.$certificate->code.'/documento')->assertNotFound();
        $this->get('/admin/certificados/'.$certificate->id.'/documento')->assertOk()->assertHeader('Content-Type', 'application/pdf');
    }

    public function test_an_existing_image_can_be_replaced_by_pdf_without_changing_its_code_or_qr_url(): void
    {
        $this->signIn();
        $certificate = $this->certificate();
        $certificate->forceFill(['recipient_name' => 'Nombre del registro anterior'])->save();
        $url = $certificate->verification_url;
        $code = $certificate->code;
        Livewire::test(EditCertificate::class, ['record' => $certificate->id])
            ->assertFormFieldDoesNotExist('recipient_name')->fillForm(['evidence_image' => []])
            ->fillForm(['evidence_image' => $this->pdf()])
            ->call('save')->assertHasNoFormErrors();

        $certificate->refresh();
        $this->assertSame($code, $certificate->code);
        $this->assertSame($url, $certificate->verification_url);
        $this->assertTrue($certificate->evidence_is_pdf);
        $this->get('/certificados/'.$code)->assertOk()->assertSee('Abrir PDF')->assertDontSee('Nombre del registro anterior');
    }

    public function test_a_file_renamed_to_pdf_is_rejected_if_it_is_actually_html(): void
    {
        $this->signIn();
        Livewire::test(CreateCertificate::class)->fillForm([
            'training_title' => 'Capacitación', 'issued_at' => today()->toDateString(), 'status' => 'valid',
            'evidence_image' => UploadedFile::fake()->createWithContent('comprobante.pdf', '<html>Not a PDF</html>')->mimeType('text/html'),
        ])->call('create')->assertHasFormErrors(['evidence_image']);
        $this->assertDatabaseCount('certificates', 0);
    }

    public function test_admin_can_create_edit_and_publish_a_certificate_with_a_private_image(): void
    {
        $this->signIn();
        Livewire::test(CreateCertificate::class)->assertFormFieldDoesNotExist('recipient_name')->fillForm([
            'training_title' => 'Capacitación SST',
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

        $this->get('/certificados/'.$certificate->code)->assertOk()->assertDontSee('<dt>Participante</dt>', false)->assertSee('Capacitación SST');
        $this->get('/certificados/'.$certificate->code.'/documento')->assertOk()->assertHeader('Content-Type', 'image/jpeg');
    }

    public function test_drafts_and_their_images_are_not_public_and_downloads_require_login(): void
    {
        $certificate = $this->certificate(['status' => 'draft']);
        $this->get('/certificados/'.$certificate->code)->assertNotFound()->assertDontSee('Prevención de riesgos');
        $this->get('/certificados/'.$certificate->code.'/documento')->assertNotFound();
        $this->get('/admin/certificados/'.$certificate->id.'/qr/png')->assertRedirect('/admin/login');
        $this->get('/admin/certificados/'.$certificate->id.'/documento')->assertRedirect('/admin/login');
        $this->get('/admin/certificados/create')->assertRedirect('/admin/login');
    }

    /** @dataProvider jpegFileNames */
    public function test_jpeg_certificates_can_be_uploaded_and_displayed(string $filename): void
    {
        $this->signIn();
        Livewire::test(CreateCertificate::class)->assertFormFieldDoesNotExist('recipient_name')->fillForm([
            'training_title' => 'Seguridad laboral',
            'issued_at' => today()->toDateString(), 'status' => 'valid',
            'evidence_image' => UploadedFile::fake()->image($filename),
        ])->call('create')->assertHasNoFormErrors();

        $certificate = Certificate::sole();
        Storage::disk('local')->assertExists($certificate->evidence_image);
        $this->get('/certificados/'.$certificate->code.'/documento')
            ->assertOk()->assertHeader('Content-Type', 'image/jpeg');
    }

    public static function jpegFileNames(): array
    {
        return [['constancia.jpeg'], ['CONSTANCIA.JPEG'], ['constancia.jpg']];
    }

    public function test_readable_jpeg_temporary_files_without_realpath_can_be_uploaded(): void
    {
        $image = UploadedFile::fake()->image('whatsapp.jpeg');
        $upload = new class($image->getPathname(), 'whatsapp.jpeg', 'image/jpeg', UPLOAD_ERR_OK, true) extends UploadedFile
        {
            public function getRealPath(): string|false
            {
                return false;
            }
        };

        $paths = app(FileUploadController::class)->validateAndStore([$upload], 'local');
        $storedPath = 'livewire-tmp/'.$paths->first();
        Storage::disk('local')->assertExists($storedPath);
        $this->assertSame(file_get_contents($image->getPathname()), Storage::disk('local')->get($storedPath));
    }

    public function test_upload_endpoint_still_rejects_unsigned_requests(): void
    {
        $this->postJson('/livewire/upload-file', [
            'files' => [UploadedFile::fake()->image('constancia.jpeg')],
        ])->assertUnauthorized();
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
        $first->update(['public_notes' => 'Documento revisado']);
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
        $this->get('/certificados')->assertOk()->assertDontSee('Prevención de riesgos');
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
        $image = imagecreatefromstring($png->getContent());
        $centerX = intdiv(imagesx($image), 2);
        $centerY = intdiv(imagesy($image), 2);
        $redPixels = 0;
        for ($x = $centerX - 55; $x < $centerX + 55; $x++) {
            for ($y = $centerY - 55; $y < $centerY + 55; $y++) {
                $color = imagecolorsforindex($image, imagecolorat($image, $x, $y));
                if ($color['red'] > 100 && $color['red'] > $color['green'] * 1.4 && $color['red'] > $color['blue'] * 1.4) {
                    $redPixels++;
                }
            }
        }
        $this->assertGreaterThan(200, $redPixels, 'The company logo should appear in the center of the QR.');
        $background = imagecolorsforindex($image, imagecolorat($image, $centerX - 54, $centerY - 54));
        $this->assertSame(['red' => 255, 'green' => 255, 'blue' => 255, 'alpha' => 0], $background);
        imagedestroy($image);
        $this->get('/admin/certificados/'.$certificate->id.'/qr/svg')->assertOk()
            ->assertHeader('Content-Type', 'image/svg+xml')->assertSee('<svg', false)->assertSee('data:image/png;base64,', false);
    }

    public function test_invalid_uploads_and_expiration_dates_are_rejected(): void
    {
        $this->signIn();
        Livewire::test(CreateCertificate::class)->assertFormFieldDoesNotExist('recipient_name')->fillForm([
            'training_title' => 'SST', 'issued_at' => '2026-10-28',
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
