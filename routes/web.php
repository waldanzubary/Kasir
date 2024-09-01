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
})->name('welcome');

//Auth
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::get('register', [AuthController::class, 'register'])->middleware('guest');
Route::post('register', [AuthController::class, 'registerProccess'])->middleware('guest');
Route::get('select-active-date', [AuthController::class, 'selectActiveDate'])->middleware('auth')->name('selectActiveDate');
Route::get('select-active-date-no-trial', [AuthController::class, 'selectActiveDateNoTrial'])->middleware('auth')->name('selectActiveDateNoTrial');
Route::get('select-active-date-extend', [AuthController::class, 'selectActiveDateExtend'])->middleware('auth')->name('selectActiveDateExtend');
Route::post('set-active-date', [AuthController::class, 'setActiveDate'])->name('setActiveDate');
Route::post('login', [AuthController::class, 'authenticating'])->middleware('guest');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/redirect-dashboard', [AuthController::class, 'redirectBasedOnRole'])->name('redirect.dashboard');

Route::get('/sent-email', [AuthController::class, 'sendEmail']);
Route::get('/activate-account/{token}', [AuthController::class, 'activateAccount']);
Route::get('/profile/edit-combined', [AuthController::class, 'editCombined'])->name('profile.edit_combined');
Route::patch('/profile/update-combined', [AuthController::class, 'updateCombined'])->name('profile.update_combined');
Route::get('/profile/edit-password', [AuthController::class, 'editPassword'])->name('profile.edit_password');
Route::patch('/profile/update-password', [AuthController::class, 'updatePassword'])->name('profile.update_password');

Route::put('/accounts/{id}/update-status', [AuthController::class, 'updateStatus'])->name('accounts.updateStatus');

Route::get('/activation-sent', function () {
    return view('auth.activation_sent');
});


//Warehouse
Route::get('Warehouse', [WarehouseController::class, 'Warehouse'])->middleware('auth');
Route::get('Warehouse/create', [WarehouseController::class, 'CreateIndex'])->name('items.create')->middleware('auth');
Route::post('items', [WarehouseController::class, 'store'])->name('items.store')->middleware('auth');
Route::get('/warehouse/{id}/edit', [WarehouseController::class, 'edit'])->name('warehouse.edit')->middleware('auth');
Route::put('/warehouse/{id}', [WarehouseController::class, 'update'])->name('warehouse.update')->middleware('auth');
Route::delete('/warehouse/{id}', [WarehouseController::class, 'destroy'])->name('warehouse.destroy')->middleware('auth');

Route::get('/warehouse/{id}/download-barcode', [WarehouseController::class, 'downloadBarcode'])->name('warehouse.downloadBarcode')->middleware('auth');


//cashier
Route::get('/sales/create', [CashierController::class, 'create'])->name('sales.create')->middleware('OnlyCashier')->middleware('auth');
Route::post('/sales', [CashierController::class, 'store'])->name('sales.store')->middleware('OnlyCashier');

Route::get('/sales/creates', [SalesController::class, 'create'])->name('sales.creates')->middleware('OnlyCashier')->middleware('auth');
Route::post('/sales/stores', [SalesController::class, 'store'])->name('sales.stores')->middleware('OnlyCashier')->middleware('auth');
Route::post('/sales/barcode', [SalesController::class, 'barcode'])->name('sales.barcode')->middleware('OnlyCashier')->middleware('auth');
Route::post('/scan-barcode', 'SaleController@scanBarcode');

//transaction
Route::get('/transaction', [TransactionController::class, 'transaction'])->name('transaction.index');
Route::get('/transaction/{id}', [TransactionController::class, 'show'])->name('sales.show')->middleware('auth');

Route::get('staff', [StaffController::class, 'transactions'])->name('sales.transactions');
Route::get('/transactions/export-pdf', [StaffController::class, 'exportPdf'])->name('sales.exportPDF');



Route::get('/latest-sale', [TotalController::class, 'latest'])->name('sales.latest');





//admin
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware('auth')->middleware('OnlyAdmin');

Route::get('/manage', [DashboardController::class, 'manageaccount'])->name('accounts.index')->middleware('auth')->middleware('OnlyAdmin')
;
Route::get('accounts/edit/{id}', [DashboardController::class, 'edit'])->name('accounts.edit')->middleware('auth')->middleware('OnlyAdmin');
Route::put('accounts/update/{id}', [DashboardController::class, 'update'])->name('accounts.update')->middleware('auth')->middleware('OnlyAdmin');
Route::delete('accounts/destroy/{id}', [DashboardController::class, 'destroy'])->name('accounts.destroy')->middleware('auth')->middleware('OnlyAdmin');




