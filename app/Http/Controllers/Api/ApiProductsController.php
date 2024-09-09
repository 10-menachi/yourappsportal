<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;

class ApiProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        try {
            $products = Product::all();
            return response()->json($products, 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred while fetching products'], 500);
        }
    }

    /**
     * Display the specified resource.
     */

    public function show($id)
    {
        try {
            $product = Product::find($id);
            return response()->json($product, 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred while fetching product'], 500);
        }
    }
}
