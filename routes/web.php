<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SpotifyController;


Route::get('/', [HomeController::class, 'index']);
Route::get('/spotify/auth', [SpotifyController::class, 'auth']);
Route::get('/spotify/callback', [SpotifyController::class, 'callback']);
