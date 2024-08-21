<?php

use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
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

Route::resource('sales', SaleController::class)->middleware('auth');
Route::get('sales/download', [SaleController::class, 'download'])->middleware('auth')->name('sales.download');
Route::get('sales/upload', [SaleController::class, 'upload'])->middleware('auth')->name('sales.upload');
Route::resource('products', ProductController::class)->middleware('auth');
Route::get('products/file/download', [ProductController::class, 'download'])->middleware('auth')->name('products.file.download');
Route::get('products/file/upload', [ProductController::class, 'upload'])->middleware('auth')->name('products.file.upload');
Route::resource('categories', ProductCategoryController::class)->middleware('auth');
Route::get('categories/file/download', [ProductCategoryController::class, 'download'])->middleware('auth')->name('categories.file.download');
Route::get('categories/upload', [ProductCategoryController::class, 'upload'])->middleware('auth')->name('categories.upload');
