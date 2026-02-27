<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SplashController;
use App\Http\Controllers\Api\ThoughtController;
use App\Http\Controllers\Api\CurrentlyPlayingController;
use App\Http\Controllers\Api\SpotifyApiController;


Route::get('/splash/random', [SplashController::class, 'random']);
Route::get('/thought/current', [ThoughtController::class, 'current']);
Route::get('/currently-playing', [CurrentlyPlayingController::class, 'index']);
Route::get('/spotify/top-artists', [SpotifyApiController::class, 'topArtists']);
