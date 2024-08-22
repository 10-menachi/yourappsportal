<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::resource('products', ProductController::class)->middleware('auth');
Route::get('products/file/download', [ProductController::class, 'download'])->middleware('auth')->name('products.file.download');
Route::get('products/file/upload', [ProductController::class, 'upload'])->middleware('auth')->name('products.file.upload');
Route::post('products/file/upload', [ProductController::class, 'uploadStore'])->middleware('auth')->name('products.file.upload');
