<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\ScannerController;
use App\Http\Controllers\ItemScanController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\TransactionController;

Route::get('/', function () {
    return view('welcome');
});

//Auth
Route::get('login', [AuthController::class, 'login'])->name('login')->middleware('guest');;
Route::get('register', [AuthController::class, 'register'])->middleware('guest');
Route::post('register', [AuthController::class, 'registerProccess'])->middleware('guest');
Route::post('login', [AuthController::class, 'authenticating'])->middleware('guest');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');


//Warehouse
Route::get('Warehouse', [WarehouseController::class, 'Warehouse'])->middleware('auth');
Route::get('Warehouse/create', [WarehouseController::class, 'CreateIndex'])->name('items.create');
Route::post('items', [WarehouseController::class, 'store'])->name('items.store');
Route::get('/warehouse/{id}/edit', [WarehouseController::class, 'edit'])->name('warehouse.edit');
Route::put('/warehouse/{id}', [WarehouseController::class, 'update'])->name('warehouse.update');
Route::delete('/warehouse/{id}', [WarehouseController::class, 'destroy'])->name('warehouse.destroy');

//cashier
Route::get('/sales/create', [CashierController::class, 'create'])->name('sales.create');
Route::post('/sales', [CashierController::class, 'store'])->name('sales.store');
Route::get('/sales/creates', [SalesController::class, 'create'])->name('sales.creates');
Route::post('/sales/stores', [SalesController::class, 'store'])->name('sales.stores');
Route::post('/sales/barcode', [ScannerController::class, 'processBarcode'])->name('sales.barcode');

//transaction
Route::get('/transaction', [TransactionController::class, 'transaction'])->name('transaction.index');
Route::get('/transaction/{id}', [TransactionController::class, 'show'])->name('sales.show');



