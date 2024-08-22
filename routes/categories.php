<?php

use App\Http\Controllers\ProductCategoryController;
use Illuminate\Support\Facades\Route;

Route::resource('categories', ProductCategoryController::class)->middleware('auth');
Route::get('categories/file/download', [ProductCategoryController::class, 'download'])->middleware('auth')->name('categories.file.download');
Route::get('categories/file/upload', [ProductCategoryController::class, 'upload'])->middleware('auth')->name('categories.file.upload');
Route::post('categories/file/upload', [ProductCategoryController::class, 'uploadStore'])->middleware('auth')->name('categories.file.upload');
