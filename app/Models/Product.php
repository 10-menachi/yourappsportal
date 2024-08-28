<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

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

    public function pro_category()
    {
        $category = ProductCategory::where('id', '=', $this->category_id)->first();
        return $category;
    }
}