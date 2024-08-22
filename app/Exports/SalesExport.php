<?php

namespace App\Exports;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesExport implements FromCollection, WithHeadings
{
    /**
     * @var string
     */
    protected $date;

    /**
     * @var Product
     */
    protected $product;

    /**
     * Constructor
     *
     * @param string $date
     * @param Product $product
     */
    public function __construct($date, Product $product)
    {
        $this->date = $date;
        $this->product = $product;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Sale::whereDate('sales.created_at', $this->date)
            ->where('product_id', $this->product->id)
            ->join('products', 'sales.product_id', '=', 'products.id')
            ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->select(
                'product_categories.name as Category',
                'products.name as Product',
                'sales.warranty_start_date as Warranty_Start_Date',
                'sales.warranty_end_date as Warranty_End_Date',
                'sales.qr_code as QR_Code',
                'sales.sku as SKU',
                'sales.description as Description'
            )
            ->get()
            ->map(function ($product) {
                Log::info('OLD PRODUCT');
                Log::info($product);
                $product->Description = strip_tags($product->Description);
                Log::info('NEW PRODUCT');
                Log::info($product);
                return $product;
            });
    }


    /**
     * @return array
     */

    public function headings(): array
    {
        return [
            'Category',
            'Product',
            'Warranty Start Date',
            'Warranty End Date',
            'QR Code',
            'SKU',
            'Description',
        ];
    }
}
