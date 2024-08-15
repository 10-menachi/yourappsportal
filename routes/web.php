<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::resource('sales', SaleController::class)->middleware(['auth', 'verified']);
Route::post('sales/download', [SaleController::class, 'download'])->middleware(['auth', 'verified'])->name('sales.download');
Route::post('sales/upload', [SaleController::class, 'upload'])->middleware(['auth', 'verified'])->name('sales.upload');
Route::get('products', function () {})->middleware(['auth', 'verified'])->name('products');
Route::get('categories', function () {})->middleware(['auth', 'verified'])->name('categories');
Route::get('services', function () {})->middleware(['auth', 'verified'])->name('services');
