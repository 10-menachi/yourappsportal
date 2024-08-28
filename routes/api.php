<?php

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('products/categories', function (Request $request) {
    try {
        $data = $request->all();
        Log::info('Request data: ', $data); 


        $category = ProductCategory::find($data['categoryId']);
        Log::info('Category: ', $category ? $category->toArray() : 'Not found'); 


        return response()->json([
            'message' => 'Product categories fetched successfully',
            'data' => $category->get_products()
        ], 200);
    } catch (Exception $e) {
        Log::info('FETCH CAT ERROR');
        Log::info($e);
        return response()->json([
            'message' => 'An error occurred while fetching product categories',
            'error' => $e->getMessage()
        ], 500);
    }
})->name('api.products.categories');