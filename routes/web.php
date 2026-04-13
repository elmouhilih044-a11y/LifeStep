<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\LifeProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogementController;


Route::get('/', function () {
    $stats = [
        'total' => 0,
        'dispo' => 0,
        'villes' => 0,
        'prix' => '–',
    ];

    $recent = collect();

    return view('welcome', compact('stats', 'recent'));
})->name('home');

Route::resource('logements', LogementController::class)
    ->middleware('auth');

Route::get('/register',[AuthController::class,'showRegister'])->name('register');
Route::middleware('auth')->group(function () {
     Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{logementId}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{logementId}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
});
Route::get('/profile', function () {
    return view('profile');
})->name('profile');


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

Route::middleware(['auth','admin'])->prefix('admin')->group(function(){
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
});
   