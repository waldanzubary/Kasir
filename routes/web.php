<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TotalController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\ScannerController;
use App\Http\Controllers\ItemScanController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\TransactionController;

Route::get('/', function () {
    return view('welcome');
});

//Auth
Route::get('login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::get('register', [AuthController::class, 'register'])->middleware('guest');
Route::post('register', [AuthController::class, 'registerProccess'])->middleware('guest');
Route::post('login', [AuthController::class, 'authenticating'])->middleware('guest');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');


//Warehouse
Route::get('Warehouse', [WarehouseController::class, 'Warehouse'])->middleware('auth')->middleware('OnlyStaff');
Route::get('Warehouse/create', [WarehouseController::class, 'CreateIndex'])->name('items.create')->middleware('OnlyStaff');
Route::post('items', [WarehouseController::class, 'store'])->name('items.store')->middleware('OnlyStaff');
Route::get('/warehouse/{id}/edit', [WarehouseController::class, 'edit'])->name('warehouse.edit')->middleware('OnlyStaff');
Route::put('/warehouse/{id}', [WarehouseController::class, 'update'])->name('warehouse.update')->middleware('OnlyStaff');
Route::delete('/warehouse/{id}', [WarehouseController::class, 'destroy'])->name('warehouse.destroy')->middleware('OnlyStaff');

//cashier
Route::get('/sales/create', [CashierController::class, 'create'])->name('sales.create')->middleware('OnlyCashier');
Route::post('/sales', [CashierController::class, 'store'])->name('sales.store')->middleware('OnlyCashier');

Route::get('/sales/creates', [SalesController::class, 'create'])->name('sales.creates')->middleware('OnlyCashier');
Route::post('/sales/stores', [SalesController::class, 'store'])->name('sales.stores')->middleware('OnlyCashier');
Route::post('/sales/barcode', [SalesController::class, 'barcode'])->name('sales.barcode')->middleware('OnlyCashier');


//transaction
Route::get('/transaction', [TransactionController::class, 'transaction'])->name('transaction.index');
Route::get('/transaction/{id}', [TransactionController::class, 'show'])->name('sales.show');


Route::get('staff', [StaffController::class, 'transactions'])->name('transaction.indexs');



Route::get('/latest-sale', [TotalController::class, 'latest'])->name('sales.latest');
