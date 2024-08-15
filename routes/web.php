<?php

use App\Http\Controllers\ProfileController;
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

Route::get('products', function () {})->middleware(['auth', 'verified'])->name('products');
Route::get('sales', function () {})->middleware(['auth', 'verified'])->name('sales');
Route::get('categories', function () {})->middleware(['auth', 'verified'])->name('categories');
Route::get('services', function () {})->middleware(['auth', 'verified'])->name('services');
