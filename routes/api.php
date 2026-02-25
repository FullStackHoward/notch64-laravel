<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SplashController;

Route::get('/splash/random', [SplashController::class, 'random']);
