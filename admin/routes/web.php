<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\CoursesController;


Route::get('/', [HomeController::class, 'HomeIndex'])->middleware('loginCheck');
Route::get('/visitor', [VisitorController::class, 'VisitorIndex'])->middleware('loginCheck');

///Services
Route::get('/service', [ServicesController::class, 'ServiceIndex'])->middleware('loginCheck');
Route::get('/getServicesData', [ServicesController::class, 'getServicesData'])->middleware('loginCheck');
Route::post('/ServiceDelete', [ServicesController::class, 'ServiceDelete'])->middleware('loginCheck');
Route::put('/ServiceUpdate', [ServicesController::class, 'ServiceUpdate'])->middleware('loginCheck');
Route::post('/getInputFieldData', [ServicesController::class, 'SetDataInInputField'])->middleware('loginCheck');
Route::post('/serviceAdd', [ServicesController::class, 'ServiceAdd'])->middleware('loginCheck');

///Courses
Route::get('/courses', [CoursesController::class, 'CoursesIndex'])->middleware('loginCheck');
Route::get('/getCoursesData', [CoursesController::class, 'getCoursesData'])->middleware('loginCheck');
Route::post('/CoursesDelete', [CoursesController::class, 'CoursesDelete'])->middleware('loginCheck');
Route::post('/courseAdd', [CoursesController::class, 'CoursesAdd'])->middleware('loginCheck');
Route::post('/getCourseFieldData', [CoursesController::class, 'SetDataInInputField'])->middleware('loginCheck');
Route::put('/CoursesUpdate', [CoursesController::class, 'CoursesUpdate'])->middleware('loginCheck');

///Projects
Route::get('/projects', [ProjectsController::class, 'ProjectIndex'])->middleware('loginCheck');
Route::get('/getProjectData', [ProjectsController::class, 'getProjectData'])->middleware('loginCheck');
Route::post('/projectDelete', [ProjectsController::class, 'ProjectDelete'])->middleware('loginCheck');
Route::post('/projectAdd', [ProjectsController::class, 'ProjectAdd'])->middleware('loginCheck');
Route::post('/getProjectFieldData', [ProjectsController::class, 'SetDataInInputField'])->middleware('loginCheck');
Route::put('/projectUpdate', [ProjectsController::class, 'ProjectUpdate'])->middleware('loginCheck');

//Contact
Route::get('/contact', [ContactController::class, 'ContactIndex'])->middleware('loginCheck');
Route::get('/getContactData', [ContactController::class, 'getContactData'])->middleware('loginCheck');
Route::post('/ContactDelete', [ContactController::class, 'ContactDelete'])->middleware('loginCheck');

//Review
Route::get('/review', [ReviewController::class, 'reviewIndex'])->middleware('loginCheck');
Route::get('/getReviewData', [ReviewController::class, 'getReviewData'])->middleware('loginCheck');
Route::post('/reviewDelete', [ReviewController::class, 'reviewDelete'])->middleware('loginCheck');
Route::post('/reviewAdd', [ReviewController::class, 'reviewAdd'])->middleware('loginCheck');
Route::post('/getReviewFieldData', [ReviewController::class, 'SetDataInInputField'])->middleware('loginCheck');
Route::put('/reviewUpdate', [ReviewController::class, 'reviewUpdate'])->middleware('loginCheck');

//Login
Route::get('/Login', [LoginController::class, 'loginIndex']);
Route::post('/onLogin', [LoginController::class, 'onLogin']);
Route::get('/onLogout', [LoginController::class, 'onLogout']);



