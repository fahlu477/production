<?php

namespace App\Http\Controllers\ggi_indah;

use DB;
use Auth;
use App\User;
use App\IndahVote;
use App\IndahKaryawan;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IpetugasController extends Controller
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
    
    public function petugas(Request $request)
    {
        // get data semua aktif
        $data = IndahKaryawan::all();
        //$nik = user::where('nik','=','110078')->first('nama');
       /// $a= $nik->nama;
        //dd($a);
        //dd($data);
        // mengambil data karyawan yang akan ditampilkan di views
        $dataKaryawan = [];
        foreach ($data as $key => $value) {
          // $nik = user::where('nik','=',$value->nik)->first('nama');  
           //$nama= $nik->nama;
          // dd ($nama);
            $dataKaryawan[] = [
                'id' => $value->id,
                'nik' => $value->nik,
                'jabatan' => $value->jabatan,
                'nama' => $value->nama,
                'kuota_like' => $value->kuota_like,
                'kuota_dislike' => $value->kuota_dislike,
               // 'a'=>$nama,
                //'nama'=> $nik,
               
            ];
        }
        
        if ($request->ajax()) {
            return Datatables::of($dataKaryawan)
            ->addIndexColumn()
            ->addColumn('action', function($row){

                $btn = '<a href="' . route('satgas.edit', $row['id']) .'" class="edit btn btn-primary btn-sm" title="Edit"><i class="fas fa-edit"></i></a>';
             // $btn = '<a href="' .  .'" class="edit btn btn-primary btn-sm" title="Edit"><i class="fas fa-edit"></i></a>';
                return $btn;
                    
            })
            ->rawColumns(['action'])
            ->make(true);
        
        }
        
        return view('indah/satgas/see', compact('data'));
    }
    public function create(Request $request)
        {  
            $user = User::all();
           
        
            return view('indah/satgas/addsatgas', compact('user'));
        }

    public function store(Request $request){
            
        $user = User::all();
        
       
      
        $input = $request->all();
        IndahKaryawan::create($input);
                        
            return redirect()->route('Pindah.index')->with('success', 'Satgas is successfully saved');      
                
        }
    public function edit($id)
        {
            $data = IndahKaryawan::findOrFail($id);
            
    
            return view('indah/satgas/edit', compact('data','id'));
        }

    public function update(Request $request)
        {
            $id = $request->id;
            // dd($id);
            $validatedData = [
                'kuota_like' => $request->kuota_like,
                'kuota_dislike' => $request->kuota_dislike,
                'jabatan' => $request->jabatan,
            ];
    
            IndahKaryawan::whereId($id)->update($validatedData);
    
            return redirect()->route('Pindah.index')->with('success', 'Satgas is successfully updated');
        }

    public function delete($id)
        {
            $Ipetugas = IndahKaryawan::findOrFail($id);
            $Ipetugas->delete();
            
            return back();
        }
    

}
