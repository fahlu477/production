<?php

namespace App\Exports;

use Auth;
use App\MasterLine;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MasterLineExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $branch = Auth::user()->branch;
        $branch_detail = Auth::user()->branchdetail;
        $data = MasterLine::where('branch', $branch)
                ->where('branch_detail', $branch_detail)->get();

        return $data;
    }
    public function headings(): array
    {
        return [
            'ID',
            'Kode_Line',
            'Nama_Line',
            'Pabrik',
            'Detail_Pabrik',
            'Created_at',
            'Updated_at'
        ];
    }
}
