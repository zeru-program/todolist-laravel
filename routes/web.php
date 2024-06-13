<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Todo\TodoController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\isLogin;


/*Route::get('/', function () {
    return view('todo.home');
});

Route::post('/', function () {
    return "berhasil";
});*/

Route::get('/', [TodoController::class, 'index'])->name('todo');

Route::post('/', [TodoController::class, 'store'])->name('todo.post');

Route::put('/{id}', [TodoController::class, 'update'])->name('todo.update');

Route::put('/subtask/{id}', [TodoController::class, 'updateSubtask'])->name('subtask.update');

Route::delete('/{id}', [TodoController::class, 'destroy'])->name('todo.delete');

Route::get('/auth/login', [LoginController::class, 'index'])->middleware(isLogin::class)->name('login');

Route::post('/auth/login', [LoginController::class, 'store'])->middleware(isLogin::class)->name('login.post');

Route::get('/auth/register', [RegisterController::class, 'index'])->middleware(isLogin::class)->name('register');

Route::post('/auth/register', [RegisterController::class, 'store'])->middleware(isLogin::class)->name('register.post');

Route::get('/auth/logout', [LogoutController::class, 'index'])->name('logout');
