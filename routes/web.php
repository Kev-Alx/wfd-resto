<?php

use App\Http\Controllers\DiscountController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ItemController::class, "menu"])->name('menu');

Route::get('/dashboard', [ReportController::class, 'dashboard'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/checkout/{order:id}', [OrderController::class, 'checkout'])->name('checkout');
Route::get('/checkout/success/{order:id}', [OrderController::class, 'success'])->name('order.success');
Route::get('/test', function () {
  return view('order.success');
});
Route::middleware('auth')->group(function () {
    Route::middleware(['role:admin,manager'])->group(function(){
        Route::get('/items', [ItemController::class, 'index'])->name('item.index');

        Route::get('/orders', [OrderController::class, 'index'])->name('order.index');
        Route::get('/orders/{order:id}/edit', [OrderController::class, 'edit'])->name('order.edit');
        Route::patch('/orders/{order:id}', [OrderController::class, 'update'])->name('order.update');

        Route::get('/discounts', [DiscountController::class, 'index'])->name('discount.index');
    });

    Route::middleware(['role:manager'])->group(function(){
        Route::get('/items/create', [ItemController::class, 'create'])->name('item.create');
        Route::post('/items', [ItemController::class, 'store'])->name('item.store');
        Route::get('/items/{item:id}/edit', [ItemController::class, 'edit'])->name('item.edit');
        Route::patch('/items/{item:id}', [ItemController::class, 'update'])->name('item.update');
        Route::delete('/items/{item:id}', [ItemController::class, 'destroy'])->name('item.destroy');

        Route::get('/discounts/create', [DiscountController::class, 'create'])->name('discount.create');
        Route::post('/discounts', [DiscountController::class, 'store'])->name('discount.store');
        Route::get('/discounts/{discount:id}/edit', [DiscountController::class, 'edit'])->name('discount.edit');
        Route::patch('/discounts/{discount:id}', [DiscountController::class, 'update'])->name('discount.update');
        Route::delete('/discounts/{discount:id}', [DiscountController::class, 'destroy'])->name('discount.destroy');

        
        Route::get('/reports', [ReportController::class, 'index'])->name('report.index');
    });
    
    // Route::delete('/orders/{order:id}', [OrderController::class, 'destroy'])->name('order.destroy'); // buat batalkan pesanan
});

require __DIR__ . '/auth.php';
