<?php

use App\Http\Controllers\ApiCategoriesController;
use App\Http\Controllers\ApiProductsController;
use App\Http\Controllers\ApiSalesController;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('products/categories', function (Request $request) {
    try {

        $validator = Validator::make($request->all(), [
            'categoryId' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }


        $data = $request->all();

        $category = ProductCategory::find($data['categoryId']);

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

Route::apiResource('products', [ApiProductsController::class])->only(['index', 'show']);
Route::apiResource('categories', [ApiCategoriesController::class])->only(['index', 'show']);
Route::apiResource('sales', [ApiSalesController::class])->only(['show', 'store', 'update',]);
