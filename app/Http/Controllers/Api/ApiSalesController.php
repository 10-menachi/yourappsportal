<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Sales;
use Exception;

class ApiSalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        try {
            $products = Sale::all();
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
            $product = Sale::find($id);
            return response()->json($product, 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred while fetching product'], 500);
        }
    }
}
