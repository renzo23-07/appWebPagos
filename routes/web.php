<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\CreditSaleController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerTransactionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TransactionController;
use App\Models\Customer;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('addresses', AddressController::class);
    Route::resource('customers',CustomerController::class);
    Route::get('/credit-sale/create/{id}',[CreditSaleController::class,'create'])->name('createCreditSales');
    Route::post('/credit_sale/create',[CreditSaleController::class,'store'])->name('creditSalesStore');
    Route::get('/transactions/{id_customer}',[TransactionController::class,'show'])->name('transactions.show');

    Route::get('/create-payment/{customer_id}', [PaymentController::class, 'create'])->name('payment.create');
    Route::post('/payment/store', [PaymentController::class, 'store'])->name('payment.store');
    Route::get('/payments/show/{id}', [PaymentController::class, 'show'])->name('payment.show');

    Route::get('/credit_sale/show/{id}',[CreditSaleController::class,'show'])->name('creditSale.show');
});





//Route::get('/customers/{id}/sales',[CustomerTransactionController::class,'index'])->name('TransactionSales');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
