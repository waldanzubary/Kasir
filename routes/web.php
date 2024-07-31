<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WarehouseController;

Route::get('/', function () {
    return view('welcome');
});

//get
Route::get('login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::get('register', [AuthController::class, 'register'])->middleware('guest');
Route::get('Warehouse', [WarehouseController::class, 'Warehouse'])->middleware('auth');


//post
Route::post('register', [AuthController::class, 'registerProccess'])->middleware('guest');
Route::post('login', [AuthController::class, 'authenticating'])->middleware('guest');
