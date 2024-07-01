<?php

use App\Http\Controllers\AuthController;
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

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

// Rutas protegidas con Sanctum(autenticación)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::post('/auth/try', [AuthController::class, 'tryAuth']);

    // Ruta protegida con permiso 'usar api general'
    Route::post('/auth/tryRoleUser', [AuthController::class, 'tryRoleUser'])->middleware('permission:usar api general');
    Route::put('auth/user/{id}', [AuthController::class, 'update']);

    // Grupo de rutas protegidas con el rol admin (autorización)
    Route::middleware(['role:admin'])->group(function () {
        Route::post('/auth/tryRoleAdmin', [AuthController::class, 'tryRoleAdmin']);
        Route::get('auth/user/getUsers', [AuthController::class, 'getUsers']);

        Route::get('/auth/getRolesWithPermissions', [AuthController::class, 'getRolesWithPermissions']);
        Route::post('/auth/updateRolePermissions/{id}', [AuthController::class, 'updateRolePermissions']);

        // Puedes agregar más rutas aquí que necesiten el rol admin para acceder
    });
});
