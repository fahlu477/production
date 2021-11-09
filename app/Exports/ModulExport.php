<?php

namespace App\Exports;

use App\Modul;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ModulExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Modul::all();
    }
    public function headings(): array
    {
        return [
            'ID',
            'Kode',
            'Nama',
            'Created at',
            'Updated at'
        ];
    }
}
