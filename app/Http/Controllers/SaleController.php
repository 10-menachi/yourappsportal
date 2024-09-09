<?php

namespace App\Http\Controllers;

use App\Exports\SalesExport;
use App\Imports\SalesImport;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Sale;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        $sales = Sale::all();
        return view('sales.index', compact('products', 'sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ProductCategory::all();
        return view('sales.create', compact('categories'));
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
                'sales.*.categoryId' => 'required|integer|exists:product_categories,id',
                'sales.*.productId' => 'required|integer|exists:products,id',
                'sales.*.startDate' => 'nullable|date_format:Y-m-d',
                'sales.*.endDate' => 'nullable|date_format:Y-m-d|after_or_equal:sales.*.startDate',
                'sales.*.qr_code' => 'required|string|max:255',
                'sales.*.sku' => 'nullable|string|max:199',
                'sales.*.description' => 'nullable|string|max:65535',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $sales = $data['sales'];

            foreach ($sales as $sale) {
                Log::info('SALE');
                Log::info($sale);
                $product = Product::find($sale['productId']);
                $name = $product->name . $sale['sku'] ?? $product->model_number;
                $slug = Str::slug($name);
                Sale::create([
                    'name' => $name,
                    'category_id' => $sale['categoryId'],
                    'product_id' => $sale['productId'],
                    'sku' => $sale['sku'],
                    'slug' => $slug,
                    'description' => $sale['description'],
                    'salesPrice' => $product->price ?? null,
                    'costPrice' => $product->cost_price ?? null,
                    'startDate' => $sale['startDate'],
                    'endDate' => $sale['endDate'],
                    'qr_code' => $sale['qr_code'],
                ]);
            }

            DB::commit();

            return redirect()->route('sales.index')->with('success', 'Sales created successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('CREATE SALE ERROR:'); // Adjusted error logging
            Log::error($e); // Log the stack trace for debugging

            return redirect()->back()->with('error', 'Error creating sale');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $sale = Sale::findOrFail($id);
        $qrcode = base64_encode(QrCode::format('png')
            ->size(300)
            ->generate('https://yourapps.co.ke/product-sales/' . $sale->qr_code));
        return view('sales.show', compact('sale', 'qrcode'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $sale = Sale::findOrFail($id);
        $categories = ProductCategory::all();
        $products = Product::all();
        return view('sales.edit', compact('sale', 'categories', 'products'));
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
                'model_number' => 'required|string|max:199',
                'startDate' => 'nullable|date_format:Y-m-d',
                'endDate' => 'nullable|date_format:Y-m-d|after_or_equal:sales.*.startDate',
                'qr_code' => 'required|string|max:255',
                'desc' => 'nullable|string|max:65535',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $sale = Sale::findOrFail($id);
            $product = Product::where('model_number', $sale['sku'])->first();

            $name = $product->name . $sale['sku'] ?? $product->model_number;
            $slug = Str::slug($name);

            $sale->update([
                'name' => $name,
                'sku' => $data['model_number'],
                'slug' => $slug,
                'description' => $data['desc'],
                'startDate' => $data['startDate'],
                'endDate' => $data['endDate'],
                'qr_code' => $data['qr_code'],
            ]);

            DB::commit();

            return redirect()->route('sales.index')->with('success', 'Sale updated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('UPDATE SALE ERROR');
            Log::info($e);

            return redirect()->back()->with('error', 'Error updating sale');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        //
    }

    public function upload()
    {
        return view('sales.excel');
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

            Excel::import(new SalesImport, $file);

            DB::commit();

            return redirect()->route('sales.index')->with('success', 'Sales uploaded successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('UPLOAD SALES ERROR');
            Log::info($e);

            return redirect()->back()->with('error', 'Error uploading sales');
        }
    }

    public function download(Request $request)
    {
        try {
            $data = $request->all();

            $product = Product::findOrFail($data['product']);

            return Excel::download(new SalesExport($data['createdAt'], $product), 'sales-' . $data['createdAt'] . '-' . $product->name . '.xlsx');
        } catch (Exception $e) {
            Log::info('DOWNLOAD SALES ERROR');
            Log::info($e);

            return redirect()->back()->with('error', 'Error downloading sales');
        }
    }
}
