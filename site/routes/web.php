<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'HomeIndex']);
Route::post('/contact', [HomeController::class, 'HomeContact']);

Route::get('/Courses', [CoursesController::class, 'CoursesIndex']);
Route::get('/Projects', [ProjectsController::class, 'ProjectsIndex']);
Route::get('/Contact', [ContactController::class, 'ContactIndex']);
