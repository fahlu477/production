<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\JdeApi;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KaryawanController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        // get data semua aktif
        $data = User::all();

        // mengambil data karyawan yang akan ditampilkan di views
        $dataKaryawan = [];
        foreach ($data as $key => $value) {
            $dataKaryawan[] = [
                'nik' => $value->nik,
                'nama' => $value->nama,
                'bagian' => $value->departemensubsub,
                'jabatan' => $value->jabatan,
                'branch' => $value->branch,
                'branchdetail' => $value->branchdetail,
                'role' => $value->role,
                'status' => $value->isaktif,
            ];
        }
        if ($request->ajax()) {
            return Datatables::of($dataKaryawan)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                           $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm" title="Edit"><i class="fas fa-edit"></i></a>';
       
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('sys_admin/index', compact('data'));
    }

    public function masterwo(Request $request)
    {
        $wo = new JdeApi;
        $wo->setConnection('mysql2');
        $arr_wo = $wo->all();
        $dataWo = [];
        foreach ($arr_wo as $key => $value) {
            $dataWo[] = [
                'no_wo' => $value->F4801_DOCO,
                'second_item' => $value->F4801_AITM,
                'item_description' => $value->F4801_DL01,
                'order_quantity' => $value->F4801_UORG,
                'quantity_shipped' => $value->F4801_SOQS,
                'no_so' => $value->F4801_RORN,
            ];
        }

        if ($request->ajax()) {
            return Datatables::of($dataWo)
                ->addColumn('detail', function($row){
                    return view('qc.rework.wo.atribut.btn_detail', compact('row'));
                })
                ->make(true);
        }
      
        return view('sys_admin/masterwo');
    }

}
