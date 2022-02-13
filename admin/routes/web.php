<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\CoursesController;


Route::get('/', [HomeController::class, 'HomeIndex']);
Route::get('/visitor', [VisitorController::class, 'VisitorIndex']);

Route::get('/service', [ServicesController::class, 'ServiceIndex']);
Route::get('/getServicesData', [ServicesController::class, 'getServicesData']);
Route::post('/ServiceDelete', [ServicesController::class, 'ServiceDelete']);
Route::put('/ServiceUpdate', [ServicesController::class, 'ServiceUpdate']);
Route::post('/getInputFieldData', [ServicesController::class, 'SetDataInInputField']);
Route::post('/serviceAdd', [ServicesController::class, 'ServiceAdd']);

Route::get('/courses', [CoursesController::class, 'CoursesIndex']);
Route::get('/getCoursesData', [CoursesController::class, 'getCoursesData']);
Route::post('/CoursesDelete', [CoursesController::class, 'CoursesDelete']);
Route::post('/courseAdd', [CoursesController::class, 'CoursesAdd']);
Route::post('/getCourseFieldData', [CoursesController::class, 'SetDataInInputField']);
Route::put('/CoursesUpdate', [CoursesController::class, 'CoursesUpdate']);



