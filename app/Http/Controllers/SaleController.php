<?php

namespace App\Http\Controllers;

use App\Exports\SalesExport;
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
            $sales = $data['sales'];

            $validator = Validator::make($data, [
                'sales' => 'required|array',
                'sales.*.categoryId' => 'required|integer|exists:product_categories,id',
                'sales.*.productId' => 'required|integer|exists:products,id',
                'sales.*.startDate' => 'required|date|date_format:Y-m-d',
                'sales.*.endDate' => 'required|date|date_format:Y-m-d|after_or_equal:sales.*.startDate',
                'sales.*.qr_code' => 'required|string|max:255',
                'sales.*.sku' => 'required|string|max:255',
                'sales.*.description' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            foreach ($sales as $sale) {
                Sale::create([
                    'category_id' => $sale['categoryId'],
                    'product_id' => $sale['productId'],
                    'warranty_start_date' => $sale['startDate'],
                    'warranty_end_date' => $sale['endDate'],
                    'qr_code' => $sale['qr_code'],
                    'description' => $sale['description'],
                    'sku' => $sale['sku'],
                ]);
            }

            DB::commit();

            return redirect()->route('sales.index')->with('success', 'Sales created successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('CREATE SALE ERROR');
            Log::info($e);

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
        $products = Product::where('category_id', $sale->category_id)->get();
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

            $rules = [
                'categoryId' => 'required|integer|exists:product_categories,id',
                'productId' => 'required|integer|exists:products,id',
                'startDate' => 'required|date|date_format:Y-m-d',
                'endDate' => 'required|date|date_format:Y-m-d|after_or_equal:startDate',
                'qr_code' => 'required|string',
                'price' => 'nullable|numeric|min:0',
                'sku' => 'required|string|max:255',
                'description' => 'nullable|string',
            ];

            $validator = Validator::make($data, $rules);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $sale = Sale::findOrFail($id);

            $sale->update([
                'category_id' => $data['categoryId'],
                'product_id' => $data['productId'],
                'warranty_start_date' => $data['startDate'],
                'warranty_end_date' => $data['endDate'],
                'qr_code' => $data['qr_code'],
                'price' => $data['price'],
                'description' => $data['description'],
                'sku' => $data['sku'],
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
