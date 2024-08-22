<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        Log::info('ROW');
        Log::info($row);
        $category = ProductCategory::where('name', $row['category'])->first();

        if (!$category) {
            $category = ProductCategory::create([
                'name' => $row['category'],
                'description' => $row['category'],
            ]);
        }

        Product::firstOrCreate([
            'name' => $row['name'],
            'model_number' => $row['model_number'],
            'description' => $row['description'],
            'price' => $row['price'],
            'category_id' => $category->id,
        ]);
    }
}
