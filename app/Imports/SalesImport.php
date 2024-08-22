<?php

namespace App\Imports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;

class SalesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        Log::info('ROW');
        Log::info($row);
        Sale::create([
            'category_id'         => $row['category_id'],
            'product_id'          => $row['product_id'],
            'warranty_start_date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['warranty_start_date']),
            'warranty_end_date'   => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['warranty_end_date']),
            'qr_code'             => $row['qr_code'],
            'description'         => $row['description'],
            'sku'                 => $row['sku'],
            'created_at'          => now(),
            'updated_at'          => now(),
        ]);
    }
}
