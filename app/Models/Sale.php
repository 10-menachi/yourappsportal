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
        'salesPrice',
        'costPrice',
        'startDate',
        'endDate',
        'qr_code',
        'isDelete',
    ];

    // Optionally, if you're not using the default timestamps, you can disable it
    public $timestamps = true;

    // Optionally, if you need custom date formats
    protected $dates = ['created_at', 'updated_at'];


    // In Sale.php
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}