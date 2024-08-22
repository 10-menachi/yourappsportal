<?php

use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

Route::resource('sales', SaleController::class)->middleware('auth');
Route::get('sales/file/download', [SaleController::class, 'download'])->middleware('auth')->name('sales.file.download');
Route::get('sales/file/upload', [SaleController::class, 'upload'])->middleware('auth')->name('sales.file.upload');
Route::post('sales/file/upload', [SaleController::class, 'uploadStore'])->middleware('auth')->name('sales.file.upload');
