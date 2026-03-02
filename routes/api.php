<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SplashController;
use App\Http\Controllers\Api\ThoughtController;
use App\Http\Controllers\Api\CurrentlyPlayingController;
use App\Http\Controllers\Api\SpotifyApiController;
use App\Http\Controllers\Api\SteamController;
use App\Http\Controllers\Api\PlatformStatsController;
use App\Http\Controllers\Api\TwitchController;


Route::get('/splash/random', [SplashController::class, 'random']);
Route::get('/thought/current', [ThoughtController::class, 'current']);
Route::get('/currently-playing', [CurrentlyPlayingController::class, 'index']);
Route::get('/spotify/top-artists', [SpotifyApiController::class, 'topArtists']);
Route::get('/spotify/genre-data', [SpotifyApiController::class, 'genreData']);
Route::get('/steam/recently-played', [SteamController::class, 'recentlyPlayed']);
Route::get('/platform-stats', [PlatformStatsController::class, 'index']);
Route::get('/twitch/live-status', [TwitchController::class, 'liveStatus']);
Route::get('/twitch/schedule', [TwitchController::class, 'schedule']);

