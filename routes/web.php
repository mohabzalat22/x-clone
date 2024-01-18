<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;


// PUBLIC ROUTES
Route::get('/', [AuthController::class, 'index']); // login data request

/// GUEST 
Route::middleware('guest')->group(function(){
    Route::post('/login', [AuthController::class, 'login'])->name('login'); // login => view
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

// AUTH
Route::middleware('auth')->group(function(){
    // AUTH CONTROLLER 
    Route::get('logout', [AuthController::class, 'logout'])->name('logout'); //logout
    // HOME CONTROLLER
    Route::get('home',[HomeController::class, 'index'])->name('home'); // home => view
    // POST CONTROLLER
    Route::resource('tweet', TweetController::class)->except(['create']);
    // COMMENT CONTROLLER
    Route::resource('comment', CommentController::class)->except(['index','create']);
    // REACTION CONTROLLER
    Route::prefix('reaction')->group(function (){
        Route::post('heart', [ReactionController::class, 'heart']);
        Route::post('viewed', [ReactionController::class, 'viewed']);
    });
    // PROFILE
    Route::get('profile/{profile}',[ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile/{profile}',[ProfileController::class, 'update'])->name('profile.update');

});
