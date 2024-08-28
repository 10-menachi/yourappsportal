<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;


    protected $table = 'product_categories';

    protected $fillable = ['name', 'description'];

    public function get_products()
    {
        $products = Product::where('category_id', '=', $this->id)->get();
        return $products;
    }


    // public function products()
    // {
    //     return $this->hasMany(Product::class, 'category_id');
    // }
}