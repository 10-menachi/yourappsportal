<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use League\Flysystem\SymbolicLinkEncountered;

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
            Log::info('Data from the Form of Creating Product :');
            Log::info($data);

            $validator = Validator::make($data, [
                'category_id' => 'required|exists:product_categories,id',
                'name' => 'required|string|max:255',
                'model_number' => 'required|unique:products|string|max:255',
                'desc' => 'nullable|string',
                'price' => 'nullable|numeric',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            if ($validator->fails()) {
                Log::info('VALIDATION ERROR');
                Log::info($validator->errors());
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            // Handle the image upload
            $imagePath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imagePath = $image->store('product-images', 'public');
            }

            // Create the product
            Product::create([
                'category_id' => $data['category_id'],
                'name' => $data['name'],
                'model_number' => $data['model_number'],
                'description' => $data['desc'],
                'price' => $data['price'],
                'avatar' => $imagePath,
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
            Log::info('Data from the form of update product');
            Log::info($data);
            $product = Product::findOrFail($id);
            Log::info('product to be updated is ');
            Log::info($product);

            // Validate input
            $validator = Validator::make($data, [
                'category_id' => 'required|exists:product_categories,id',
                'name' => 'required|string|max:255',
                'model_number' => 'required|string|max:255|unique:products,model_number,' . $id,
                'desc' => 'nullable|string',
                'price' => 'nullable|numeric',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            if ($validator->fails()) {
                Log::info('VALIDATION ERROR');
                Log::info($validator->errors());
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            // Handle image upload
            $imagePath = $product->avatar; // Keep old image path by default

            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($product->avatar && Storage::exists('public/' . $product->avatar)) {
                    Storage::delete('public/' . $product->avatar);
                }

                // Upload new image
                $image = $request->file('image');
                $imagePath = $image->store('product-images', 'public');
            }

            // Update product details
            $product->update([
                'category_id' => $data['category_id'],
                'name' => $data['name'],
                'model_number' => $data['model_number'],
                'description' => $data['desc'],
                'price' => $data['price'],
                'avatar' => $imagePath,
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