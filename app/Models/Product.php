<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'model_number',
        'description',
        'price',
        'avatar'
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }
}