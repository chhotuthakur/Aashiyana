<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientsController;

Route::get('/', function () {
    return view('index')->name('home');
});
Route::get('/login', function () {
    return view('Login');
});
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [ClientsController::class, 'login'])->name('login.attempt');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [ClientsController::class, 'register'])->name('register.attempt');