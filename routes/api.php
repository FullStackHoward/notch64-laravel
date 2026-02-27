<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SplashController;
use App\Http\Controllers\Api\ThoughtController;

Route::get('/splash/random', [SplashController::class, 'random']);
Route::get('/thought/current', [ThoughtController::class, 'current']);

