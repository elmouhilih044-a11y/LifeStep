<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\LifeProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogementController;
use App\Http\Controllers\MonthlyPaymentController;
use App\Http\Controllers\ReservationController;

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



Route::post('/logements/{logement}/reserve', [ReservationController::class, 'store'])
    ->name('reservations.store')
    ->middleware('auth');

    Route::post('/reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])
    ->name('reservations.cancel')
    ->middleware('auth');


Route::get('/reservations/{reservation}/success', [ReservationController::class, 'success'])
    ->name('reservations.success')
    ->middleware('auth');

Route::get('/reservations/{reservation}/checkout-cancel', [ReservationController::class, 'cancelCheckout'])
    ->name('reservations.cancelCheckout')
    ->middleware('auth');

Route::patch('/reservations/{reservation}/confirm-payment', [ReservationController::class, 'confirmPayment'])
    ->name('reservations.confirmPayment')
    ->middleware('auth');

Route::post('/life-profile/skip', [LifeProfileController::class, 'skip'])
    ->name('life_profiles.skip')
    ->middleware('auth');

Route::get('/mes-logements', [LogementController::class, 'mine'])
    ->name('logements.mine')
    ->middleware('auth');
   
Route::get('/mes-recommandations', [LogementController::class, 'recommended'])
    ->name('logements.recommended');

Route::patch('/admin/users/{user}/toggle-ban', [AdminController::class, 'toggleBan'])
    ->name('admin.users.toggleBan');

Route::middleware('auth')->group(function () {
    Route::post('/monthly-payments/{monthlyPayment}/checkout', [MonthlyPaymentController::class, 'checkout'])
        ->name('monthly-payments.checkout');

    Route::get('/monthly-payments/{monthlyPayment}/success', [MonthlyPaymentController::class, 'success'])
        ->name('monthly-payments.success');

    Route::get('/monthly-payments/{monthlyPayment}/cancel', [MonthlyPaymentController::class, 'cancel'])
        ->name('monthly-payments.cancel');
});