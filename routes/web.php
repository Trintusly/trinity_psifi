<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\Post\InteractController;
use App\Http\Controllers\Post\ViewController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\User\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [ RegisterController::class, 'index' ])->name('register');
Route::post('/register', [ RegisterController::class, 'register' ])->name('register::register');

Route::get('/login', [ LoginController::class, 'index' ])->name('login');
Route::post('/login', [ LoginController::class, 'login' ])->name('login::login');

Route::get('/user/dashboard', [ DashboardController::class, 'index' ])->name('user.dashboard');
Route::post('/user/dashboard/updateBio', [ DashboardController::class, 'updateBio' ])->name('user.dashboard::updateBio');
Route::post('/user/dashboard/makePost', [ DashboardController::class, 'makePost' ])->name('user.dashboard::makePost');



Route::get('/post/view/{id}', [ ViewController::class, 'index' ])->name('post.view');
Route::post('/post/interact/{id}/comment', [ InteractController::class, 'comment' ])->name('post.interact::comment');
