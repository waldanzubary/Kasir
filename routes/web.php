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
Route::get('Warehouse/create', [WarehouseController::class, 'CreateIndex'])->name('items.create');


//post
Route::post('register', [AuthController::class, 'registerProccess'])->middleware('guest');
Route::post('login', [AuthController::class, 'authenticating'])->middleware('guest');
Route::post('items', [WarehouseController::class, 'store'])->name('items.store');

Route::get('/warehouse/{id}/edit', [WarehouseController::class, 'edit'])->name('warehouse.edit');
Route::put('/warehouse/{id}', [WarehouseController::class, 'update'])->name('warehouse.update');
Route::delete('/warehouse/{id}', [WarehouseController::class, 'destroy'])->name('warehouse.destroy');



