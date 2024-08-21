<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Product::select('products.name', 'products.model_number', 'products.description', 'products.price', 'product_categories.name as category_name')
            ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->get()
            ->map(function ($product) {
                $product->description = strip_tags($product->description);
                return $product;
            });
    }

    public function headings(): array
    {
        return [
            'Name',
            'Model Number',
            'Description',
            'Price (KES)',
            'Category'
        ];
    }
}
