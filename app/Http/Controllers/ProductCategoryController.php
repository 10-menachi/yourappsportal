<?php

namespace App\Http\Controllers;

use App\Exports\CategoriesExport;
use App\Imports\CategoriesImport;
use App\Models\ProductCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = ProductCategory::all();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'desc' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            // Use the name as the description if no description is provided
            $description = $request->input('desc', strtolower($request->input('name')));

            // Create a new Product Category
            $category = ProductCategory::create([
                'name' => $request->input('name'),
                'description' => $description,
            ]);

            DB::commit();

            Log::info('Category created successfully', ['category_id' => $category->id]);

            return redirect()->route('categories.index')->with('success', 'Category created successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Failed to create category', [
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);

            return redirect()->back()->with('error', 'Failed to create category: ' . $e->getMessage())->withInput();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = ProductCategory::findOrFail($id);
        return view('categories.edit', compact('category'));
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
                'name' => 'required|string|max:255',
                'desc' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $category = ProductCategory::findOrFail($id);
            $category->update([
                'name' => $data['name'],
                'description' => $data['desc'],
            ]);

            DB::commit();

            return redirect()->route('categories.index')->with('success', 'Category updated successfully');
        } catch (Exception $e) {
            DB::rollBack();
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
            $category = ProductCategory::findOrFail($id);
            $category->delete();

            DB::commit();

            return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function upload()
    {
        return view('categories.excel');
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

            Excel::import(new CategoriesImport, $file);

            DB::commit();

            return redirect()->route('categories.index')->with('success', 'Categories uploaded successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('CATEGORIES EXCEL ERROR');
            Log::info($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function download()
    {
        Log::info('HERE');
        return Excel::download((new CategoriesExport), 'categories.xlsx');
    }
}