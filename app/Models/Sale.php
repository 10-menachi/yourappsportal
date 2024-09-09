<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'product_id',
        'sku',
        'category_id',
        'slug',
        'description',
        'sku',
        'qr_code'
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
