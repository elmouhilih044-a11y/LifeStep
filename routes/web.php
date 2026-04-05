<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogementController;


Route::get('/', function () {
    return view('welcome');
});

Route::resource('logements', LogementController::class);

