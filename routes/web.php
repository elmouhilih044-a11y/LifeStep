<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogementController;


Route::get('/', function () {
    return view('welcome');
});

Route::resource('logements', LogementController::class);

Route::get('/register',[AuthController::class,'showRegister'])->name('register');


Route::post('/register',[AuthController::class,'register'])->name('register.post');

Route::get('/login',[AuthController::class,'showLogin'])->name('login');

Route::post('/login',[AuthController::class,'login'])->name('login.post');
