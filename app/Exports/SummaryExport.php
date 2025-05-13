<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use App\Services\PurchaseOrderService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SummaryExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $summary = (new PurchaseOrderService)->summary();
        return new Collection([
            array_values($summary)
        ]);
    }

    public function headings(): array
    {
        return [
            'Total Items',
            'Total Purchase Orders',
            'Approved Orders',
            'Rejected Orders',
            'Pending Orders',
            'Total Stock Value',
        ];
    }
}
