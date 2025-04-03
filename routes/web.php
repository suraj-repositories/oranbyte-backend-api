<?php

use App\Http\Controllers\Github\GitHubController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;


Route::get('/', function () {

});

Route::get('/github/login', function () {
    return Socialite::driver('github')->redirect();
});

Route::get('/github/callback', [GitHubController::class, 'handleCallback']);
