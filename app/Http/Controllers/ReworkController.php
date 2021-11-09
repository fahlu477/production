<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use DataTables;
use App\LineDetail;
use App\MasterLine;
use App\LineToUser;
use App\LineToTarget;
use Illuminate\Http\Request;

class ReworkController extends Controller
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
    
    public function qc()
    {
        
        return view('qc/index');
    }

    public function index()
    {
        return view('qc/rework/home');
    }

    public function master()
    {
       
        $data = MasterLine::all();
        $member = User::where('role', 'QCR_OP')->get();
        $dataLuser = [];
        
        foreach ($data as $key => $value) {
            foreach ($value->luser as $key => $value1) {
                $dataLuser[] = [
                    'id' => $value1->id,
                    'line' => $value->string1,
                    'nama_line' => $value->string2,
                    'id_line' => $value->id,
                    'anggota' => $value1->id_user,
                    'created' => $value1->created_by,
                    'edited' => $value1->edited_by,
                ];
            }
        }

        return view('qc/rework/qc/index', compact('data','dataLuser', 'member'));
    }

    public function take(Request $request, $id)
    {
        //    Untuk tabel tugas hari ini 
        $todayDate = date("Y-m-d");
        $dataLine = MasterLine::with('luser')->get();
        $data = LineToTarget::
                where('id_line', $id)
                ->get();
        // dd($data);
        $dataTarget = [];
        $kode_line = '';
        foreach ($data as $key => $value) {
            if($value->tgl_pengerjaan == $todayDate || $value->tgl_pengerjaan2 == $todayDate || $value->tgl_pengerjaan3 == $todayDate){
                foreach ($dataLine as $key => $value1) {
                    if ($value->id_line == $value1->id  ) {
                        $dataTarget[] = [
                            'id' => $value->id,
                            'line' => $value1->id,
                            'id_line' => $value1->string1,
                            $kode_line = $value1->string1,
                            'tgl_pengerjaan' => $value->tgl_pengerjaan,
                            'tgl_pengerjaan2' => $value->tgl_pengerjaan2,
                            'tgl_pengerjaan3' => $value->tgl_pengerjaan3,
                            'no_wo' => $value->no_wo,
                            'order_quantity' => $value->order_quantity,
                            'target_wo' => $value->target_wo,
                            'proses' => $value->proses,
                        ];
                    }
                }
            }
        }

        // dd($kode_line);
        if ($request->ajax()) {
            return Datatables::of($dataTarget)
                    ->editColumn('id_line', function($row){
                        $line = MasterLine::where('id', $row['id_line'])->get()->toArray();
                        foreach ($line as $key => $value) {
                            return $value['string1'];
                        }
                    })
                    ->addColumn('action', function($row){
   
                        $btn = '<a href="' . route('ltarget.edit', $row->id) .'" class="btn btn-warning btn-sm">'.'<i class="fas fa-edit"></i>Edit'.'</a>';
                        
                        return $btn;
                            
                    })
                    ->editColumn('proses', function($row){
                        return view('rework.ltarget.atribut.proses', compact('row'));
                    })
                    ->make(true);
        }
         //    End 

        //  Untuk History 
        $lastweek = date("Y-m-d",strtotime("-8 days"));
        $history = LineToTarget::
                where('id_line', $id)
                ->where('tgl_pengerjaan','<', $todayDate)
                ->where('tgl_pengerjaan','>', $lastweek)
                ->where('proses',2)
                ->get();
        $dataHistory = [];
        foreach ($history as $key => $value) {
            foreach ($dataLine as $key => $value1) {
                if ($value->id_line == $value1->id ) {
                    $dataHistory[] = [
                        'id' => $value->id,
                        'line' => $value1->id,
                        'id_line' => $value1->string1,
                        'tgl_pengerjaan' => $value->tgl_pengerjaan,
                        'tgl_pengerjaan2' => $value->tgl_pengerjaan2,
                        'tgl_pengerjaan3' => $value->tgl_pengerjaan3,
                        'no_wo' => $value->no_wo,
                        'order_quantity' => $value->order_quantity,
                        'target_wo' => $value->target_wo,
                        'proses' => $value->proses,
                    ];
                }
            }
        }
        // End 
        return view('qc/rework/qc/today', compact('dataTarget', 'dataHistory', 'kode_line'));
    }

    public function lanjutkan(Request $request, $id)
    {
        $kerjakan = LineToTarget::findOrFail($id);

        if (auth()->user()->branch == 'CLN' && auth()->user()->branchdetail == 'CLN') {
            return redirect()->route('detail.manual', $kerjakan->id);
        }
        elseif (auth()->user()->branch == 'MAJA' && auth()->user()->branchdetail == 'GM1') {
            return redirect()->route('detail.manual', $kerjakan->id);
        }
        elseif (auth()->user()->branch == 'MAJA' && auth()->user()->branchdetail == 'GM2') {
            return redirect()->route('detail.manual', $kerjakan->id);
        }else{
            return view('qc/rework/qc/sukses', compact('kerjakan'));
        }
    }

    public function kerjakan(Request $request, $id)
    {
        
        // ubah proses id di tabel rework_ltarget
        $update = [
            'proses' => $request->proses
        ];
        LineToTarget::whereId($id)->update($update);
        // end ubah proses 

        if(
            LineDetail::where('target_id', $request->target_id)->where('tgl_pengerjaan', $request->tgl_pengerjaan)->where('id_line', $request->id_line)
            ->where('no_wo', $request->no_wo)->count()
        ) throw new \Exception('Proses simpan ditolak. Data terdaftar');


        // create defaul value di tabel rework_detail
        $input = [
            'target_id' => $request->target_id,
            'tgl_pengerjaan' => $request->tgl_pengerjaan,
            'id_line' => $request->id_line,
            'no_wo' => $request->no_wo,
            'target_wo' => $request->target_wo,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $show = LineDetail::create($input);
        // end create default value 

        $kerjakan = LineToTarget::findOrFail($id);

        if (auth()->user()->branch == 'CLN' && auth()->user()->branchdetail == 'CLN') {
            return redirect()->route('detail.manual', $kerjakan->id);
        }
        elseif (auth()->user()->branch == 'MAJA' && auth()->user()->branchdetail == 'GM1') {
            return redirect()->route('detail.manual', $kerjakan->id);
        }
        elseif (auth()->user()->branch == 'MAJA' && auth()->user()->branchdetail == 'GM2') {
            return redirect()->route('detail.manual', $kerjakan->id);
        }else{
            return view('qc/rework/qc/sukses', compact('kerjakan'));
        }
    }

    public function pindah(Request $request, $id)
    {
        // ubah proses id di tabel rework_ltarget
        $update = [
            'proses' => $request->proses,
        ];
        LineToTarget::whereId($id)->update($update);
        // end 

        $kerjakan = LineToTarget::findOrFail($id);
        if(
            LineDetail::where('target_id', $request->target_id)->where('tgl_pengerjaan', $request->tgl_pengerjaan)->where('id_line', $request->id_line)
            ->where('no_wo', $request->no_wo)->count()
        ) 
            if (auth()->user()->branch == 'CLN' && auth()->user()->branchdetail == 'CLN') {
                return redirect()->route('detail.manual', $kerjakan->id);
            }
            elseif (auth()->user()->branch == 'MAJA' && auth()->user()->branchdetail == 'GM1') {
                return redirect()->route('detail.manual', $kerjakan->id);
            }
            elseif (auth()->user()->branch == 'MAJA' && auth()->user()->branchdetail == 'GM2') {
                return redirect()->route('detail.manual', $kerjakan->id);
            }else{
            return view('qc/rework/qc/sukses', compact('kerjakan')); 
            }

        // create defaul value di tabel rework_detail
        $input = [
            'target_id' => $request->target_id,
            'tgl_pengerjaan' => $request->tgl_pengerjaan,
            'id_line' => $request->id_line,
            'no_wo' => $request->no_wo,
            'target_wo' => $request->target_wo,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $show = LineDetail::create($input);

        if (auth()->user()->branch == 'CLN' && auth()->user()->branchdetail == 'CLN') {
            return redirect()->route('detail.manual', $kerjakan->id);
        }
        elseif (auth()->user()->branch == 'MAJA' && auth()->user()->branchdetail == 'GM1') {
            return redirect()->route('detail.manual', $kerjakan->id);
        }
        elseif (auth()->user()->branch == 'MAJA' && auth()->user()->branchdetail == 'GM2') {
            return redirect()->route('detail.manual', $kerjakan->id);
        }else{
           return view('qc/rework/qc/sukses', compact('kerjakan')); 
        }
    }

    public function selesai(Request $request, $id)
    {
       
        // untuk update proses menjadi selesai di table target 
        $target = $request->target_id;
        $update = [
            'proses' => $request->proses,
        ];

        LineToTarget::whereId($target)->update($update);
        // End

        $kerjakan = LineDetail::findOrFail($id);

        // dd($kerjakan);
        
        return view('qc/rework/qc/selesai', compact('kerjakan'));

    }
}
