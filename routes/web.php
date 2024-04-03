<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{SidebarController, TeacherController, SubjectController, StudentsController};

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

// Route::get('/', function () {
    // return view('welcome');
// });

// routes/web.php


/** Teachers routes start */
Route::get('/', [SidebarController::class, 'index'])->name('home');
Route::post('/teachers', [TeacherController::class, 'store'])->name('teachers.store');
Route::get('/teachers/create', [TeacherController::class, 'create'])->name('teachers.create');
Route::get('/teachers/listing', [TeacherController::class, 'index'])->name('teachers.index');
Route::post('/teachers/filter', [TeacherController::class, 'filter'])->name('teachers.filter');
/** Teachers routes end */

/** Subjects routes start */
Route::post('/subjects', [SubjectController::class, 'store'])->name('subjects.store');
Route::get('/subjects/create', [SubjectController::class, 'create'])->name('subjects.create');
Route::get('/subjects/listing', [SubjectController::class, 'index'])->name('subjects.index');
Route::post('/subjects/filter', [SubjectController::class, 'filter'])->name('subjects.filter');
/** Subjects routes end */

/** Students routes start */
Route::post('/students', [StudentsController::class, 'store'])->name('students.store');
Route::get('/students/create', [StudentsController::class, 'create'])->name('students.create');
Route::get('/students/listing', [StudentsController::class, 'index'])->name('students.index');
Route::post('/students/filter', [StudentsController::class, 'filter'])->name('students.filter');
/** Students routes end */