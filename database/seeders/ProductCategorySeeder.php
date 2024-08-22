<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Solid State Drives',
            'Desktop POS',
            'Computers',
            'Laptops',
            'Asus Laptops',
            'Mounting Brackets',
            'Dell Monitors',
            'Dell Laptops',
            'Dell Accessories',
            'Hp Laptops',
            'Hp Monitors',
            'Hp Accessories',
            'Lenovo Laptops',
            'Lenovo Monitors',
            'Lenovo Accessories',
            'Printers & Consumables',
            'RAM',
            'Storage',
            'Hard Disk Drive',
            'Flash Drives',
            'Accessories',
            'Monitors'
        ];

        foreach ($categories as $category) {
            DB::table('product_categories')->insert([
                'name' => $category,
                'description' => strtolower($category),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}