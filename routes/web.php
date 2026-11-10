<?php

use App\Models\Course;
use App\Models\SiteContent;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ServiceController;
use Filament\Http\Middleware\Authenticate as FilamentAuthenticate;
use Filament\Http\Middleware\SetUpPanel;
use App\Models\CourseSection;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $siteContent = SiteContent::current();

    return view('index', [
        'courses' => Course::published()->get(),
        'courseSection' => CourseSection::current(),
        'siteContent' => $siteContent,
        'services' => $siteContent->services(),
    ]);
})->name('inicio');

Route::get('/contactanos', function () {
    return view('contactanos.contactanos', ['siteContent' => SiteContent::current()]);
})->name('contactanos');


Route::get('/nosotros', function () {
    return view('nosotros.nosotros', ['siteContent' => SiteContent::current()]);
})->name('nosotros');

Route::get('/servicios', [ServiceController::class, 'index'])->name('services.index');
Route::get('/servicios/{service}', [ServiceController::class, 'show'])->name('services.show');

Route::get('/certificados', [CertificateController::class, 'index'])->name('certificates.index');
Route::get('/certificados/{code}/documento', [CertificateController::class, 'evidence'])->name('certificates.evidence');
Route::get('/certificados/{code}', [CertificateController::class, 'show'])->name('certificates.show');

Route::middleware([SetUpPanel::class.':admin', FilamentAuthenticate::class])->group(function () {
    Route::get('/admin/certificados/{certificate}/qr/{format}', [CertificateController::class, 'qr'])
        ->whereIn('format', ['png', 'svg'])->name('admin.certificates.qr');
    Route::get('/admin/certificados/{certificate}/documento', [CertificateController::class, 'adminEvidence'])
        ->name('admin.certificates.evidence');
});
