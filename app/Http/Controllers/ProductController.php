<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use App\Models\Product;
use App\Models\ProductCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ProductCategory::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();

            $validator = Validator::make($data, [
                'category_id' => 'required|exists:product_categories,id',
                'name' => 'required|string|max:255',
                'model_number' => 'required|unique:products|string|max:255',
                'desc' => 'nullable|string',
                'price' => 'nullable|numeric',
            ]);

            if ($validator->fails()) {
                Log::info('VALIDATION ERROR');
                Log::info($validator->errors());
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            Product::create([
                'category_id' => $data['category_id'],
                'name' => $data['name'],
                'model_number' => $data['model_number'],
                'description' => $data['desc'],
                'price' => $data['price'],
            ]);

            DB::commit();

            return redirect()->route('products.index')->with('success', 'Product created successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('ERROR');
            Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = ProductCategory::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();

            $validator = Validator::make($data, [
                'category_id' => 'required|exists:product_categories,id',
                'name' => 'required|string|max:255',
                'model_number' => 'required|string|max:255',
                'desc' => 'nullable|string',
                'price' => 'nullable|numeric',
            ]);

            if ($validator->fails()) {
                Log::info('VALIDATION ERROR');
                Log::info($validator->errors());
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $product = Product::findOrFail($id);
            $product->update([
                'category_id' => $data['category_id'],
                'name' => $data['name'],
                'model_number' => $data['model_number'],
                'description' => $data['desc'],
                'price' => $data['price'],
            ]);

            DB::commit();

            return redirect()->route('products.index')->with('success', 'Product updated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('ERROR');
            Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($id);
            $product->delete();
            DB::commit();
            return redirect()->route('products.index')->with('success', 'Product deleted successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('ERROR');
            Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function upload()
    {
        return view('products.excel');
    }

    public function uploadStore(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();

            $validator = Validator::make($data, [
                'file' => 'required|mimes:xlsx,xls',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $file = $request->file('file');

            Excel::import(new ProductsImport, $file);

            DB::commit();

            return redirect()->route('products.index')->with('success', 'Products uploaded successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('CATEGORIES EXCEL ERROR');
            Log::info($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function download()
    {
        return Excel::download((new ProductsExport), 'products.xlsx');
    }
}
