<?php

use App\Http\Controllers\PeopleController;
use Illuminate\Support\Facades\Route;

Route::post('/my-age', [PeopleController::class, 'ageCalculator']);

