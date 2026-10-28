<?php

namespace Tests\Feature;

use App\Filament\Resources\CourseResource\Pages\CreateCourse;
use App\Filament\Resources\CourseResource\Pages\EditCourse;
use App\Filament\Resources\CourseResource\Pages\ListCourses;
use App\Models\Course;
use App\Models\CourseSection;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class CourseManagementTest extends TestCase
{
    use RefreshDatabase {
        refreshDatabase as protected refreshIsolatedDatabase;
    }

    protected function setUp(): void
    {
        parent::setUp();
        config(['app.url' => 'http://localhost']);
        app('url')->forceRootUrl('http://localhost');
        Filament::setCurrentPanel(Filament::getPanel('admin'));
    }

    public function refreshDatabase(): void
    {
        // Never run RefreshDatabase against the application's MySQL database.
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
        $this->refreshIsolatedDatabase();
    }

    private function signInAsAdministrator(): void
    {
        $user = User::factory()->create();
        $this->actingAs(CourseAdministrator::findOrFail($user->id));
    }

    public function test_only_published_courses_appear_in_order_with_escaped_content(): void
    {
        Course::create(['title' => 'Hidden draft', 'description' => 'Private']);
        Course::create(['title' => 'Second course', 'description' => 'Second', 'is_published' => true, 'sort_order' => 2]);
        Course::create(['title' => 'First course', 'description' => '<script>alert(1)</script>', 'is_published' => true, 'sort_order' => 1]);

        $this->get('/')->assertOk()->assertDontSee('Hidden draft')
            ->assertSeeInOrder(['First course', 'Second course'])
            ->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false)
            ->assertDontSee('<script>alert(1)</script>', false);
    }

    public function test_admin_can_create_a_course_with_an_image_then_edit_and_delete_it(): void
    {
        Storage::fake('public');
        $this->signInAsAdministrator();

        Livewire::test(CreateCourse::class)->fillForm([
            'title' => 'Seguridad en el trabajo', 'description' => 'Curso de prevención.',
            'image' => UploadedFile::fake()->image('curso.jpg'), 'image_alt' => 'Equipo de seguridad',
            'is_published' => true, 'price' => 0,
        ])->call('create')->assertHasNoFormErrors();

        $course = Course::sole();
        Storage::disk('public')->assertExists($course->image);
        $this->get('/')->assertOk()->assertSee('Seguridad en el trabajo')->assertSee('Equipo de seguridad')->assertSee('S/0,00');

        Livewire::test(EditCourse::class, ['record' => $course->getRouteKey()])
            ->fillForm(['title' => 'Curso actualizado', 'is_published' => false])->call('save')->assertHasNoFormErrors();
        $this->get('/')->assertOk()->assertDontSee('Curso actualizado');

        Livewire::test(EditCourse::class, ['record' => $course->getRouteKey()])->callAction('delete');
        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
    }

    public function test_admin_can_edit_the_section_and_empty_state(): void
    {
        $this->signInAsAdministrator();
        Livewire::test(ListCourses::class)->callAction('section', data: [
            'eyebrow' => 'Formación', 'title' => 'Capacita a tu equipo',
            'empty_text' => 'Nuevas fechas muy pronto',
            'button_text' => 'Consultar', 'button_url' => 'https://example.com/contacto',
        ])->assertHasNoActionErrors();

        $this->assertSame('Capacita a tu equipo', CourseSection::current()->title);
        $this->get('/')->assertOk()->assertSee('Capacita a tu equipo')->assertSee('Nuevas fechas muy pronto');
    }

    public function test_invalid_links_and_ratings_are_rejected(): void
    {
        $this->signInAsAdministrator();
        Livewire::test(CreateCourse::class)->fillForm([
            'title' => 'Curso', 'description' => 'Descripción',
            'button_url' => 'javascript:alert(1)', 'rating' => 6, 'price' => -1,
        ])->call('create')->assertHasFormErrors(['button_url', 'rating', 'price']);
        $this->assertDatabaseCount('courses', 0);
    }

    public function test_guests_cannot_open_the_course_administration(): void
    {
        $this->get('/admin/cursos')->assertRedirect('/admin/login');
    }
}

class CourseAdministrator extends User implements FilamentUser
{
    protected $table = 'users';

    public function canAccessPanel(Panel $panel): bool
    {
        return $panel->getId() === 'admin';
    }
}
