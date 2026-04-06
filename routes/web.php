<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LifeProfileController;
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

Route::post('/logout',[AuthController::class,'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/life-profile', [LifeProfileController::class, 'show'])
        ->name('life_profiles.show');

    Route::get('/life-profile/create', [LifeProfileController::class, 'create'])
        ->name('life_profiles.create');

    Route::post('/life-profile', [LifeProfileController::class, 'store'])
        ->name('life_profiles.store');

    Route::get('/life-profile/edit', [LifeProfileController::class, 'edit'])
        ->name('life_profiles.edit');

    Route::put('/life-profile', [LifeProfileController::class, 'update'])
        ->name('life_profiles.update');
});
   