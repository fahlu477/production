<?php

namespace App\Http\Controllers\Line;

use DB;
use Auth;
use DataTables;
use App\JdeApi;
use Carbon\Carbon;
use App\LineDetail;
use App\MasterLine;
use App\LineToTarget;
use App\WOBreakDown;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LineToTargetController extends Controller
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
        $mline = MasterLine::with('ltarget', 'luser')
                ->where('branch', Auth::user()->branch)
                ->where('branch_detail', Auth::user()->branchdetail)
                ->get();
        $data = [];
        foreach ($mline as $key => $value) {
            $data[] = [
                'id' => $value->id,
                'kode_line' => $value->string1,
                'nama_line' => $value->string2,
            ];
        }

        if ($request->ajax()) {
            return Datatables::of($data)
                    ->addColumn('action', function($row){
   
                        $btn = '<a href="' . route('ltarget.see', $row['id']) .'" class="btn btn-primary btn-sm">'.'<i class="fas fa-eye"></i> Lihat'.'</a>';
                        
                        return $btn;
                            
                    })
                    ->make(true);
        }
        return view('qc/rework/ltarget/index');
    }

    public function see(Request $request, $id)
    {
        // untuk function tambahHari 
        $todayDate = date("Y-m-d");

        // untuk kode line dan id line yg di blade 
        $line = MasterLine::with('luser')->findOrFail($id);
        // End 

        $mline = MasterLine::with('ltarget')
                ->where('branch', Auth::user()->branch)
                ->where('branch_detail', Auth::user()->branchdetail)
                ->where('id', $id)
                ->get();
        $data = [];
        
        foreach ($mline as $key => $value) {
            foreach ($value->ltarget as $key => $value1) {
                $terpenuhi = LineDetail::where('target_id', $value1->id)->sum('target_terpenuhi');
                if ($value1->spv_app == 0) {
                     $data[] = [
                        'kode_line' => $value->string1,
                        'id' => $value1->id,
                        'tgl_input' => $value1->tgl_input,
                        'tgl_pengerjaan' => (new Carbon($value1->tgl_pengerjaan))->format('d-m-Y'),
                        'tgl_pengerjaan2' => (new Carbon($value1->tgl_pengerjaan2))->format('d-m-Y'),
                        'id_line' => $value1->id_line,
                        'no_wo' => $value1->no_wo,
                        'order_quantity' => $value1->order_quantity,
                        'target_wo' => $value1->target_wo,
                        'target_terpenuhi' => $terpenuhi,
                        'proses' => $value1->proses,
                        'detail_id' => $value1->detail_id,
                        'spv_app' => $value1->spv_app,
                        'spv_name' => $value1->spv_name,
                        'created_by' => $value1->created_by,
                        'edited_by' => $value1->edited_by
                    ]; 
                }
              
            }
        }

        return view('qc/rework/ltarget/see', compact('data', 'line', 'todayDate'));
    }

    public function tambahHari(Request $request, $id)
    {
        if ($request->target_wo != 0) {
            $target_id = $request->id;
            // ubah tanggal akhir id di tabel rework_ltarget
            $update = [
                'tgl_pengerjaan2' => $request->tgl_pengerjaan2
            ];
            LineToTarget::whereId($target_id)->update($update);
            // end ubah proses

            if(
                LineDetail::where('target_id', $request->target_id)->where('tgl_pengerjaan', $request->tgl_pengerjaan)->where('id_line', $request->id_line)
                ->where('no_wo', $request->no_wo)->count()
            ) throw new \Exception('Proses simpan ditolak. Data terdaftar');

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
            
            return  redirect()->route('ltarget.summary', $id);        
        }

        throw new \Exception('Target WO tidak boleh 0 !');
    }

    public function search($id)
    {
        $id_line = $id;
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
        return view('qc/rework/ltarget/search', compact('dataWo', 'id'));
    
    }

    public function get(Request $request)
    {
        $mline = MasterLine::findOrFail($request->id_line);
        $id = $request->no_wo;

        $todayDate = date("Y-m-d");

        // get data masterline 
        $line =  MasterLine::with('ltarget')
                            ->where('branch', Auth::user()->branch)
                            ->where('branch_detail', Auth::user()->branchdetail)
                            ->get();

        // get data wo dan breakdown                  
        $data = JdeApi::Where('F4801_DOCO', $id)
        ->with('wobreakdown')
        ->get(); 
        // end

        // untuk list pilihan yang di form add 
        $dataWo = [];
        // end 

        foreach ($data as $key => $value) {
            $dataWo[] = [
                'no_wo' => $value->F4801_DOCO,
                'order_quantity' => $value->F4801_UORG,
               ];
        }

        return view('qc/rework/ltarget/add', compact('mline','line', 'dataWo', 'todayDate'));
    }

    public function store(Request $request, $id)
    {
        $input = $request->all();
        if ($request->target_wo != 0) {
            if(
                LineToTarget::where('id_line', $request->id_line)->where('no_wo', $request->no_wo)->where('target_wo', $request->target_wo)->count()
            ) throw new \Exception('Proses simpan ditolak. Data terdaftar');
            
            LineToTarget::create($input);
            
            return  redirect()->route('ltarget.see', $id);
        }

        throw new \Exception('Target WO tidak boleh bernilai 0 !');
    }

    public function edit($id)
    {
        $data = LineToTarget::findOrFail($id);

        if ($data->proses != 2) {

            $line =  MasterLine::with('ltarget')
            ->where('branch', Auth::user()->branch)
            ->where('branch_detail', Auth::user()->branchdetail)
            ->get();

            return view('qc/rework/ltarget/edit', compact('data','id', 'line'));
        }
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        // perintah untuk update 
        $target_id = $request->id;
        $update = [
            'target_wo' => $request['target_wo'],
            'edited_by' => $request['edited_by'],
            'updated_at' => date('Y-m-d H:i:s')
        ];

        LineToTarget::whereId($target_id)->update($update);
        // end perintah update

        return  redirect()->route('ltarget.see', $id);
    }
    
    public function show(Request $request, $id)
    {
        $detail = LineToTarget::with('detail')
                ->where('id', $id)
                ->get();
        $dataDetail = [];
        foreach ($detail as $key => $value) {
            foreach ($value['detail'] as $key => $value1) {
                $dataDetail[] = [
                    'id' => $value1->id,
                    'target_id' => $value1->target_id,
                    'no_wo' => $value1->no_wo,
                    'id_line' => $value1->id_line,
                    'target_wo' => $value1->target_wo,
                    'target_terpenuhi' => $value1->target_terpenuhi,
                    'tgl_pengerjaan' => $value1->tgl_pengerjaan,
                    'fg' => $value1->fg,
                    'ip' => $value1->ip,
                    'sticker' => $value1->sticker,
                    'meas' => $value1->meas,
                    'trimming' => $value1->trimming,
                    'other' => $value1->other,
                    'ros' => $value1->ros,
                    'broken' => $value1->broken,
                    'skip' => $value1->skip,
                    'pktw' => $value1->pktw,
                    'crooked' => $value1->crooked,
                    'pleated' => $value1->pleated,
                    'htl' => $value1->htl,
                    'button' => $value1->button,
                    'print' => $value1->print,
                    'shading' => $value1->shading,
                    'dof' => $value1->dof,
                    'dirty' => $value1->dirty,
                    'shiny' => $value1->shiny,
                    'bs' => $value1->bs,
                    'unb' => $value1->unb,
                    'file' => $value1->file,
                    'string1' => $value1->string1,
                    'edited_by' => $value1->edited_by,
                    'created_by' => $value1->created_by,
                ];
            }
        }
        
        return view('qc/rework/ltarget/detail', compact('dataDetail','id'));
    }
    public function summary(Request $request, $id)
    {
        
        $target = LineToTarget::findorfail($id);

        // untuk function tambahHari 
        $todayDate = date("Y-m-d");

        // untuk detail 
        $detail = LineDetail::where('target_id', $id)->get();

        $data= [];
        foreach ($detail as $key => $value) {
            $data[] = [
                'detail_id' => $value->id,
                'id_line' => $value->id_line,
                'id' => $value->target_id,
                'tgl_pengerjaan' => (new Carbon($value->tgl_pengerjaan))->format('d-m-Y'),
                'no_wo' => $value->no_wo,
                'target_wo' => $value->target_wo,
                'target_terpenuhi' => $value->target_terpenuhi,
                'sisa' => ($value->target_wo - $value->target_terpenuhi)
            ];
        }

        return view('qc/rework/ltarget/summary', compact('target', 'data', 'todayDate'));

    }

    public function summarydetail(Request $request, $id)
    {
        $detail = LineDetail::findorfail($id);
        
        return view('qc/rework/ltarget/summaryDetail', compact('detail'));
    }

    public function tambah($id)
    {
        $target = LineToTarget::findorfail($id);
        $todayDate = date("Y-m-d");
        
        return view('qc/rework/ltarget/tambahHari', compact('target', 'todayDate'));
    }

    public function delete($id)
    {
        $ltarget = LineToTarget::findOrFail($id);
        $ltarget->delete();
        
        return back();
    }

}
