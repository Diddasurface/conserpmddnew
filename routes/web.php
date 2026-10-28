<?php

use App\Models\Course;
use App\Http\Controllers\CertificateController;
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
    return view('index', [
        'courses' => Course::published()->get(),
        'courseSection' => CourseSection::current(),
    ]);
})->name('inicio');

Route::get('/contactanos', function () {
    return view('contactanos.contactanos');
})->name('contactanos');


Route::get('/nosotros', function () {
    return view('nosotros.nosotros');
})->name('nosotros');

Route::get('/certificados', [CertificateController::class, 'index'])->name('certificates.index');
Route::get('/certificados/{code}/documento', [CertificateController::class, 'evidence'])->name('certificates.evidence');
Route::get('/certificados/{code}', [CertificateController::class, 'show'])->name('certificates.show');

Route::middleware([SetUpPanel::class.':admin', FilamentAuthenticate::class])->group(function () {
    Route::get('/admin/certificados/{certificate}/qr/{format}', [CertificateController::class, 'qr'])
        ->whereIn('format', ['png', 'svg'])->name('admin.certificates.qr');
    Route::get('/admin/certificados/{certificate}/documento', [CertificateController::class, 'adminEvidence'])
        ->name('admin.certificates.evidence');
});
