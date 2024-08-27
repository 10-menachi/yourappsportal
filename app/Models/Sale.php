<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;


    protected $table = "sales";

    protected $fillable = [
        'category_id',
        'product_id',
        'warranty_start_date',
        'warranty_end_date',
        'qr_code',
        'description',
        'sku',
    ];

    public function pro_category()
    {
        $category = ProductCategory::where('id', '=', $this->category_id)->first();
        return $category;
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}