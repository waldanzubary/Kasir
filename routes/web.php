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
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\TransactionController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;


Route::get('/', function () {
    return view('welcome');
});

//Auth
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::get('register', [AuthController::class, 'register'])->middleware('guest');
Route::post('register', [AuthController::class, 'registerProccess'])->middleware('guest');
Route::get('select-active-date', [AuthController::class, 'selectActiveDate'])->middleware('auth')->middleware('OnlyStaff')->name('selectActiveDate');
Route::get('select-active-date-no-trial', [AuthController::class, 'selectActiveDateNoTrial'])->middleware('auth')->middleware('OnlyStaff')->name('selectActiveDateNoTrial');
Route::post('set-active-date', [AuthController::class, 'setActiveDate'])->name('setActiveDate');
Route::post('login', [AuthController::class, 'authenticating'])->middleware('guest');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/redirect-dashboard', [AuthController::class, 'redirectBasedOnRole'])->name('redirect.dashboard');

Route::get('/sent-email', [AuthController::class, 'sendEmail']);

//Warehouse
Route::get('Warehouse', [WarehouseController::class, 'Warehouse'])->middleware('auth')->middleware('OnlyStaff');
Route::get('Warehouse/create', [WarehouseController::class, 'CreateIndex'])->name('items.create')->middleware('OnlyStaff');
Route::post('items', [WarehouseController::class, 'store'])->name('items.store')->middleware('OnlyStaff');
Route::get('/warehouse/{id}/edit', [WarehouseController::class, 'edit'])->name('warehouse.edit')->middleware('OnlyStaff');
Route::put('/warehouse/{id}', [WarehouseController::class, 'update'])->name('warehouse.update')->middleware('OnlyStaff');
Route::delete('/warehouse/{id}', [WarehouseController::class, 'destroy'])->name('warehouse.destroy')->middleware('OnlyStaff');

Route::get('/warehouse/{id}/download-barcode', [WarehouseController::class, 'downloadBarcode'])->name('warehouse.downloadBarcode');


//cashier
Route::get('/sales/create', [CashierController::class, 'create'])->name('sales.create')->middleware('OnlyCashier');
Route::post('/sales', [CashierController::class, 'store'])->name('sales.store')->middleware('OnlyCashier');

Route::get('/sales/creates', [SalesController::class, 'create'])->name('sales.creates')->middleware('OnlyCashier');
Route::post('/sales/stores', [SalesController::class, 'store'])->name('sales.stores')->middleware('OnlyCashier');
Route::post('/sales/barcode', [SalesController::class, 'barcode'])->name('sales.barcode')->middleware('OnlyCashier');

//transaction
Route::get('/transaction', [TransactionController::class, 'transaction'])->name('transaction.index');
Route::get('/transaction/{id}', [TransactionController::class, 'show'])->name('sales.show');

Route::get('staff', [StaffController::class, 'transactions'])->name('sales.transactions');
Route::get('/transactions/export-pdf', [StaffController::class, 'exportPdf'])->name('sales.exportPDF');



Route::get('/latest-sale', [TotalController::class, 'latest'])->name('sales.latest');





//admin
Route::get('/dashboard', [DashboardController::class, 'dashboard']);

Route::get('/manage', [DashboardController::class, 'manageaccount'])->name('accounts.index')
;
Route::get('accounts/edit/{id}', [DashboardController::class, 'edit'])->name('accounts.edit');
Route::put('accounts/update/{id}', [DashboardController::class, 'update'])->name('accounts.update');
Route::delete('accounts/destroy/{id}', [DashboardController::class, 'destroy'])->name('accounts.destroy');




