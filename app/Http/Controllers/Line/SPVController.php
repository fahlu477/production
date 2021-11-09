<?php

namespace App\Http\Controllers\Line;

use DB;
use Auth;
use DataTables;
use App\LineDetail;
use App\MasterLine;
use App\LineToTarget;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SPVController extends Controller
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
   
                        $btn = '<a href="' . route('spv.see', $row['id']) .'" class="btn btn-primary btn-sm">'.'<i class="fas fa-eye"></i> Lihat'.'</a>';
                        
                        return $btn;
                            
                    })
                    ->make(true);
        }

        return view('qc/rework/spv/index');                   
   }

   public function see(Request $request, $id)
   {
        // untuk kode line dan id line yg di blade 
        $line = MasterLine::with('luser')->findOrFail($id);
        // End 

        $data = LineToTarget::with('detail')
                    ->where('spv_app', 0)
                    ->where('id_line', $id)
                    ->where('proses', 2)
                    ->get();
        

        return view('qc/rework/spv/see', compact('data', 'line'));                   
   }

   public function final(Request $request, $id)
   {
        // untuk kode line dan id line yg di blade 
        $line = MasterLine::with('luser')->findOrFail($id);
        // End 

        $data = LineToTarget::with('detail')
                    ->where('spv_app','!=', 0)
                    ->where('id_line', $id)
                    ->where('proses', 2)
                    ->get();
        
        return view('qc/rework/spv/final', compact('data', 'line'));                   
   }

   public function approve(Request $request)
    {
        $id = $request->id;
        $update = [
            'spv_app' => $request->spv_app,
            'spv_name' => $request->spv_name,
        ];

        LineToTarget::whereId($id)->update($update);

        // dd($request);
        return redirect()->back();   
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
        
        return view('qc/rework/spv/detail', compact('dataDetail','id'));
    }

    public function edit(Request $request, $id)
    {
        $kerjakan = LineDetail::findOrFail($id);

        return view('qc/rework/spv/edit', compact('kerjakan'));

    }

    public function update(Request $request)
    {
        $id = $request->id;
        $target_id = $request->target_id;
        $terpenuhi = $request->fg + $request->ip + $request->sticker + $request->meas + $request->trimming+
                    $request->other + $request->ros + $request->broken + $request->skip + $request->pktw + $request->crooked +
                    $request->pleated + $request->htl + $request->button + $request->print + $request->shading +
                    $request->dof + $request->dirty + $request->shiny + $request->bs + $request->unb;
        if ($terpenuhi <= $request->target_wo) {
            $update = [
                'fg' => $request->fg,
                'p_fg' => round($request->fg/$terpenuhi*100,2),
                'ip' => $request->ip,
                'p_ip' => round($request->ip/$terpenuhi*100,2),
                'sticker' => $request->sticker,
                'p_sticker' => round($request->sticker/$terpenuhi*100,2),
                'meas' => $request->meas,
                'p_meas' => round($request->meas/$terpenuhi*100,2),
                'trimming' => $request->trimming,
                'p_trimming' => round($request->trimming/$terpenuhi*100,2),
                'other' => $request->other,
                'p_other' => round($request->other/$terpenuhi*100,2),
                'ros' => $request->ros,
                'p_ros' => round($request->ros/$terpenuhi*100,2),
                'broken' => $request->broken,
                'p_broken' => round($request->broken/$terpenuhi*100,2),
                'skip' => $request->skip,
                'p_skip' => round($request->skip/$terpenuhi*100,2),
                'pktw' => $request->pktw,
                'p_pktw' => round($request->pktw/$terpenuhi*100,2),
                'crooked' => $request->crooked,
                'p_crooked' => round($request->crooked/$terpenuhi*100,2),
                'pleated' => $request->pleated,
                'p_pleated' => round($request->pleated/$terpenuhi*100,2),
                'htl' => $request->htl,
                'p_htl' => round($request->htl/$terpenuhi*100,2),
                'button' => $request->button,
                'p_button' => round($request->button/$terpenuhi*100,2),
                'print' => $request->print,
                'p_print' => round($request->print/$terpenuhi*100,2),
                'shading' => $request->shading,
                'p_shading' => round($request->shading/$terpenuhi*100,2),
                'dof' => $request->dof,
                'p_dof' => round($request->dof/$terpenuhi*100,2),
                'dirty' => $request->dirty,
                'p_dirty' => round($request->dirty/$terpenuhi*100,2),
                'shiny' => $request->shiny,
                'p_shiny' => round($request->shiny/$terpenuhi*100,2),
                'bs' => $request->bs,
                'p_bs' => round($request->bs/$terpenuhi*100,2),
                'unb' => $request->unb,
                'p_unb' => round($request->unb/$terpenuhi*100,2),
                'target_terpenuhi' => $terpenuhi,
                'total_check' => $terpenuhi,
                'total_reject' => $terpenuhi - $request->fg,
                'p_reject' => round(($terpenuhi - $request->fg)/$terpenuhi*100,2),
                'string1' => $request->string1,
                'edited_by' => $request->edited_by,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            LineDetail::whereId($id)->update($update);
        
            return redirect()->route('spv.show', $target_id);
        }

        throw new \Exception('Nilai yang dimasukan melebihi target WO!');
    }

}
