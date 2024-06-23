<?php

use App\Http\Controllers\CoursesController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::post('/my-age', [PeopleController::class, 'ageCalculator']);

Route::post('/post/create-comment', [PostController::class, 'createComment']);
Route::get('/post/{id}', [PostController::class, 'getPostById']);

Route::get('people', [PeopleController::class, 'index']);
Route::post('people', [PeopleController::class, 'store']);
Route::get('people/{id}', [PeopleController::class, 'show']);
Route::put('people/{id}', [PeopleController::class, 'update']);
Route::delete('people/{id}', [PeopleController::class, 'destroy']);

Route::post('/students/create', [StudentController::class, 'createStudent']);
Route::post('/students/{student_id}/assign-course', [StudentController::class, 'assignCourse']);
Route::post('/students/{student_id}/assign-courses', [StudentController::class, 'assignCourses']);
Route::delete('/students/delete/{student_id}', [StudentController::class, 'deleteStudent']);
Route::get('/students/getById/{student_id}', [StudentController::class, 'getStudent']);
Route::get('/students/get-all', [StudentController::class, 'getAllStudents']);
Route::put('/students/edit/{student_id}', [StudentController::class, 'updateStudent']);
Route::put('/students/edit-with-extrainfo/{student_id}', [StudentController::class, 'updateStudentWithPivot']);

Route::post('/courses/create', [CoursesController::class, 'createCourse']);
Route::get('/courses/getById/{course_id}', [CoursesController::class, 'getCourse']);
Route::get('/courses/get-all', [CoursesController::class, 'getAllCourses']);
Route::get('/courses/get-all-without-students', [CoursesController::class, 'getExistingCourses']);
Route::put('/courses/edit/{course_id}', [CoursesController::class, 'updateCourse']);
Route::delete('/courses/delete/{course_id}', [CoursesController::class, 'deleteCourse']);
