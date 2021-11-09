<?php

namespace App\Exports;

use App\JdeApi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WoExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return JdeApi::select('F4801_DOCO', 'F4801_AITM', 'F4801_DL01', 'F4801_RORN', 'F4801_UORG', 'F4801_SOQS')->get();
    }
    public function headings(): array
    {
        return [
            'NO WO',
            '2nd Ite,',
            'Item Description',
            'NO SO',
            'Order Quantity',
            'Quantity Shipped',
        ];
    }
}
