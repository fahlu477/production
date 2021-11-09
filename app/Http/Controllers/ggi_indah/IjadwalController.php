<?php

namespace App\Http\Controllers\ggi_indah;

use DB;
use Auth;
use App\User;
use App\IndahVote;
use App\IndahJPiket;
use App\IndahKaryawan;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IjadwalController extends Controller
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
    
    public function jadwal(Request $request)
    {
        // get data semua aktif
       
        $data = IndahJPiket::orderBy('id', 'asc')->get();
        ($data);
        // mengambil data karyawan yang akan ditampilkan di views
        $datapiket = [];
        foreach ($data as $key => $value) {
            $datapiket[] =  [
                'id' => $value->id,
                'day' => $value->day,
                'hari' => $value->hari,
                'petugas1' => $value->petugas1,
                'petugas2' => $value->petugas2,
                'petugas3' => $value->petugas3,
                'petugas4' => $value->petugas4,
                'petugas5' => $value->petugas5,
                'petugas6' => $value->petugas6,
                'petugas7' => $value->petugas7,
                'petugas8' => $value->petugas8,
                'petugas9' => $value->petugas9,
                'petugas10' => $value->petugas10,
               
            ];
        }
        
        if ($request->ajax()) {
            return Datatables::of($datapiket)
            ->addIndexColumn()
            ->addColumn('action', function($row){

                $btn = '<a href="' . route('piket.edit', $row['id']) .'" class="edit btn btn-primary btn-sm" title="Edit"><i class="fas fa-edit"></i></a>';
             // $btn = '<a href="' .  .'" class="edit btn btn-primary btn-sm" title="Edit"><i class="fas fa-edit"></i></a>';
                return $btn;
                    
            })
            ->rawColumns(['action'])
            ->make(true);
        
        }
        
        return view('indah/jpiket/see', compact('data'));
    }
    public function edit($id)
        {
            $data = IndahJPiket::findOrFail($id);
            $karyawan = User::all();
            $petugas = IndahKaryawan::all();
            $satgas = [];
            
            foreach ($karyawan as $key => $value) {
                foreach ($petugas as $key2 => $value2) {
                    if ($value->nik == $value2->nik) {
                        $satgas[] = [
                            'nik' => $value2->nik,
                            'nama' => $value->nama
                        ];
                    }
                }
            }
            // dd($satgas);
           // $user = User::where('nik','=',$petugas->nik)->get();
    
            return view('indah/jpiket/edit', compact('data','id','petugas', 'satgas'));
        }

    public function update(Request $request)
        {
            $id = $request->id;
            // dd($id);
            $validatedData = [
                'petugas1' => $request->petugas1,
                'petugas2' => $request->petugas2,
                'petugas3' => $request->petugas3,
                'petugas4' => $request->petugas4,
                'petugas5' => $request->petugas5,
                'petugas6' => $request->petugas6,
                'petugas7' => $request->petugas7,
                'petugas8' => $request->petugas8,
                'petugas9' => $request->petugas9,
                'petugas10' => $request->petugas10,
                
            ];
    
            IndahJPiket::whereId($id)->update($validatedData);
    
            return redirect()->route('Jindah.index')->with('success', 'Satgas is successfully updated');
        }
   
        

}
