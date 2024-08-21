<?php

namespace App\Exports;

use App\Models\ProductCategory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class CategoriesExport implements FromCollection, WithHeadings, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return ProductCategory::select('name', 'description')->get()
            ->map(function ($category) {
                $category->description = strip_tags($category->description);
                return $category;
            });
    }

    public function headings(): array
    {
        return [
            'Name',
            'Description'
        ];
    }

    public function title(): string
    {
        return 'CATEGORIES';
    }
}
