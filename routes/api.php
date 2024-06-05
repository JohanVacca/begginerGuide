<?php

use App\Http\Controllers\PeopleController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::post('/my-age', [PeopleController::class, 'ageCalculator']);

Route::post('/post/create-comment', [PostController::class, 'createComment']);
Route::get('/post/{id}', [PostController::class, 'getPostById']);

Route::get('people', [PeopleController::class, 'index']);
Route::post('people', [PeopleController::class, 'store']);
Route::get('people/{id}', [PeopleController::class, 'show']);
Route::put('people/{id}', [PeopleController::class, 'update']);
Route::delete('people/{id}', [PeopleController::class, 'destroy']);
