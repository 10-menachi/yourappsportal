<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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

            ProductCategory::create([
                'name' => $data['name'],
                'description' => $data['desc'],
            ]);

            DB::commit();

            return redirect()->route('categories.index')->with('success', 'Category created successfully');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
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
}
