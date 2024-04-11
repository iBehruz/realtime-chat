<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChatUsersController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RealTimeMessage;

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::get('/chat/users', [ChatUsersController::class, 'index'])
    ->name('chat_users');

Route::get('/users', [UsersController::class, 'index'])
    ->name('users');

Route::get('/messages', [ChatController::class, 'index'])
    ->name('messages');

Route::post('/message', [RealTimeMessage::class, 'message'])
    ->name('message');



Route::get('/home', [HomeController::class, 'chat'])->name('home');

Route::get('/chat', [HomeController::class, 'chat'])->name('chat');

