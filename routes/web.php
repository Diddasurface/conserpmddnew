<?php

use App\Models\Course;
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
