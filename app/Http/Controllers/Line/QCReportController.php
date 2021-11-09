<?php

namespace App\Http\Controllers\Line;

use PDF;
use App\Branch;
use App\User;
use DataTables;
use Carbon\Carbon;
use App\LineDetail;
use App\MasterLine;
use App\LineToTarget;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QCReportController extends Controller
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
    
    public function rharian(Request $request)
    {
        $dataBranch = Branch::all();
        return view('qc/rework/report/harian', compact('dataBranch'));
    }

    public function harianGet(Request $request)
    {   
        $dataBranch = Branch::findorfail($request->branch);
        $tanggal = $request->tanggal;
        $tanggal_depan = (new Carbon($request->tanggal))->format('d-m-Y');

        if(
            LineDetail::where('tgl_pengerjaan', $tanggal)->count()
        ) {

        // data pertama  
        $data =  MasterLine::with('ltarget')
                ->where('branch', $dataBranch->kode_branch)
                ->where('branch_detail', $dataBranch->branchdetail)
                ->get();

        $dataDetail = [];
        foreach ($data as $key => $value) {
           foreach ($value->ltarget as $key => $value2) {
              foreach ($value2->detail as $key => $value3) {
                  $wo = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->count('no_wo');
                  if ($value3->tgl_pengerjaan == $tanggal) {
                        $dataDetail[] = [
                            'jumlah_wo' => $wo,
                            'id_line' => $value->id,
                            'line' => $value->string1,
                            'no_wo' => $value3->no_wo,
                            'target_terpenuhi' => $value3->target_terpenuhi,
                            'fg' => $value3->fg,
                            'p_fg' => $value3->p_fg,
                            'broken' => $value3->broken,
                            'p_broken' =>  $value3->p_broken,
                            'skip' => $value3->skip,
                            'p_skip' =>  $value3->p_skip,
                            'pktw' => $value3->pktw,
                            'p_pktw' =>  $value3->p_pktw,
                            'crooked' => $value3->crooked,
                            'p_crooked' =>  $value3->p_crooked,
                            'pleated' => $value3->pleated,
                            'p_pleated' =>  $value3->p_pleated,
                            'ros' => $value3->ros,
                            'p_ros' =>  $value3->p_ros,
                            'htl' => $value3->htl,
                            'p_htl' =>  $value3->p_htl,
                            'button' => $value3->button,
                            'p_button' =>  $value3->p_button,
                            'print' => $value3->print,
                            'p_print' =>  $value3->p_print,
                            'bs' => $value3->bs,
                            'p_bs' =>  $value3->p_bs,
                            'unb' => $value3->unb,
                            'p_unb' =>  $value3->p_unb,
                            'shading' => $value3->shading,
                            'p_shading' =>  $value3->p_shading,
                            'dof' => $value3->dof,
                            'p_dof' =>  $value3->p_dof,
                            'dirty' => $value3->dirty,
                            'p_dirty' =>  $value3->p_dirty,
                            'shiny' => $value3->shiny,
                            'p_shiny' =>  $value3->p_shiny,
                            'sticker' => $value3->sticker,
                            'p_sticker' =>  $value3->p_sticker,
                            'trimming' => $value3->trimming,
                            'p_trimming' =>  $value3->p_trimming,
                            'ip' => $value3->ip,
                            'p_ip' =>  $value3->p_ip,
                            'meas' => $value3->meas,
                            'p_meas' =>  $value3->p_meas,
                            'other' => $value3->other,
                            'p_other' =>  $value3->p_other,
                            'tot_reject' => $value3->total_reject,
                            'p_tot_reject' => $value3->p_reject,
                            'tot_check' => $value3->total_check,
                            'remark' => $value3->string1,
                            'file' => $value3->file
                        ];
                  }
              }
           }
        }
        $result = collect($dataDetail)->groupBy('line')->toArray();
        // end data pertama

        // Untuk mendapat data total 
        $detail = LineDetail::where('tgl_pengerjaan', $tanggal)->get();
        $dataTotal = [];
        foreach ($data as $key => $value) {
            foreach ($detail as $key => $value2) {
                if ($value->id == $value2->id_line) {
                    // penjumlahan data tiap variable 
                    $terpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('target_terpenuhi');
                    $total_check = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('total_check');
                    $total_reject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('total_reject');
                    $fg = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('fg');
                    $broken = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('broken');
                    $skip = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('skip');
                    $pktw = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('pktw');
                    $crooked = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('crooked');
                    $pleated = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('pleated');
                    $ros = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('ros');
                    $htl = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('htl');
                    $button = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('button');
                    $print = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('print');
                    $bs = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('bs');
                    $unb = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('unb');
                    $shading = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('shading');
                    $dof = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('dof');
                    $dirty = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('dirty');
                    $shiny = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('shiny');
                    $sticker = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('sticker');
                    $trimming = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('trimming');
                    $ip = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('ip');
                    $meas = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('meas');
                    $other = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('other');
                    if($terpenuhi == 0){
                        $p_fg = 0;
                        $p_broken = 0;
                        $p_skip = 0;
                        $p_pktw = 0;
                        $p_crooked = 0;
                        $p_pleated = 0;
                        $p_ros = 0;
                        $p_htl = 0;
                        $p_button = 0;
                        $p_print = 0;
                        $p_bs = 0;
                        $p_unb = 0;
                        $p_shading = 0;
                        $p_dof = 0;
                        $p_dirty = 0;
                        $p_shiny = 0;
                        $p_sticker = 0;
                        $p_trimming = 0;
                        $p_ip = 0;
                        $p_meas = 0;
                        $p_other = 0;
                        $p_reject = 0;
                        $p_reject = 0;
                    }else{
                        $p_fg =  round($fg / $terpenuhi *100,2);
                        $p_broken =  round($broken / $terpenuhi *100,2);
                        $p_skip =  round($skip / $terpenuhi *100,2);
                        $p_pktw =  round($pktw / $terpenuhi *100,2);
                        $p_crooked =  round($crooked / $terpenuhi *100,2);
                        $p_pleated =  round($pleated / $terpenuhi *100,2);
                        $p_ros =  round($ros / $terpenuhi *100,2);
                        $p_htl =  round($htl / $terpenuhi *100,2);
                        $p_button =  round($button / $terpenuhi *100,2);
                        $p_print =  round($print / $terpenuhi *100,2);
                        $p_bs =  round($bs / $terpenuhi *100,2);
                        $p_unb =  round($unb / $terpenuhi *100,2);
                        $p_shading =  round($shading / $terpenuhi *100,2);
                        $p_dof =  round($dof / $terpenuhi *100,2);
                        $p_dirty =  round($dirty / $terpenuhi *100,2);
                        $p_shiny =  round($shiny / $terpenuhi *100,2);
                        $p_sticker =  round($sticker / $terpenuhi *100,2);
                        $p_trimming =  round($trimming / $terpenuhi *100,2);
                        $p_ip =  round($ip / $terpenuhi *100,2);
                        $p_meas =  round($meas / $terpenuhi *100,2);
                        $p_other =  round($other / $terpenuhi *100,2);
                        $p_reject = round($total_reject/$terpenuhi*100,2);
                    }
                    // Data untuk ditampilkan ke blade 
                    $dataTotal[] = [
                        'terpenuhi' => $terpenuhi,
                        'id_line' => $value->id,
                        'line' => $value->string1,
                        'fg_all' => $fg,
                        'total_fg' => $p_fg,
                        'broken_all' => $broken,
                        'total_broken' => $p_broken,
                        'skip_all' => $skip,
                        'total_skip' => $p_skip,
                        'pktw_all' => $pktw,
                        'total_pktw' => $p_pktw,
                        'crooked_all' => $crooked,
                        'total_crooked' => $p_crooked,
                        'pleated_all' => $pleated,
                        'total_pleated' => $p_pleated,
                        'ros_all' => $ros,
                        'total_ros' => $p_ros,
                        'htl_all' => $htl,
                        'total_htl' => $p_htl,
                        'button_all' => $button,
                        'total_button' => $p_button,
                        'print_all' => $print,
                        'total_print' => $p_print,
                        'bs_all' => $bs,
                        'total_bs' => $p_bs,
                        'unb_all' => $unb,
                        'total_unb' => $p_unb,
                        'shading_all' => $shading,
                        'total_shading' => $p_shading,
                        'dof_all' => $dof,
                        'total_dof' => $p_dof,
                        'dirty_all' => $dirty,
                        'total_dirty' => $p_dirty,
                        'shiny_all' => $shiny,
                        'total_shiny' => $p_shiny,
                        'sticker_all' => $sticker,
                        'total_sticker' => $p_sticker,
                        'trimming_all' => $trimming,
                        'total_trimming' => $p_trimming,
                        'ip_all' => $ip,
                        'total_ip' => $p_ip,
                        'meas_all' => $meas,
                        'total_meas' => $p_meas,
                        'other_all' => $other,
                        'total_other' => $p_other,
                        'total_reject' => $total_reject,
                        'total_check' => $total_check,
                        'p_total_reject' => $p_reject
                    ];
                }
            }
        }
        $TotalResult = collect($dataTotal)
                ->groupBy('line')
                ->map(function ($item) {
                    return array_merge(...$item->toArray());
                })->values()->toArray();
        // end data total

        // Untuk mendapat total all line 
        $semua_terpenuhi = collect($TotalResult)->sum('terpenuhi');
        if($semua_terpenuhi == 0){
            $tot_fg = 0;
            $tot_broken = 0;
            $tot_skip = 0;
            $tot_pktw = 0;
            $tot_crooked = 0;
            $tot_pleated = 0;
            $tot_ros = 0;
            $tot_htl = 0;
            $tot_button = 0;
            $tot_print = 0;
            $tot_bs = 0;
            $tot_unb = 0;
            $tot_shading = 0;
            $tot_dof = 0;
            $tot_dirty = 0;
            $tot_shiny = 0;
            $tot_sticker = 0;
            $tot_trimming = 0;
            $tot_ip = 0;
            $tot_meas = 0;
            $tot_other = 0;
            $p_total_reject = 0;
        }else{
            $tot_fg =  round(collect($TotalResult)->sum('fg_all') / $semua_terpenuhi *100,2);
            $tot_broken =  round(collect($TotalResult)->sum('broken_all') / $semua_terpenuhi *100,2);
            $tot_skip =  round(collect($TotalResult)->sum('skip_all') / $semua_terpenuhi *100,2);
            $tot_pktw =  round(collect($TotalResult)->sum('pktw_all') / $semua_terpenuhi *100,2);
            $tot_crooked =  round(collect($TotalResult)->sum('crooked_all') / $semua_terpenuhi *100,2);
            $tot_pleated =  round(collect($TotalResult)->sum('pleated_all') / $semua_terpenuhi *100,2);
            $tot_ros =  round(collect($TotalResult)->sum('ros_all') / $semua_terpenuhi *100,2);
            $tot_htl =  round(collect($TotalResult)->sum('htl_all') / $semua_terpenuhi *100,2);
            $tot_button =  round(collect($TotalResult)->sum('button_all') / $semua_terpenuhi *100,2);
            $tot_print =  round(collect($TotalResult)->sum('print_all') / $semua_terpenuhi *100,2);
            $tot_bs =  round(collect($TotalResult)->sum('bs_all') / $semua_terpenuhi *100,2);
            $tot_unb =  round(collect($TotalResult)->sum('unb_all') / $semua_terpenuhi *100,2);
            $tot_shading =  round(collect($TotalResult)->sum('shading_all') / $semua_terpenuhi *100,2);
            $tot_dof =  round(collect($TotalResult)->sum('dof_all') / $semua_terpenuhi *100,2);
            $tot_dirty =  round(collect($TotalResult)->sum('dirty_all') / $semua_terpenuhi *100,2);
            $tot_shiny =  round(collect($TotalResult)->sum('shiny_all') / $semua_terpenuhi *100,2);
            $tot_sticker =  round(collect($TotalResult)->sum('sticker_all') / $semua_terpenuhi *100,2);
            $tot_trimming =  round(collect($TotalResult)->sum('trimming_all') / $semua_terpenuhi *100,2);
            $tot_ip =  round(collect($TotalResult)->sum('ip_all') / $semua_terpenuhi *100,2);
            $tot_meas =  round(collect($TotalResult)->sum('meas_all') / $semua_terpenuhi *100,2);
            $tot_other =  round(collect($TotalResult)->sum('other_all') / $semua_terpenuhi *100,2);
            $p_total_reject = round(collect($TotalResult)->sum('total_reject') / $semua_terpenuhi *100,2);
        }
        $totalSemuaLine = [
            'fg' => collect($TotalResult)->sum('fg_all') ,
            'tot_fg' => $tot_fg,
            'broken' => collect($TotalResult)->sum('broken_all') ,
            'tot_broken' => $tot_broken,
            'skip' => collect($TotalResult)->sum('skip_all'),
            'tot_skip' => $tot_skip,
            'pktw' => collect($TotalResult)->sum('pktw_all'),
            'tot_pktw' => $tot_pktw,
            'crooked' => collect($TotalResult)->sum('crooked_all'),
            'tot_crooked' => $tot_crooked,
            'pleated' => collect($TotalResult)->sum('pleated_all'),
            'tot_pleated' => $tot_pleated,
            'ros' => collect($TotalResult)->sum('ros_all'),
            'tot_ros' => $tot_ros,
            'htl' => collect($TotalResult)->sum('htl_all'),
            'tot_htl' => $tot_htl,
            'button' => collect($TotalResult)->sum('button_all'),
            'tot_button' => $tot_button,
            'print' => collect($TotalResult)->sum('print_all'),
            'tot_print' => $tot_print,
            'bs' => collect($TotalResult)->sum('bs_all'),
            'tot_bs' => $tot_bs,
            'unb' => collect($TotalResult)->sum('unb_all'),
            'tot_unb' => $tot_unb,
            'shading' => collect($TotalResult)->sum('shading_all'),
            'tot_shading' => $tot_shading,
            'dof' => collect($TotalResult)->sum('dof_all'),
            'tot_dof' => $tot_dof,
            'dirty' => collect($TotalResult)->sum('dirty_all'),
            'tot_dirty' => $tot_dirty,
            'shiny' => collect($TotalResult)->sum('shiny_all'),
            'tot_shiny' => $tot_shiny,
            'sticker' => collect($TotalResult)->sum('sticker_all'),
            'tot_sticker' => $tot_sticker,
            'trimming' => collect($TotalResult)->sum('trimming_all'),
            'tot_trimming' => $tot_trimming,
            'ip' => collect($TotalResult)->sum('ip_all'),
            'tot_ip' => $tot_ip,
            'meas' => collect($TotalResult)->sum('meas_all'),
            'tot_meas' => $tot_meas,
            'other' => collect($TotalResult)->sum('other_all'),
            'tot_other' => $tot_other,
            'total_reject' => collect($TotalResult)->sum('total_reject'),
            'p_total_reject' => $p_total_reject,
            'total_check' => collect($TotalResult)->sum('total_check')
        ];
  
        return view('qc/rework/report/detailHarian', compact('result', 'TotalResult', 'tanggal_depan','tanggal' , 'dataBranch', 'totalSemuaLine'));
        }else{
            throw new \Exception('Data Kosong !');
        }
    }

    public function harianPDF(Request $request)
    {
        $dataBranch = Branch::findorfail($request->branch);
        $tanggal = $request->tanggal;
        $tanggal_depan = (new Carbon($request->tanggal))->format('d-m-Y');

        // untuk filter branch
        if ($request->branch == 'CLN') {
            $branch = 'CLN';
            $branch_detail = 'CLN';
        }elseif($request->branch == 'MAJA1'){
            $branch = 'MAJA';
            $branch_detail = 'GM1';
        }elseif($request->branch == 'MAJA2'){
            $branch = 'MAJA';
            $branch_detail = 'GM2';
        }
        elseif($request->branch == 'GS'){
            $branch = 'GS';
            $branch_detail = 'GS';
        }elseif($request->branch == 'GK'){
            $branch = 'GK';
            $branch_detail = 'GK';
        }
        // end 

        // data pertama  
        $data =  MasterLine::where('branch', $dataBranch->kode_branch)
                ->where('branch_detail', $dataBranch->branchdetail)
                ->get();
        

        $dataDetail = [];
        foreach ($data as $key => $value) {
           foreach ($value->ltarget as $key => $value2) {
              foreach ($value2->detail as $key => $value3) {
                  $wo = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->count('no_wo');
                  if ($value3->tgl_pengerjaan == $tanggal) {
                        $dataDetail[] = [
                            'jumlah_wo' => $wo,
                            'id_line' => $value->id,
                            'line' => $value->string1,
                            'no_wo' => $value3->no_wo,
                            'target_terpenuhi' => $value3->target_terpenuhi,
                            'fg' => $value3->fg,
                            'p_fg' => $value3->p_fg,
                            'broken' => $value3->broken,
                            'p_broken' =>  $value3->p_broken,
                            'skip' => $value3->skip,
                            'p_skip' =>  $value3->p_skip,
                            'pktw' => $value3->pktw,
                            'p_pktw' =>  $value3->p_pktw,
                            'crooked' => $value3->crooked,
                            'p_crooked' =>  $value3->p_crooked,
                            'pleated' => $value3->pleated,
                            'p_pleated' =>  $value3->p_pleated,
                            'ros' => $value3->ros,
                            'p_ros' =>  $value3->p_ros,
                            'htl' => $value3->htl,
                            'p_htl' =>  $value3->p_htl,
                            'button' => $value3->button,
                            'p_button' =>  $value3->p_button,
                            'print' => $value3->print,
                            'p_print' =>  $value3->p_print,
                            'bs' => $value3->bs,
                            'p_bs' =>  $value3->p_bs,
                            'unb' => $value3->unb,
                            'p_unb' =>  $value3->p_unb,
                            'shading' => $value3->shading,
                            'p_shading' =>  $value3->p_shading,
                            'dof' => $value3->dof,
                            'p_dof' =>  $value3->p_dof,
                            'dirty' => $value3->dirty,
                            'p_dirty' =>  $value3->p_dirty,
                            'shiny' => $value3->shiny,
                            'p_shiny' =>  $value3->p_shiny,
                            'sticker' => $value3->sticker,
                            'p_sticker' =>  $value3->p_sticker,
                            'trimming' => $value3->trimming,
                            'p_trimming' =>  $value3->p_trimming,
                            'ip' => $value3->ip,
                            'p_ip' =>  $value3->p_ip,
                            'meas' => $value3->meas,
                            'p_meas' =>  $value3->p_meas,
                            'other' => $value3->other,
                            'p_other' =>  $value3->p_other,
                            'tot_reject' => $value3->total_reject,
                            'p_tot_reject' => $value3->p_reject,
                            'tot_check' => $value3->total_check,
                            'remark' => $value3->string1,
                            'file' => $value3->file
                        ];
                  }
              }
           }
        }
        $result = collect($dataDetail)->groupBy('line')->toArray();
        // end data pertama

        // Untuk mendapat data total 
        $detail = LineDetail::where('tgl_pengerjaan', $tanggal)->get();
        $dataTotal = [];
        foreach ($data as $key => $value) {
            foreach ($detail as $key => $value2) {
                if ($value->id == $value2->id_line) {
                    // penjumlahan data tiap variable 
                    $terpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('target_terpenuhi');
                    $total_check = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('total_check');
                    $total_reject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('total_reject');
                    $fg = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('fg');
                    $broken = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('broken');
                    $skip = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('skip');
                    $pktw = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('pktw');
                    $crooked = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('crooked');
                    $pleated = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('pleated');
                    $ros = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('ros');
                    $htl = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('htl');
                    $button = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('button');
                    $print = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('print');
                    $bs = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('bs');
                    $unb = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('unb');
                    $shading = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('shading');
                    $dof = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('dof');
                    $dirty = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('dirty');
                    $shiny = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('shiny');
                    $sticker = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('sticker');
                    $trimming = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('trimming');
                    $ip = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('ip');
                    $meas = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('meas');
                    $other = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('other');
                    if($terpenuhi == 0){
                        $p_fg = 0;
                        $p_broken = 0;
                        $p_skip = 0;
                        $p_pktw = 0;
                        $p_crooked = 0;
                        $p_pleated = 0;
                        $p_ros = 0;
                        $p_htl = 0;
                        $p_button = 0;
                        $p_print = 0;
                        $p_bs = 0;
                        $p_unb = 0;
                        $p_shading = 0;
                        $p_dof = 0;
                        $p_dirty = 0;
                        $p_shiny = 0;
                        $p_sticker = 0;
                        $p_trimming = 0;
                        $p_ip = 0;
                        $p_meas = 0;
                        $p_other = 0;
                        $p_reject = 0;
                        $p_reject = 0;
                    }else{
                        $p_fg =  round($fg / $terpenuhi *100,2);
                        $p_broken =  round($broken / $terpenuhi *100,2);
                        $p_skip =  round($skip / $terpenuhi *100,2);
                        $p_pktw =  round($pktw / $terpenuhi *100,2);
                        $p_crooked =  round($crooked / $terpenuhi *100,2);
                        $p_pleated =  round($pleated / $terpenuhi *100,2);
                        $p_ros =  round($ros / $terpenuhi *100,2);
                        $p_htl =  round($htl / $terpenuhi *100,2);
                        $p_button =  round($button / $terpenuhi *100,2);
                        $p_print =  round($print / $terpenuhi *100,2);
                        $p_bs =  round($bs / $terpenuhi *100,2);
                        $p_unb =  round($unb / $terpenuhi *100,2);
                        $p_shading =  round($shading / $terpenuhi *100,2);
                        $p_dof =  round($dof / $terpenuhi *100,2);
                        $p_dirty =  round($dirty / $terpenuhi *100,2);
                        $p_shiny =  round($shiny / $terpenuhi *100,2);
                        $p_sticker =  round($sticker / $terpenuhi *100,2);
                        $p_trimming =  round($trimming / $terpenuhi *100,2);
                        $p_ip =  round($ip / $terpenuhi *100,2);
                        $p_meas =  round($meas / $terpenuhi *100,2);
                        $p_other =  round($other / $terpenuhi *100,2);
                        $p_reject = round($total_reject/$terpenuhi*100,2);
                    }
                    // Data untuk ditampilkan ke blade 
                    $dataTotal[] = [
                        'terpenuhi' => $terpenuhi,
                        'id_line' => $value->id,
                        'line' => $value->string1,
                        'fg_all' => $fg,
                        'total_fg' => $p_fg,
                        'broken_all' => $broken,
                        'total_broken' => $p_broken,
                        'skip_all' => $skip,
                        'total_skip' => $p_skip,
                        'pktw_all' => $pktw,
                        'total_pktw' => $p_pktw,
                        'crooked_all' => $crooked,
                        'total_crooked' => $p_crooked,
                        'pleated_all' => $pleated,
                        'total_pleated' => $p_pleated,
                        'ros_all' => $ros,
                        'total_ros' => $p_ros,
                        'htl_all' => $htl,
                        'total_htl' => $p_htl,
                        'button_all' => $button,
                        'total_button' => $p_button,
                        'print_all' => $print,
                        'total_print' => $p_print,
                        'bs_all' => $bs,
                        'total_bs' => $p_bs,
                        'unb_all' => $unb,
                        'total_unb' => $p_unb,
                        'shading_all' => $shading,
                        'total_shading' => $p_shading,
                        'dof_all' => $dof,
                        'total_dof' => $p_dof,
                        'dirty_all' => $dirty,
                        'total_dirty' => $p_dirty,
                        'shiny_all' => $shiny,
                        'total_shiny' => $p_shiny,
                        'sticker_all' => $sticker,
                        'total_sticker' => $p_sticker,
                        'trimming_all' => $trimming,
                        'total_trimming' => $p_trimming,
                        'ip_all' => $ip,
                        'total_ip' => $p_ip,
                        'meas_all' => $meas,
                        'total_meas' => $p_meas,
                        'other_all' => $other,
                        'total_other' => $p_other,
                        'total_reject' => $total_reject,
                        'total_check' => $total_check,
                        'p_total_reject' => $p_reject
                    ];
                }
            }
        }
        $TotalResult = collect($dataTotal)
                ->groupBy('line')
                ->map(function ($item) {
                    return array_merge(...$item->toArray());
                })->values()->toArray();
        // end data total

        // Untuk mendapat total all line 
        $semua_terpenuhi = collect($TotalResult)->sum('terpenuhi');
        $totalSemuaLine = [
            'fg' => collect($TotalResult)->sum('fg_all') ,
            'tot_fg' => round(collect($TotalResult)->sum('fg_all') / $semua_terpenuhi *100,2),
            'broken' => collect($TotalResult)->sum('broken_all'),
            'tot_broken' => round(collect($TotalResult)->sum('broken_all') / $semua_terpenuhi *100,2),
            'skip' => collect($TotalResult)->sum('skip_all'),
            'tot_skip' => round(collect($TotalResult)->sum('skip_all') / $semua_terpenuhi *100,2),
            'pktw' => collect($TotalResult)->sum('pktw_all'),
            'tot_pktw' => round(collect($TotalResult)->sum('pktw_all') / $semua_terpenuhi *100,2),
            'crooked' => collect($TotalResult)->sum('crooked_all'),
            'tot_crooked' => round(collect($TotalResult)->sum('crooked_all') / $semua_terpenuhi *100,2),
            'pleated' => collect($TotalResult)->sum('pleated_all'),
            'tot_pleated' => round(collect($TotalResult)->sum('pleated_all') / $semua_terpenuhi *100,2),
            'ros' => collect($TotalResult)->sum('ros_all'),
            'tot_ros' => round(collect($TotalResult)->sum('ros_all') / $semua_terpenuhi *100,2),
            'htl' => collect($TotalResult)->sum('htl_all'),
            'tot_htl' => round(collect($TotalResult)->sum('htl_all') / $semua_terpenuhi *100,2),
            'button' => collect($TotalResult)->sum('button_all'),
            'tot_button' => round(collect($TotalResult)->sum('button_all') / $semua_terpenuhi *100,2),
            'print' => collect($TotalResult)->sum('print_all'),
            'tot_print' => round(collect($TotalResult)->sum('print_all') / $semua_terpenuhi *100,2),
            'bs' => collect($TotalResult)->sum('bs_all'),
            'tot_bs' => round(collect($TotalResult)->sum('bs_all') / $semua_terpenuhi *100,2),
            'unb' => collect($TotalResult)->sum('unb_all'),
            'tot_unb' => round(collect($TotalResult)->sum('unb_all') / $semua_terpenuhi *100,2),
            'shading' => collect($TotalResult)->sum('shading_all'),
            'tot_shading' => round(collect($TotalResult)->sum('shading_all')/ $semua_terpenuhi *100,2),
            'dof' => collect($TotalResult)->sum('dof_all'),
            'tot_dof' => round(collect($TotalResult)->sum('dof_all') / $semua_terpenuhi *100,2),
            'dirty' => collect($TotalResult)->sum('dirty_all'),
            'tot_dirty' => round(collect($TotalResult)->sum('dirty_all') / $semua_terpenuhi *100,2),
            'shiny' => collect($TotalResult)->sum('shiny_all'),
            'tot_shiny' => round(collect($TotalResult)->sum('shiny_all') / $semua_terpenuhi *100,2),
            'sticker' => collect($TotalResult)->sum('sticker_all'),
            'tot_sticker' => round(collect($TotalResult)->sum('sticker_all') / $semua_terpenuhi *100,2),
            'trimming' => collect($TotalResult)->sum('trimming_all'),
            'tot_trimming' => round(collect($TotalResult)->sum('trimming_all') / $semua_terpenuhi *100,2),
            'ip' => collect($TotalResult)->sum('ip_all'),
            'tot_ip' => round(collect($TotalResult)->sum('ip_all') / $semua_terpenuhi *100,2),
            'meas' => collect($TotalResult)->sum('meas_all'),
            'tot_meas' => round(collect($TotalResult)->sum('meas_all') / $semua_terpenuhi *100,2),
            'other' => collect($TotalResult)->sum('other_all'),
            'tot_other' => round(collect($TotalResult)->sum('other_all') / $semua_terpenuhi *100,2),
            'total_reject' => collect($TotalResult)->sum('total_reject'),
            'p_total_reject' => round(collect($TotalResult)->sum('total_reject') / $semua_terpenuhi *100,2),
            'total_check' => collect($TotalResult)->sum('total_check')
        ];

        $pdf = PDF::loadview('qc/rework/report/harian_pdf', compact('tanggal_depan', 'result', 'TotalResult', 'tanggal' , 'dataBranch', 'totalSemuaLine'))->setPaper('legal', 'landscape');
        return $pdf->stream();
    }

    public function rbulanan()
    {
        $dataBranch = Branch::all();
        return view('qc/rework/report/bulanan', compact('dataBranch'));
    }
    public function get(Request $request)
	{   

        // untuk filter branch
        $dataBranch = Branch::findorfail($request->branch);
        $bulan = $request->bulan;
        // end 
        $bulan = $request->bulan;
        // buat bulan 
        $month = Carbon::createFromFormat('Y-m', $bulan)->firstOfMonth()->format('m');
        if ($month == '01') {
            $kodeBulan = 'JANUARI';
        }elseif ($month == '02') {
            $kodeBulan = 'FEBRUARI';
        }elseif ($month == '03') {
            $kodeBulan = 'MARET';
        }elseif ($month == '04') {
            $kodeBulan = 'APRIL';
        }elseif ($month == '05') {
            $kodeBulan = 'MEI';
        }elseif ($month == '06') {
            $kodeBulan = 'JUNI';
        }elseif ($month == '07') {
            $kodeBulan = 'JULI';
        }elseif ($month == '08') {
            $kodeBulan = 'AGUSTUS';
        }elseif ($month == '09') {
            $kodeBulan = 'SEPTEMBER';
        }elseif ($month == '10') {
            $kodeBulan = 'OKTOBER';
        }elseif ($month == '11') {
            $kodeBulan = 'NOVEMBER';
        }elseif ($month == '02') {
            $kodeBulan = 'DESEMBER';
        }

        $tanggal_awal = Carbon::createFromFormat('Y-m', $bulan)->firstOfMonth()->format('d-m-Y');
        $tanggal_akhir = Carbon::createFromFormat('Y-m', $bulan)->endOfMonth()->format('d-m-Y');
        $FirstDate = Carbon::createFromFormat('Y-m', $bulan)->firstOfMonth()->format('Y-m-d'); 
        $LastDate = Carbon::createFromFormat('Y-m', $bulan)->endOfMonth()->format('Y-m-d'); 

        // untuk mendapat data pertama 
        $data =  MasterLine::with('ltarget')
                ->where('branch', $dataBranch->kode_branch)
                ->where('branch_detail', $dataBranch->branchdetail)
                ->get();
        $detail = LineDetail::where('tgl_pengerjaan', '>=' , $FirstDate)->where('tgl_pengerjaan', '<=' , $LastDate)->get();


        $dataResult = [];
        foreach ($data as $key => $value) {
            foreach ($value->ltarget as $key2 => $value2) {
                foreach ($value2->detail as $key3 => $value3) {
                    $dataResult[] = [
                        'id_'=> $value3->id,
                        'id_line' => $value3->id_line,
                        'target_terpenuhi' => $value3->target_terpenuhi,
                        'file' => $value3->file,
                        'no_wo' => $value3->no_wo,
                        'tgl_pengerjaan' => $value3->tgl_pengerjaan,
                        'fg' => $value3->fg,
                        'tot_fg' => $value3->p_fg,
                        'broken' => $value3->broken,
                        'tot_broken' => $value3->p_broken,
                        'skip' => $value3->skip,
                        'tot_skip' => $value3->p_skip,
                        'pktw' => $value3->pktw,
                        'tot_pktw' => $value3->p_pktw,
                        'crooked' => $value3->crooked,
                        'tot_crooked' => $value3->p_crooked,
                        'pleated' => $value3->pleated,
                        'tot_pleated' => $value3->p_pleated,
                        'ros' => $value3->ros,
                        'tot_ros' => $value3->p_ros,
                        'htl' => $value3->htl,
                        'tot_htl' => $value3->p_htl,
                        'button' => $value3->button,
                        'tot_button' => $value3->p_button,
                        'print' => $value3->print,
                        'tot_print' => $value3->p_print,
                        'bs' => $value3->bs,
                        'tot_bs' => $value3->p_bs,
                        'unb' => $value3->unb,
                        'tot_unb' => $value3->p_unb,
                        'shading' => $value3->shading,
                        'tot_shading' => $value3->p_shading,
                        'dof' => $value3->dof,
                        'tot_dof' => $value3->p_dof,
                        'dirty' => $value3->dirty,
                        'tot_dirty' => $value3->p_dirty,
                        'shiny' => $value3->shiny,
                        'tot_shiny' => $value3->p_shiny,
                        'sticker' => $value3->sticker,
                        'tot_sticker' => $value3->p_sticker,
                        'trimming' => $value3->trimming,
                        'tot_trimming' => $value3->p_trimming,
                        'ip' => $value3->ip,
                        'tot_ip' => $value3->p_ip,
                        'meas' => $value3->meas,
                        'tot_meas' => $value3->p_meas,
                        'other' => $value3->other,
                        'tot_other' => $value3->p_other,
                        'total_reject' => $value3->total_reject,
                        'p_total_reject' => $value3->p_reject,
                        'total_check' => $value3->total_check,
                        'remark' => $value3->string1
                    ];
                }
            }
        }
        $percobaan =   collect($dataResult)->sortBy('tgl_pengerjaan')->groupBy('tgl_pengerjaan');
        $TotalResult = [];
        foreach ($percobaan as $key => $value) {
            $xremark = collect($dataResult)->where('tgl_pengerjaan', $key)->where('remark','!=', null)->implode('remark', ' | ');
            $cterpenuhi = $value->sum('target_terpenuhi');
            $creject = $value->sum('total_reject');
            $ccheck = $value->sum('total_check');
            $fg = $value->sum('fg');
            $broken = $value->sum('broken');
            $skip = $value->sum('skip');
            $pktw = $value->sum('pktw');
            $crooked = $value->sum('crooked');
            $pleated = $value->sum('pleated');
            $ros = $value->sum('ros');
            $htl = $value->sum('htl');
            $button = $value->sum('button');
            $print = $value->sum('print');
            $bs = $value->sum('bs');
            $unb = $value->sum('unb');
            $shading = $value->sum('shading');
            $dof = $value->sum('dof');
            $dirty = $value->sum('dirty');
            $shiny = $value->sum('shiny');
            $sticker = $value->sum('sticker');
            $trimming = $value->sum('trimming');
            $ip = $value->sum('ip');
            $meas = $value->sum('meas');
            $other = $value->sum('other');
            if($cterpenuhi == 0){
                $tot_fg = 0;
                $tot_broken = 0;
                $tot_skip = 0;
                $tot_pktw = 0;
                $tot_crooked = 0;
                $tot_pleated = 0;
                $tot_ros = 0;
                $tot_htl = 0;
                $tot_button = 0;
                $tot_print = 0;
                $tot_bs = 0;
                $tot_unb = 0;
                $tot_shading = 0;
                $tot_dof = 0;
                $tot_dirty = 0;
                $tot_shiny = 0;
                $tot_sticker = 0;
                $tot_trimming = 0;
                $tot_ip = 0;
                $tot_meas = 0;
                $tot_other = 0;
                $tot_total_reject = 0;
            }else{
                $tot_fg =  round($fg / $cterpenuhi *100,2);
                $tot_broken =  round($broken / $cterpenuhi *100,2);
                $tot_skip =  round($skip / $cterpenuhi *100,2);
                $tot_pktw =  round($pktw / $cterpenuhi *100,2);
                $tot_crooked =  round($crooked / $cterpenuhi *100,2);
                $tot_pleated =  round($pleated / $cterpenuhi *100,2);
                $tot_ros =  round($ros / $cterpenuhi *100,2);
                $tot_htl =  round($htl / $cterpenuhi *100,2);
                $tot_button =  round($button / $cterpenuhi *100,2);
                $tot_print =  round($print / $cterpenuhi *100,2);
                $tot_bs =  round($bs / $cterpenuhi *100,2);
                $tot_unb =  round($unb / $cterpenuhi *100,2);
                $tot_shading =  round($shading / $cterpenuhi *100,2);
                $tot_dof =  round($dof / $cterpenuhi *100,2);
                $tot_dirty =  round($dirty / $cterpenuhi *100,2);
                $tot_shiny =  round($shiny / $cterpenuhi *100,2);
                $tot_sticker =  round($sticker / $cterpenuhi *100,2);
                $tot_trimming =  round($trimming / $cterpenuhi *100,2);
                $tot_ip =  round($ip / $cterpenuhi *100,2);
                $tot_meas =  round($meas / $cterpenuhi *100,2);
                $tot_other =  round($other / $cterpenuhi *100,2);
                $tot_total_reject = round($creject / $cterpenuhi *100,2);
            }
            $TotalResult[] = [
                'target_terpenuhi' => $cterpenuhi,
                'total_check' => $ccheck,
                'total_reject' => $creject,
                'tgl_pengerjaan' => $key,
                'fg' => $fg,
                'tot_fg' => $tot_fg,
                'broken' => $broken,
                'tot_broken' => $tot_broken,
                'skip' => $skip,
                'tot_skip' => $tot_skip,
                'pktw' => $pktw,
                'tot_pktw' => $tot_pktw,
                'crooked' => $crooked,
                'tot_crooked' => $tot_crooked,
                'pleated' => $pleated,
                'tot_pleated' => $tot_pleated,
                'ros' => $ros,
                'tot_ros' => $tot_ros,
                'htl' => $htl,
                'tot_htl' => $tot_htl,
                'button' => $button,
                'tot_button' => $tot_button,
                'print' => $print,
                'tot_print' => $tot_print,
                'bs' => $bs,
                'tot_bs' => $tot_bs,
                'unb' => $unb,
                'tot_unb' => $tot_unb,
                'shading' => $shading,
                'tot_shading' => $tot_shading,
                'dof' => $dof,
                'tot_dof' => $tot_dof,
                'dirty' => $dirty,
                'tot_dirty' => $tot_dirty,
                'shiny' => $shiny,
                'tot_shiny' => $tot_shiny,
                'sticker' => $sticker,
                'tot_sticker' => $tot_sticker,
                'trimming' => $trimming,
                'tot_trimming' => $tot_trimming,
                'ip' => $ip,
                'tot_ip' => $tot_ip,
                'meas' => $meas,
                'tot_meas' => $tot_meas,
                'other' => $other,
                'tot_other' => $tot_other,
                'p_total_reject' => $tot_total_reject,
                'remark' => $xremark
            ];
        }
        // end data pertama 

        // untuk mendapat data total
        $semua_terpenuhi = collect($TotalResult)->sum('target_terpenuhi');
        if ($semua_terpenuhi == 0 || $semua_terpenuhi == null) {
            $tot_fg = 0;
            $tot_broken = 0;
            $tot_skip = 0;
            $tot_pktw = 0;
            $tot_crooked = 0;
            $tot_pleated = 0;
            $tot_ros = 0;
            $tot_htl = 0;
            $tot_button = 0;
            $tot_print = 0;
            $tot_bs = 0;
            $tot_unb = 0;
            $tot_shading = 0;
            $tot_dof = 0;
            $tot_dirty = 0;
            $tot_shiny = 0;
            $tot_sticker = 0;
            $tot_trimming = 0;
            $tot_ip = 0;
            $tot_meas = 0;
            $tot_other = 0;
            $p_total_reject = 0;
        }else{
            $tot_fg =round( collect($TotalResult)->sum('fg') / $semua_terpenuhi *100,2);
            $tot_broken =round( collect($TotalResult)->sum('broken') / $semua_terpenuhi *100,2);
            $tot_skip =round(collect($TotalResult)->sum('skip') / $semua_terpenuhi *100,2);
            $tot_pktw =round(collect($TotalResult)->sum('pktw') / $semua_terpenuhi *100,2);
            $tot_crooked = round(collect($TotalResult)->sum('crooked') / $semua_terpenuhi *100,2);
            $tot_pleated = round(collect($TotalResult)->sum('pleated') / $semua_terpenuhi *100,2);
            $tot_ros = round(collect($TotalResult)->sum('ros') / $semua_terpenuhi *100,2);
            $tot_htl = round(collect($TotalResult)->sum('htl') / $semua_terpenuhi *100,2);
            $tot_button = round(collect($TotalResult)->sum('button') / $semua_terpenuhi *100,2);
            $tot_print = round(collect($TotalResult)->sum('print') / $semua_terpenuhi *100,2);
            $tot_bs = round(collect($TotalResult)->sum('bs') / $semua_terpenuhi *100,2);
            $tot_unb = round(collect($TotalResult)->sum('unb') / $semua_terpenuhi *100,2);
            $tot_shading = round(collect($TotalResult)->sum('shading') / $semua_terpenuhi *100,2);
            $tot_dof = round(collect($TotalResult)->sum('dof') / $semua_terpenuhi *100,2);
            $tot_dirty = round(collect($TotalResult)->sum('dirty') / $semua_terpenuhi *100,2);
            $tot_shiny = round(collect($TotalResult)->sum('shiny') / $semua_terpenuhi *100,2);
            $tot_sticker = round(collect($TotalResult)->sum('sticker') / $semua_terpenuhi *100,2);
            $tot_trimming = round(collect($TotalResult)->sum('trimming') / $semua_terpenuhi *100,2);
            $tot_ip = round(collect($TotalResult)->sum('ip') / $semua_terpenuhi *100,2);
            $tot_meas = round(collect($TotalResult)->sum('meas') / $semua_terpenuhi *100,2);
            $tot_other = round(collect($TotalResult)->sum('other') / $semua_terpenuhi *100,2);
            $p_total_reject = round(collect($TotalResult)->sum('total_reject') / $semua_terpenuhi *100, 2);
        }
        $TotalAllLine[] = [
            'target_terpenuhi' => $semua_terpenuhi,
            'fg' =>  collect($TotalResult)->sum('fg'),
            'tot_fg' => $tot_fg,
            'broken' =>  collect($TotalResult)->sum('broken'),
            'tot_broken' => $tot_broken,
            'skip' => collect($TotalResult)->sum('skip'),
            'tot_skip' => $tot_skip,
            'pktw' => collect($TotalResult)->sum('pktw'),
            'tot_pktw' => $tot_pktw,
            'crooked' => collect($TotalResult)->sum('crooked'),
            'tot_crooked' => $tot_crooked,
            'pleated' => collect($TotalResult)->sum('pleated'),
            'tot_pleated' => $tot_pleated,
            'ros' => collect($TotalResult)->sum('ros'),
            'tot_ros' => $tot_ros,
            'htl' => collect($TotalResult)->sum('htl'),
            'tot_htl' => $tot_htl,
            'button' => collect($TotalResult)->sum('button'),
            'tot_button' => $tot_button,
            'print' => collect($TotalResult)->sum('print'),
            'tot_print' => $tot_print,
            'bs' => collect($TotalResult)->sum('bs'),
            'tot_bs' => $tot_bs,
            'unb' => collect($TotalResult)->sum('unb'),
            'tot_unb' => $tot_unb,
            'shading' => collect($TotalResult)->sum('shading'),
            'tot_shading' => $tot_shading,
            'dof' => collect($TotalResult)->sum('dof'),
            'tot_dof' => $tot_dof,
            'dirty' => collect($TotalResult)->sum('dirty'),
            'tot_dirty' => $tot_dirty,
            'shiny' => collect($TotalResult)->sum('shiny'),
            'tot_shiny' => $tot_shiny,
            'sticker' => collect($TotalResult)->sum('sticker'),
            'tot_sticker' => $tot_sticker,
            'trimming' => collect($TotalResult)->sum('trimming'),
            'tot_trimming' => $tot_trimming,
            'ip' => collect($TotalResult)->sum('ip'),
            'tot_ip' => $tot_ip,
            'meas' => collect($TotalResult)->sum('meas'),
            'tot_meas' => $tot_meas,
            'other' => collect($TotalResult)->sum('other'),
            'tot_other' => $tot_other,
            'total_reject' => collect($TotalResult)->sum('total_reject'),
            'p_total_reject' => $p_total_reject,
            'total_check' => collect($TotalResult)->sum('total_check')
        ];
        $totalLine = $TotalAllLine[0];
        // biar remark nya kebawa semua 
        $dataRemark = collect($dataResult)->where('remark', '!=', null)->implode('remark', ' | ');
        // end data total

		return view('qc/rework/report/rbulanan', compact('kodeBulan','tanggal_awal', 'tanggal_akhir', 'dataRemark','totalLine','TotalResult', 'dataResult', 'dataBranch', 'FirstDate', 'LastDate', 'bulan'));
    }
    
    public function bulananPDF(Request $request)
    {
        // untuk filter branch
        $dataBranch = Branch::findorfail($request->branch);
        $bulan = $request->bulan;
        // end 
        $bulan = $request->bulan;
        // buat bulan 
        $month = Carbon::createFromFormat('Y-m', $bulan)->firstOfMonth()->format('m');
        if ($month == '01') {
            $kodeBulan = 'JANUARI';
        }elseif ($month == '02') {
            $kodeBulan = 'FEBRUARI';
        }elseif ($month == '03') {
            $kodeBulan = 'MARET';
        }elseif ($month == '04') {
            $kodeBulan = 'APRIL';
        }elseif ($month == '05') {
            $kodeBulan = 'MEI';
        }elseif ($month == '06') {
            $kodeBulan = 'JUNI';
        }elseif ($month == '07') {
            $kodeBulan = 'JULI';
        }elseif ($month == '08') {
            $kodeBulan = 'AGUSTUS';
        }elseif ($month == '09') {
            $kodeBulan = 'SEPTEMBER';
        }elseif ($month == '10') {
            $kodeBulan = 'OKTOBER';
        }elseif ($month == '11') {
            $kodeBulan = 'NOVEMBER';
        }elseif ($month == '02') {
            $kodeBulan = 'DESEMBER';
        }


        $tanggal_awal = Carbon::createFromFormat('Y-m', $bulan)->firstOfMonth()->format('d-m-Y');
        $tanggal_akhir = Carbon::createFromFormat('Y-m', $bulan)->endOfMonth()->format('d-m-Y');
        $FirstDate = Carbon::createFromFormat('Y-m', $bulan)->firstOfMonth()->format('Y-m-d'); 
        $LastDate = Carbon::createFromFormat('Y-m', $bulan)->endOfMonth()->format('Y-m-d'); 

       // untuk mendapat data pertama 
       $data =  MasterLine::with('ltarget')
       ->where('branch', $dataBranch->kode_branch)
       ->where('branch_detail', $dataBranch->branchdetail)
       ->get();
        $detail = LineDetail::where('tgl_pengerjaan', '>=' , $FirstDate)->where('tgl_pengerjaan', '<=' , $LastDate)->get();


        $dataResult = [];
        foreach ($data as $key => $value) {
            foreach ($value->ltarget as $key2 => $value2) {
                foreach ($value2->detail as $key3 => $value3) {
                    $dataResult[] = [
                        'id_'=> $value3->id,
                        'id_line' => $value3->id_line,
                        'target_terpenuhi' => $value3->target_terpenuhi,
                        'file' => $value3->file,
                        'no_wo' => $value3->no_wo,
                        'tgl_pengerjaan' => $value3->tgl_pengerjaan,
                        'fg' => $value3->fg,
                        'tot_fg' => $value3->p_fg,
                        'broken' => $value3->broken,
                        'tot_broken' => $value3->p_broken,
                        'skip' => $value3->skip,
                        'tot_skip' => $value3->p_skip,
                        'pktw' => $value3->pktw,
                        'tot_pktw' => $value3->p_pktw,
                        'crooked' => $value3->crooked,
                        'tot_crooked' => $value3->p_crooked,
                        'pleated' => $value3->pleated,
                        'tot_pleated' => $value3->p_pleated,
                        'ros' => $value3->ros,
                        'tot_ros' => $value3->p_ros,
                        'htl' => $value3->htl,
                        'tot_htl' => $value3->p_htl,
                        'button' => $value3->button,
                        'tot_button' => $value3->p_button,
                        'print' => $value3->print,
                        'tot_print' => $value3->p_print,
                        'bs' => $value3->bs,
                        'tot_bs' => $value3->p_bs,
                        'unb' => $value3->unb,
                        'tot_unb' => $value3->p_unb,
                        'shading' => $value3->shading,
                        'tot_shading' => $value3->p_shading,
                        'dof' => $value3->dof,
                        'tot_dof' => $value3->p_dof,
                        'dirty' => $value3->dirty,
                        'tot_dirty' => $value3->p_dirty,
                        'shiny' => $value3->shiny,
                        'tot_shiny' => $value3->p_shiny,
                        'sticker' => $value3->sticker,
                        'tot_sticker' => $value3->p_sticker,
                        'trimming' => $value3->trimming,
                        'tot_trimming' => $value3->p_trimming,
                        'ip' => $value3->ip,
                        'tot_ip' => $value3->p_ip,
                        'meas' => $value3->meas,
                        'tot_meas' => $value3->p_meas,
                        'other' => $value3->other,
                        'tot_other' => $value3->p_other,
                        'total_reject' => $value3->total_reject,
                        'p_total_reject' => $value3->p_reject,
                        'total_check' => $value3->total_check,
                        'remark' => $value3->string1
                    ];
                }
            }
        }
        $percobaan =   collect($dataResult)->sortBy('tgl_pengerjaan')->groupBy('tgl_pengerjaan');

         $TotalResult = [];
         foreach ($percobaan as $key => $value) {
            $xremark = collect($dataResult)->where('tgl_pengerjaan', $key)->where('remark','!=', null)->implode('remark', ' | ');
            $remark = $value->implode('remark', ' | ');
            $cterpenuhi = $value->sum('target_terpenuhi');
            $creject = $value->sum('total_reject');
            $ccheck = $value->sum('total_check');
            $fg = $value->sum('fg');
            $broken = $value->sum('broken');
            $skip = $value->sum('skip');
            $pktw = $value->sum('pktw');
            $crooked = $value->sum('crooked');
            $pleated = $value->sum('pleated');
            $ros = $value->sum('ros');
            $htl = $value->sum('htl');
            $button = $value->sum('button');
            $print = $value->sum('print');
            $bs = $value->sum('bs');
            $unb = $value->sum('unb');
            $shading = $value->sum('shading');
            $dof = $value->sum('dof');
            $dirty = $value->sum('dirty');
            $shiny = $value->sum('shiny');
            $sticker = $value->sum('sticker');
            $trimming = $value->sum('trimming');
            $ip = $value->sum('ip');
            $meas = $value->sum('meas');
            $other = $value->sum('other');
            if($cterpenuhi == 0){
                $tot_fg = 0;
                $tot_broken = 0;
                $tot_skip = 0;
                $tot_pktw = 0;
                $tot_crooked = 0;
                $tot_pleated = 0;
                $tot_ros = 0;
                $tot_htl = 0;
                $tot_button = 0;
                $tot_print = 0;
                $tot_bs = 0;
                $tot_unb = 0;
                $tot_shading = 0;
                $tot_dof = 0;
                $tot_dirty = 0;
                $tot_shiny = 0;
                $tot_sticker = 0;
                $tot_trimming = 0;
                $tot_ip = 0;
                $tot_meas = 0;
                $tot_other = 0;
                $tot_total_reject = 0;
            }else{
                $tot_fg =  round($fg / $cterpenuhi *100,2);
                $tot_broken =  round($broken / $cterpenuhi *100,2);
                $tot_skip =  round($skip / $cterpenuhi *100,2);
                $tot_pktw =  round($pktw / $cterpenuhi *100,2);
                $tot_crooked =  round($crooked / $cterpenuhi *100,2);
                $tot_pleated =  round($pleated / $cterpenuhi *100,2);
                $tot_ros =  round($ros / $cterpenuhi *100,2);
                $tot_htl =  round($htl / $cterpenuhi *100,2);
                $tot_button =  round($button / $cterpenuhi *100,2);
                $tot_print =  round($print / $cterpenuhi *100,2);
                $tot_bs =  round($bs / $cterpenuhi *100,2);
                $tot_unb =  round($unb / $cterpenuhi *100,2);
                $tot_shading =  round($shading / $cterpenuhi *100,2);
                $tot_dof =  round($dof / $cterpenuhi *100,2);
                $tot_dirty =  round($dirty / $cterpenuhi *100,2);
                $tot_shiny =  round($shiny / $cterpenuhi *100,2);
                $tot_sticker =  round($sticker / $cterpenuhi *100,2);
                $tot_trimming =  round($trimming / $cterpenuhi *100,2);
                $tot_ip =  round($ip / $cterpenuhi *100,2);
                $tot_meas =  round($meas / $cterpenuhi *100,2);
                $tot_other =  round($other / $cterpenuhi *100,2);
                $tot_total_reject = round($creject / $cterpenuhi *100,2);
            }
            $TotalResult[] = [
                'target_terpenuhi' => $cterpenuhi,
                'total_check' => $ccheck,
                'total_reject' => $creject,
                'tgl_pengerjaan' => $key,
                'fg' => $fg,
                'tot_fg' => $tot_fg,
                'broken' => $broken,
                'tot_broken' => $tot_broken,
                'skip' => $skip,
                'tot_skip' => $tot_skip,
                'pktw' => $pktw,
                'tot_pktw' => $tot_pktw,
                'crooked' => $crooked,
                'tot_crooked' => $tot_crooked,
                'pleated' => $pleated,
                'tot_pleated' => $tot_pleated,
                'ros' => $ros,
                'tot_ros' => $tot_ros,
                'htl' => $htl,
                'tot_htl' => $tot_htl,
                'button' => $button,
                'tot_button' => $tot_button,
                'print' => $print,
                'tot_print' => $tot_print,
                'bs' => $bs,
                'tot_bs' => $tot_bs,
                'unb' => $unb,
                'tot_unb' => $tot_unb,
                'shading' => $shading,
                'tot_shading' => $tot_shading,
                'dof' => $dof,
                'tot_dof' => $tot_dof,
                'dirty' => $dirty,
                'tot_dirty' => $tot_dirty,
                'shiny' => $shiny,
                'tot_shiny' => $tot_shiny,
                'sticker' => $sticker,
                'tot_sticker' => $tot_sticker,
                'trimming' => $trimming,
                'tot_trimming' => $tot_trimming,
                'ip' => $ip,
                'tot_ip' => $tot_ip,
                'meas' => $meas,
                'tot_meas' => $tot_meas,
                'other' => $other,
                'tot_other' => $tot_other,
                'p_total_reject' => $tot_total_reject,
                'remark' => $xremark             
            ];
         }
         // end data pertama 
        
        // untuk mendapat data total
        $semua_terpenuhi = collect($TotalResult)->sum('target_terpenuhi');
        if ($semua_terpenuhi == 0 || $semua_terpenuhi == null) {
            $tot_fg = 0;
            $tot_broken = 0;
            $tot_skip = 0;
            $tot_pktw = 0;
            $tot_crooked = 0;
            $tot_pleated = 0;
            $tot_ros = 0;
            $tot_htl = 0;
            $tot_button = 0;
            $tot_print = 0;
            $tot_bs = 0;
            $tot_unb = 0;
            $tot_shading = 0;
            $tot_dof = 0;
            $tot_dirty = 0;
            $tot_shiny = 0;
            $tot_sticker = 0;
            $tot_trimming = 0;
            $tot_ip = 0;
            $tot_meas = 0;
            $tot_other = 0;
            $p_total_reject = 0;
        }else{
            $tot_fg =round( collect($TotalResult)->sum('fg') / $semua_terpenuhi *100,2);
            $tot_broken =round( collect($TotalResult)->sum('broken') / $semua_terpenuhi *100,2);
            $tot_skip =round(collect($TotalResult)->sum('skip') / $semua_terpenuhi *100,2);
            $tot_pktw =round(collect($TotalResult)->sum('pktw') / $semua_terpenuhi *100,2);
            $tot_crooked = round(collect($TotalResult)->sum('crooked') / $semua_terpenuhi *100,2);
            $tot_pleated = round(collect($TotalResult)->sum('pleated') / $semua_terpenuhi *100,2);
            $tot_ros = round(collect($TotalResult)->sum('ros') / $semua_terpenuhi *100,2);
            $tot_htl = round(collect($TotalResult)->sum('htl') / $semua_terpenuhi *100,2);
            $tot_button = round(collect($TotalResult)->sum('button') / $semua_terpenuhi *100,2);
            $tot_print = round(collect($TotalResult)->sum('print') / $semua_terpenuhi *100,2);
            $tot_bs = round(collect($TotalResult)->sum('bs') / $semua_terpenuhi *100,2);
            $tot_unb = round(collect($TotalResult)->sum('unb') / $semua_terpenuhi *100,2);
            $tot_shading = round(collect($TotalResult)->sum('shading') / $semua_terpenuhi *100,2);
            $tot_dof = round(collect($TotalResult)->sum('dof') / $semua_terpenuhi *100,2);
            $tot_dirty = round(collect($TotalResult)->sum('dirty') / $semua_terpenuhi *100,2);
            $tot_shiny = round(collect($TotalResult)->sum('shiny') / $semua_terpenuhi *100,2);
            $tot_sticker = round(collect($TotalResult)->sum('sticker') / $semua_terpenuhi *100,2);
            $tot_trimming = round(collect($TotalResult)->sum('trimming') / $semua_terpenuhi *100,2);
            $tot_ip = round(collect($TotalResult)->sum('ip') / $semua_terpenuhi *100,2);
            $tot_meas = round(collect($TotalResult)->sum('meas') / $semua_terpenuhi *100,2);
            $tot_other = round(collect($TotalResult)->sum('other') / $semua_terpenuhi *100,2);
            $p_total_reject = round(collect($TotalResult)->sum('total_reject') / $semua_terpenuhi *100, 2);
        }
        $TotalAllLine[] = [
            'target_terpenuhi' => $semua_terpenuhi,
            'fg' =>  collect($TotalResult)->sum('fg'),
            'tot_fg' => $tot_fg,
            'broken' =>  collect($TotalResult)->sum('broken'),
            'tot_broken' => $tot_broken,
            'skip' => collect($TotalResult)->sum('skip'),
            'tot_skip' => $tot_skip,
            'pktw' => collect($TotalResult)->sum('pktw'),
            'tot_pktw' => $tot_pktw,
            'crooked' => collect($TotalResult)->sum('crooked'),
            'tot_crooked' => $tot_crooked,
            'pleated' => collect($TotalResult)->sum('pleated'),
            'tot_pleated' => $tot_pleated,
            'ros' => collect($TotalResult)->sum('ros'),
            'tot_ros' => $tot_ros,
            'htl' => collect($TotalResult)->sum('htl'),
            'tot_htl' => $tot_htl,
            'button' => collect($TotalResult)->sum('button'),
            'tot_button' => $tot_button,
            'print' => collect($TotalResult)->sum('print'),
            'tot_print' => $tot_print,
            'bs' => collect($TotalResult)->sum('bs'),
            'tot_bs' => $tot_bs,
            'unb' => collect($TotalResult)->sum('unb'),
            'tot_unb' => $tot_unb,
            'shading' => collect($TotalResult)->sum('shading'),
            'tot_shading' => $tot_shading,
            'dof' => collect($TotalResult)->sum('dof'),
            'tot_dof' => $tot_dof,
            'dirty' => collect($TotalResult)->sum('dirty'),
            'tot_dirty' => $tot_dirty,
            'shiny' => collect($TotalResult)->sum('shiny'),
            'tot_shiny' => $tot_shiny,
            'sticker' => collect($TotalResult)->sum('sticker'),
            'tot_sticker' => $tot_sticker,
            'trimming' => collect($TotalResult)->sum('trimming'),
            'tot_trimming' => $tot_trimming,
            'ip' => collect($TotalResult)->sum('ip'),
            'tot_ip' => $tot_ip,
            'meas' => collect($TotalResult)->sum('meas'),
            'tot_meas' => $tot_meas,
            'other' => collect($TotalResult)->sum('other'),
            'tot_other' => $tot_other,
            'total_reject' => collect($TotalResult)->sum('total_reject'),
            'p_total_reject' => $p_total_reject,
            'total_check' => collect($TotalResult)->sum('total_check')
        ];
        $totalLine = $TotalAllLine[0];
        // biar remark nya kebawa semua 
        $test = [];
        $coba = collect($dataResult)->where('remark', '!=', null)->groupBy('tgl_pengerjaan');
        foreach ($coba as $key => $value) {
            $test[] = [
                'tgl_pengerjaan' => $key,
                'remark'=>  $value->implode('remark', ' | ')
            ];
        }
        // end remark 
        $dataRemark = collect($dataResult)->where('remark', '!=', null)->implode('remark', ' | ');
        // dd($dataRemark);
        // end data total

        $pdf = PDF::loadview('qc/rework/report/bulanan_pdf', compact('kodeBulan','tanggal_awal', 'tanggal_akhir','dataRemark','totalLine','TotalResult', 'dataResult', 'dataBranch', 'FirstDate', 'LastDate', 'bulan'))->setPaper('legal', 'landscape');
        return $pdf->stream();
    }

    public function rtahunan()
    {
        return view('qc/rework/report/tahunan');
    }
    
    public function tahunget(Request $request)
    {
        // untuk filter branch
        if ($request->branch == 'CLN') {
            $branch = 'CLN';
            $branch_detail = 'CLN';
        }elseif($request->branch == 'MAJA1'){
            $branch = 'MAJA';
            $branch_detail = 'GM1';
        }elseif($request->branch == 'MAJA2'){
            $branch = 'MAJA';
            $branch_detail = 'GM2';
        }
        elseif($request->branch == 'GS'){
            $branch = 'GS';
            $branch_detail = 'GS';
        }elseif($request->branch == 'GK'){
            $branch = 'GK';
            $branch_detail = 'GK';
        }
        // end 
        $input = $request->all();
        $tahun = $request->tahun;
        // list bulan 
        $januari = date($tahun.'-01');
        $februari = date($tahun.'-02');
        $maret = date($tahun.'-03');
        $april = date($tahun.'-04');
        $mei = date($tahun.'-05');
        $juni = date($tahun.'-06');
        $juli = date($tahun.'-07');
        $agustus = date($tahun.'-08');
        $september = date($tahun.'-09');
        $oktober = date($tahun.'-10');
        $november = date($tahun.'-11');
        $desember = date($tahun.'-12');
        // end list bulan 

        // Inisialisasi untuk menentukan tanggal awal dan tanggal akhir tiap bulan 
        #januari
        $janAwal = Carbon::createFromFormat('Y-m', $januari)->firstOfMonth()->format('Y-m-d');
        $janAkhir = Carbon::createFromFormat('Y-m', $januari)->endOfMonth()->format('Y-m-d');
        #februari
        $febAwal = Carbon::createFromFormat('Y-m', $februari)->firstOfMonth()->format('Y-m-d');
        $febAkhir = Carbon::createFromFormat('Y-m', $februari)->endOfMonth()->format('Y-m-d');    
        #maret
        $marAwal = Carbon::createFromFormat('Y-m', $maret)->firstOfMonth()->format('Y-m-d');
        $marAkhir = Carbon::createFromFormat('Y-m', $maret)->endOfMonth()->format('Y-m-d');   
        #april
        $aprAwal = Carbon::createFromFormat('Y-m', $april)->firstOfMonth()->format('Y-m-d');
        $aprAkhir = Carbon::createFromFormat('Y-m', $april)->endOfMonth()->format('Y-m-d');   
        #mei
        $meiAwal = Carbon::createFromFormat('Y-m', $mei)->firstOfMonth()->format('Y-m-d');
        $meiAkhir = Carbon::createFromFormat('Y-m', $mei)->endOfMonth()->format('Y-m-d');
        #juni
        $junAwal = Carbon::createFromFormat('Y-m', $juni)->firstOfMonth()->format('Y-m-d');
        $junAkhir = Carbon::createFromFormat('Y-m', $juni)->endOfMonth()->format('Y-m-d');   
        #juli
        $julAwal = Carbon::createFromFormat('Y-m', $juli)->firstOfMonth()->format('Y-m-d');
        $julAkhir = Carbon::createFromFormat('Y-m', $juli)->endOfMonth()->format('Y-m-d');   
        #agustus
        $agsAwal = Carbon::createFromFormat('Y-m', $agustus)->firstOfMonth()->format('Y-m-d');
        $agsAkhir = Carbon::createFromFormat('Y-m', $agustus)->endOfMonth()->format('Y-m-d');   
        #september
        $sepAwal = Carbon::createFromFormat('Y-m', $september)->firstOfMonth()->format('Y-m-d');
        $sepAkhir = Carbon::createFromFormat('Y-m', $september)->endOfMonth()->format('Y-m-d');   
        #oktober
        $oktAwal = Carbon::createFromFormat('Y-m', $oktober)->firstOfMonth()->format('Y-m-d');
        $oktAkhir = Carbon::createFromFormat('Y-m', $oktober)->endOfMonth()->format('Y-m-d');   
        #november
        $novAwal = Carbon::createFromFormat('Y-m', $november)->firstOfMonth()->format('Y-m-d');
        $novAkhir = Carbon::createFromFormat('Y-m', $november)->endOfMonth()->format('Y-m-d');   
        #desember
        $desAwal = Carbon::createFromFormat('Y-m', $desember)->firstOfMonth()->format('Y-m-d');
        $desAkhir = Carbon::createFromFormat('Y-m', $desember)->endOfMonth()->format('Y-m-d');   
        // end Inisialisasi 

        // data di bulan Januari 
        $data =  MasterLine::where('branch', $branch)
                ->where('branch_detail', $branch_detail)
                ->get();
        $detailJan = LineDetail::where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get();
        $dataJan = [];
        foreach ($data as $key => $value) {
            foreach ($detailJan as $key2 => $value2) {
                if($value->id == $value2->id_line){
                    $janTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('target_terpenuhi');
                    $janCheck = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('total_check');
                    $janReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('total_reject');
                    $janFG = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('fg');
                    $janBroken = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('broken');
                    $janSkip = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('skip');
                    $janPktw = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('pktw');
                    $janCrooked = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('crooked');
                    $janPleated = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('pleated');
                    $janRos = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('ros');
                    $janHtl = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('htl');
                    $janButton = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('button');
                    $janPrint = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('print');
                    $janBs = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('bs');
                    $janUnb = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('unb');
                    $janShading = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('shading');
                    $janDof = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('dof');
                    $janDirty = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('dirty');
                    $janShiny = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('shiny');
                    $janSticker = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('sticker');
                    $janTrimming = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('trimming');
                    $janIP = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('ip');
                    $janMeas = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('meas');
                    $janOther = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('other');
                    $dataJan[] = [
                        'id_line' => $value2->id_line,
                        'tgl_pengerjaan' => $value2->tgl_pengerjaan,
                        'terpenuhi' => $janTerpenuhi,
                        'fg' => $janFG,
                        'tot_fg' => round($janFG / $janTerpenuhi *100,2),
                        'broken' => $janBroken,
                        'tot_broken' => round($janBroken / $janTerpenuhi *100,2),
                        'skip' => $janSkip,
                        'tot_skip' => round($janSkip / $janTerpenuhi *100,2),
                        'pktw' => $janPktw,
                        'tot_pktw' => round($janPktw / $janTerpenuhi *100,2),
                        'crooked' => $janCrooked,
                        'tot_crooked' => round($janCrooked / $janTerpenuhi *100,2),
                        'pleated' => $janPleated,
                        'tot_pleated' => round($janPleated / $janTerpenuhi *100,2),
                        'ros' => $janRos,
                        'tot_ros' => round($janRos / $janTerpenuhi *100,2),
                        'htl' => $janHtl,
                        'tot_htl' => round($janHtl / $janTerpenuhi *100,2),
                        'button' => $janButton,
                        'tot_button' => round($janButton / $janTerpenuhi *100,2),
                        'print' => $janPrint,
                        'tot_print' => round($janPrint / $janTerpenuhi *100,2),
                        'bs' => $janBs,
                        'tot_bs' => round($janBs / $janTerpenuhi *100,2),
                        'unb' => $janUnb,
                        'tot_unb' => round($janUnb / $janTerpenuhi *100,2),
                        'shading' => $janShading,
                        'tot_shading' => round($janShading / $janTerpenuhi *100,2),
                        'dof' => $janDof,
                        'tot_dof' => round($janDof / $janTerpenuhi *100,2),
                        'dirty' => $janDirty,
                        'tot_dirty' => round($janDirty / $janTerpenuhi *100,2),
                        'shiny' => $janShiny,
                        'tot_shiny' => round($janShiny / $janTerpenuhi *100,2),
                        'sticker' => $janSticker,
                        'tot_sticker' => round($janSticker / $janTerpenuhi *100,2),
                        'trimming' => $janTrimming,
                        'tot_trimming' => round($janTrimming / $janTerpenuhi *100,2),
                        'ip' => $janIP,
                        'tot_ip' => round($janIP / $janTerpenuhi *100,2),
                        'meas' => $janMeas,
                        'tot_meas' => round($janMeas / $janTerpenuhi *100,2),
                        'other' => $janOther,
                        'tot_other' => round($janOther / $janTerpenuhi *100,2),
                        'total_reject' => $janReject,
                        'p_total_reject' => round($janReject / $janTerpenuhi *100,2),
                        'total_check' => $janCheck,
                        'remark' => $value2->string1
                    ];
                }
            }
        }
        $TotalJan2 = collect($dataJan)
            ->groupBy('tgl_pengerjaan')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        $TotalJan = collect($TotalJan2)
        ->groupBy('id_line')
        ->map(function ($item) {
            return array_merge(...$item->toArray());
        })->values()->toArray();

        // biar remark nya kebawa semua 
        $testJan = [];
        $cobaJan = collect($dataJan)->where('remark', '!=', null)->groupBy('tgl_pengerjaan');
        foreach ($cobaJan as $key => $value) {
        $testJan[] = [
                'tgl_pengerjaan' => $key,
                'remark'=>  $value->implode('remark', ' | ')
            ];
        }
        $JanTerpenuhi = collect($TotalJan)->sum('terpenuhi');
        $JanFG = collect($TotalJan)->sum('fg');
        $JanBroken = collect($TotalJan)->sum('broken');
        $JanSkip = collect($TotalJan)->sum('skip');
        $JanPktw = collect($TotalJan)->sum('pktw');
        $JanCrooked = collect($TotalJan)->sum('crooked');
        $JanPleated = collect($TotalJan)->sum('pleated');
        $JanRos = collect($TotalJan)->sum('ros');
        $JanHtl = collect($TotalJan)->sum('htl');
        $JanButton = collect($TotalJan)->sum('button');
        $JanPrint = collect($TotalJan)->sum('print');
        $JanBs = collect($TotalJan)->sum('bs');
        $JanUnb = collect($TotalJan)->sum('unb');
        $JanShading = collect($TotalJan)->sum('shading');
        $JanDof = collect($TotalJan)->sum('dof');
        $JanDirty = collect($TotalJan)->sum('dirty');
        $JanShiny = collect($TotalJan)->sum('shiny');
        $JanSticker = collect($TotalJan)->sum('sticker');
        $JanTrimming = collect($TotalJan)->sum('trimming');
        $JanIP = collect($TotalJan)->sum('ip');
        $JanMeas = collect($TotalJan)->sum('meas');
        $JanOther = collect($TotalJan)->sum('other');
        $JanTotalCheck = collect($TotalJan)->sum('total_check');
        $JanTotalReject = collect($TotalJan)->sum('total_reject');

        if($JanTerpenuhi != 0 || $JanFG != 0 || $JanBroken != 0 || $JanSkip != 0 || $JanPktw != 0 || $JanCrooked != 0
        || $JanPleated != 0 || $JanRos != 0 || $JanHtl != 0 || $JanButton != 0 || $JanPrint != 0 || $JanBs != 0
        || $JanUnb != 0 || $JanShading != 0 || $JanDof != 0 || $JanDirty != 0 || $JanShiny != 0 || $JanSticker != 0
        || $JanTrimming != 0 || $JanIP != 0 || $JanMeas != 0 || $JanOther != 0){
            $tot_fg = round($JanFG / $JanTerpenuhi *100,2);
            $tot_broken = round($JanBroken / $JanTerpenuhi *100,2);
            $tot_skip = round($JanSkip / $JanTerpenuhi *100,2);
            $tot_pktw = round($JanPktw / $JanTerpenuhi *100,2);
            $tot_crooked = round($JanCrooked / $JanTerpenuhi *100,2);
            $tot_pleated = round($JanPleated / $JanTerpenuhi *100,2);
            $tot_ros = round($JanRos / $JanTerpenuhi *100,2);
            $tot_htl = round($JanHtl / $JanTerpenuhi *100,2);
            $tot_button = round($JanButton / $JanTerpenuhi *100,2);
            $tot_print = round($JanPrint / $JanTerpenuhi *100,2);
            $tot_bs = round($JanBs / $JanTerpenuhi *100,2);
            $tot_unb = round($JanUnb / $JanTerpenuhi *100,2);
            $tot_shading = round($JanShading / $JanTerpenuhi *100,2);
            $tot_dof = round($JanDof / $JanTerpenuhi *100,2);
            $tot_dirty = round($JanDirty / $JanTerpenuhi *100,2);
            $tot_shiny = round($JanShiny / $JanTerpenuhi *100,2);
            $tot_sticker = round($JanSticker / $JanTerpenuhi *100,2);
            $tot_trimming = round($JanTrimming / $JanTerpenuhi *100,2);
            $tot_ip = round($JanIP / $JanTerpenuhi *100,2);
            $tot_meas = round($JanMeas / $JanTerpenuhi *100,2);
            $tot_other = round($JanOther / $JanTerpenuhi *100,2);
            $p_total_reject = round($JanTotalReject/$JanTerpenuhi*100,2);
        }else{
            $tot_fg = 0;
            $tot_broken = 0;
            $tot_skip = 0;
            $tot_pktw = 0;
            $tot_crooked = 0;
            $tot_pleated = 0;
            $tot_ros = 0;
            $tot_htl = 0;
            $tot_button = 0;
            $tot_print = 0;
            $tot_bs = 0;
            $tot_unb = 0;
            $tot_shading = 0;
            $tot_dof = 0;
            $tot_dirty = 0;
            $tot_shiny = 0;
            $tot_sticker = 0;
            $tot_trimming = 0;
            $tot_ip = 0;
            $tot_meas = 0;
            $tot_other = 0;
            $p_total_reject = 0;
        }
        
        $JanAll[] = [
            'target_terpenuhi' => $JanTerpenuhi,
            'fg' => $JanFG,
            'tot_fg' => $tot_fg,
            'broken' => $JanBroken,
            'tot_broken' => $tot_broken,
            'skip' => $JanSkip,
            'tot_skip' => $tot_skip,
            'pktw' => $JanPktw,
            'tot_pktw' => $tot_pktw,
            'crooked' => $JanCrooked,
            'tot_crooked' => $tot_crooked,
            'pleated' => $JanPleated,
            'tot_pleated' => $tot_pleated,
            'ros' => $JanRos,
            'tot_ros' => $tot_ros,
            'htl' => $JanHtl,
            'tot_htl' => $tot_htl,
            'button' => $JanButton,
            'tot_button' => $tot_button,
            'print' => $JanPrint,
            'tot_print' => $tot_print,
            'bs' => $JanBs,
            'tot_bs' => $tot_bs,
            'unb' => $JanUnb,
            'tot_unb' => $tot_unb,
            'shading' => $JanShading,
            'tot_shading' => $tot_shading,
            'dof' => $JanDof,
            'tot_dof' => $tot_dof,
            'dirty' => $JanDirty,
            'tot_dirty' => $tot_dirty,
            'shiny' => $JanShiny,
            'tot_shiny' => $tot_shiny,
            'sticker' => $JanSticker,
            'tot_sticker' => $tot_sticker,
            'trimming' => $JanTrimming,
            'tot_trimming' => $tot_trimming,
            'ip' => $JanIP,
            'tot_ip' => $tot_ip,
            'meas' => $JanMeas,
            'tot_meas' => $tot_meas,
            'other' => $JanOther,
            'tot_other' => $tot_other,
            'total_reject' => $JanTotalReject,
            'p_total_reject' => $p_total_reject,
            'total_check' => $JanTotalCheck
        ];
        $totalJanuari = $JanAll[0];
        $JanRemark = collect($dataJan)->where('remark', '!=', null)->implode('remark', ' | ');
        // end data januari

        // data bulan februari
        $detailFeb = LineDetail::where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get();
        $dataFeb = [];
        foreach ($data as $key => $value) {
            foreach ($detailFeb as $key2 => $value2) {
                if($value->id == $value2->id_line){
                    $febTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('target_terpenuhi');
                    $febCheck = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('total_check');
                    $febReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('total_reject');
                    $febFG = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('fg');
                    $febBroken = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('broken');
                    $febSkip = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('skip');
                    $febPktw = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('pktw');
                    $febCrooked = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('crooked');
                    $febPleated = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('pleated');
                    $febRos = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('ros');
                    $febHtl = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('htl');
                    $febButton = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('button');
                    $febPrint = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('print');
                    $febBs = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('bs');
                    $febUnb = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('unb');
                    $febShading = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('shading');
                    $febDof = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('dof');
                    $febDirty = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('dirty');
                    $febShiny = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('shiny');
                    $febSticker = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('sticker');
                    $febTrimming = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('trimming');
                    $febIP = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('ip');
                    $febMeas = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('meas');
                    $febOther = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('other');
                    $dataFeb[] = [
                        'id_line' => $value2->id_line,
                        'tgl_pengerjaan' => $value2->tgl_pengerjaan,
                        'terpenuhi' => $febTerpenuhi,
                        'fg' => $febFG,
                        'tot_fg' => round($febFG / $febTerpenuhi *100,2),
                        'broken' => $febBroken,
                        'tot_broken' => round($febBroken / $febTerpenuhi *100,2),
                        'skip' => $febSkip,
                        'tot_skip' => round($febSkip / $febTerpenuhi *100,2),
                        'pktw' => $febPktw,
                        'tot_pktw' => round($febPktw / $febTerpenuhi *100,2),
                        'crooked' => $febCrooked,
                        'tot_crooked' => round($febCrooked / $febTerpenuhi *100,2),
                        'pleated' => $febPleated,
                        'tot_pleated' => round($febPleated / $febTerpenuhi *100,2),
                        'ros' => $febRos,
                        'tot_ros' => round($febRos / $febTerpenuhi *100,2),
                        'htl' => $febHtl,
                        'tot_htl' => round($febHtl / $febTerpenuhi *100,2),
                        'button' => $febButton,
                        'tot_button' => round($febButton / $febTerpenuhi *100,2),
                        'print' => $febPrint,
                        'tot_print' => round($febPrint / $febTerpenuhi *100,2),
                        'bs' => $febBs,
                        'tot_bs' => round($febBs / $febTerpenuhi *100,2),
                        'unb' => $febUnb,
                        'tot_unb' => round($febUnb / $febTerpenuhi *100,2),
                        'shading' => $febShading,
                        'tot_shading' => round($febShading / $febTerpenuhi *100,2),
                        'dof' => $febDof,
                        'tot_dof' => round($febDof / $febTerpenuhi *100,2),
                        'dirty' => $febDirty,
                        'tot_dirty' => round($febDirty / $febTerpenuhi *100,2),
                        'shiny' => $febShiny,
                        'tot_shiny' => round($febShiny / $febTerpenuhi *100,2),
                        'sticker' => $febSticker,
                        'tot_sticker' => round($febSticker / $febTerpenuhi *100,2),
                        'trimming' => $febTrimming,
                        'tot_trimming' => round($febTrimming / $febTerpenuhi *100,2),
                        'ip' => $febIP,
                        'tot_ip' => round($febIP / $febTerpenuhi *100,2),
                        'meas' => $febMeas,
                        'tot_meas' => round($febMeas / $febTerpenuhi *100,2),
                        'other' => $febOther,
                        'tot_other' => round($febOther / $febTerpenuhi *100,2),
                        'total_reject' => $febReject,
                        'p_total_reject' => round($febReject/$febTerpenuhi*100,2),
                        'total_check' => $febCheck,
                        'remark' => $value2->string1
                    ];
                }
            }
        }
        $TotalFeb2 = collect($dataFeb)
            ->groupBy('tgl_pengerjaan')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        $TotalFeb = collect($TotalFeb2)
            ->groupBy('id_line')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        // biar remark nya kebawa semua 
        $testFeb = [];
        $cobaFeb = collect($dataFeb)->where('remark', '!=', null)->groupBy('tgl_pengerjaan');
        foreach ($cobaFeb as $key => $value) {
        $testFeb[] = [
                'tgl_pengerjaan' => $key,
                'remark'=>  $value->implode('remark', ' | ')
            ];
        }
        $FebTerpenuhi = collect($TotalFeb)->sum('terpenuhi');
        $FebFG = collect($TotalFeb)->sum('fg');
        $FebBroken = collect($TotalFeb)->sum('broken');
        $FebSkip = collect($TotalFeb)->sum('skip');
        $FebPktw = collect($TotalFeb)->sum('pktw');
        $FebCrooked = collect($TotalFeb)->sum('crooked');
        $FebPleated = collect($TotalFeb)->sum('pleated');
        $FebRos = collect($TotalFeb)->sum('ros');
        $FebHtl = collect($TotalFeb)->sum('htl');
        $FebButton = collect($TotalFeb)->sum('button');
        $FebPrint = collect($TotalFeb)->sum('print');
        $FebBs = collect($TotalFeb)->sum('bs');
        $FebUnb = collect($TotalFeb)->sum('unb');
        $FebShading = collect($TotalFeb)->sum('shading');
        $FebDof = collect($TotalFeb)->sum('dof');
        $FebDirty = collect($TotalFeb)->sum('dirty');
        $FebShiny = collect($TotalFeb)->sum('shiny');
        $FebSticker = collect($TotalFeb)->sum('sticker');
        $FebTrimming = collect($TotalFeb)->sum('trimming');
        $FebIP = collect($TotalFeb)->sum('ip');
        $FebMeas = collect($TotalFeb)->sum('meas');
        $FebOther = collect($TotalFeb)->sum('other');
        $FebTotalCheck = collect($TotalFeb)->sum('total_check');
        $FebTotalReject = collect($TotalFeb)->sum('total_reject');

        if($FebTerpenuhi != 0 || $FebFG != 0 || $FebBroken != 0 || $FebSkip != 0 || $FebPktw != 0 || $FebCrooked != 0
        || $FebPleated != 0 || $FebRos != 0 || $FebHtl != 0 || $FebButton != 0 || $FebPrint != 0 || $FebBs != 0
        || $FebUnb != 0 || $FebShading != 0 || $FebDof != 0 || $FebDirty != 0 || $FebShiny != 0 || $FebSticker != 0
        || $FebTrimming != 0 || $FebIP != 0 || $FebMeas != 0 || $FebOther != 0){
            $tot_fg = round($FebFG / $FebTerpenuhi *100,2);
            $tot_broken = round($FebBroken / $FebTerpenuhi *100,2);
            $tot_skip = round($FebSkip / $FebTerpenuhi *100,2);
            $tot_pktw = round($FebPktw / $FebTerpenuhi *100,2);
            $tot_crooked = round($FebCrooked / $FebTerpenuhi *100,2);
            $tot_pleated = round($FebPleated / $FebTerpenuhi *100,2);
            $tot_ros = round($FebRos / $FebTerpenuhi *100,2);
            $tot_htl = round($FebHtl / $FebTerpenuhi *100,2);
            $tot_button = round($FebButton / $FebTerpenuhi *100,2);
            $tot_print = round($FebPrint / $FebTerpenuhi *100,2);
            $tot_bs = round($FebBs / $FebTerpenuhi *100,2);
            $tot_unb = round($FebUnb / $FebTerpenuhi *100,2);
            $tot_shading = round($FebShading / $FebTerpenuhi *100,2);
            $tot_dof = round($FebDof / $FebTerpenuhi *100,2);
            $tot_dirty = round($FebDirty / $FebTerpenuhi *100,2);
            $tot_shiny = round($FebShiny / $FebTerpenuhi *100,2);
            $tot_sticker = round($FebSticker / $FebTerpenuhi *100,2);
            $tot_trimming = round($FebTrimming / $FebTerpenuhi *100,2);
            $tot_ip = round($FebIP / $FebTerpenuhi *100,2);
            $tot_meas = round($FebMeas / $FebTerpenuhi *100,2);
            $tot_other = round($FebOther / $FebTerpenuhi *100,2);
            $p_total_reject = round($FebTotalReject / $FebTerpenuhi *100,2);
        }else{
            $tot_fg = 0;
            $tot_broken = 0;
            $tot_skip = 0;
            $tot_pktw = 0;
            $tot_crooked = 0;
            $tot_pleated = 0;
            $tot_ros = 0;
            $tot_htl = 0;
            $tot_button = 0;
            $tot_print = 0;
            $tot_bs = 0;
            $tot_unb = 0;
            $tot_shading = 0;
            $tot_dof = 0;
            $tot_dirty = 0;
            $tot_shiny = 0;
            $tot_sticker = 0;
            $tot_trimming = 0;
            $tot_ip = 0;
            $tot_meas = 0;
            $tot_other = 0;
            $p_total_reject = 0;
        }
        
        $FebAll[] = [
            'target_terpenuhi' => $FebTerpenuhi,
            'fg' => $FebFG,
            'tot_fg' => $tot_fg,
            'broken' => $FebBroken,
            'tot_broken' => $tot_broken,
            'skip' => $FebSkip,
            'tot_skip' => $tot_skip,
            'pktw' => $FebPktw,
            'tot_pktw' => $tot_pktw,
            'crooked' => $FebCrooked,
            'tot_crooked' => $tot_crooked,
            'pleated' => $FebPleated,
            'tot_pleated' => $tot_pleated,
            'ros' => $FebRos,
            'tot_ros' => $tot_ros,
            'htl' => $FebHtl,
            'tot_htl' => $tot_htl,
            'button' => $FebButton,
            'tot_button' => $tot_button,
            'print' => $FebPrint,
            'tot_print' => $tot_print,
            'bs' => $FebBs,
            'tot_bs' => $tot_bs,
            'unb' => $FebUnb,
            'tot_unb' => $tot_unb,
            'shading' => $FebShading,
            'tot_shading' => $tot_shading,
            'dof' => $FebDof,
            'tot_dof' => $tot_dof,
            'dirty' => $FebDirty,
            'tot_dirty' => $tot_dirty,
            'shiny' => $FebShiny,
            'tot_shiny' => $tot_shiny,
            'sticker' => $FebSticker,
            'tot_sticker' => $tot_sticker,
            'trimming' => $FebTrimming,
            'tot_trimming' => $tot_trimming,
            'ip' => $FebIP,
            'tot_ip' => $tot_ip,
            'meas' => $FebMeas,
            'tot_meas' => $tot_meas,
            'other' => $FebOther,
            'tot_other' => $tot_other,
            'total_reject' => $FebTotalReject,
            'p_total_reject' => $p_total_reject,
            'total_check' => $FebTotalCheck
        ];
        $totalFebruari = $FebAll[0];
        $FebRemark = collect($dataFeb)->where('remark', '!=', null)->implode('remark', ' | ');
        // end data bulan februari

        // data bulan maret
        $detailMar = LineDetail::where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get();
        $dataMar = [];
        foreach ($data as $key => $value) {
            foreach ($detailMar as $key2 => $value2) {
                if($value->id == $value2->id_line){
                    $marTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('target_terpenuhi');
                    $marCheck = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('total_check');
                    $marReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('total_reject');
                    $marFG = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('fg');
                    $marBroken = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('broken');
                    $marSkip = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('skip');
                    $marPktw = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('pktw');
                    $marCrooked = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('crooked');
                    $marPleated = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('pleated');
                    $marRos = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('ros');
                    $marHtl = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('htl');
                    $marButton = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('button');
                    $marPrint = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('print');
                    $marBs = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('bs');
                    $marUnb = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('unb');
                    $marShading = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('shading');
                    $marDof = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('dof');
                    $marDirty = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('dirty');
                    $marShiny = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('shiny');
                    $marSticker = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('sticker');
                    $marTrimming = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('trimming');
                    $marIP = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('ip');
                    $marMeas = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('meas');
                    $marOther = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('other');
                    $dataMar[] = [
                        'id_line' => $value2->id_line,
                        'tgl_pengerjaan' => $value2->tgl_pengerjaan,
                        'terpenuhi' =>$marTerpenuhi,
                        'fg' =>$marFG,
                        'tot_fg' => round($janFG /$marTerpenuhi *100,2),
                        'broken' =>$marBroken,
                        'tot_broken' => round($janBroken /$marTerpenuhi *100,2),
                        'skip' =>$marSkip,
                        'tot_skip' => round($janSkip /$marTerpenuhi *100,2),
                        'pktw' =>$marPktw,
                        'tot_pktw' => round($janPktw /$marTerpenuhi *100,2),
                        'crooked' =>$marCrooked,
                        'tot_crooked' => round($janCrooked /$marTerpenuhi *100,2),
                        'pleated' =>$marPleated,
                        'tot_pleated' => round($janPleated /$marTerpenuhi *100,2),
                        'ros' =>$marRos,
                        'tot_ros' => round($janRos /$marTerpenuhi *100,2),
                        'htl' =>$marHtl,
                        'tot_htl' => round($janHtl /$marTerpenuhi *100,2),
                        'button' =>$marButton,
                        'tot_button' => round($janButton /$marTerpenuhi *100,2),
                        'print' =>$marPrint,
                        'tot_print' => round($janPrint /$marTerpenuhi *100,2),
                        'bs' =>$marBs,
                        'tot_bs' => round($janBs /$marTerpenuhi *100,2),
                        'unb' =>$marUnb,
                        'tot_unb' => round($janUnb /$marTerpenuhi *100,2),
                        'shading' =>$marShading,
                        'tot_shading' => round($janShading /$marTerpenuhi *100,2),
                        'dof' =>$marDof,
                        'tot_dof' => round($janDof /$marTerpenuhi *100,2),
                        'dirty' =>$marDirty,
                        'tot_dirty' => round($janDirty /$marTerpenuhi *100,2),
                        'shiny' =>$marShiny,
                        'tot_shiny' => round($janShiny /$marTerpenuhi *100,2),
                        'sticker' =>$marSticker,
                        'tot_sticker' => round($janSticker /$marTerpenuhi *100,2),
                        'trimming' =>$marTrimming,
                        'tot_trimming' => round($janTrimming /$marTerpenuhi *100,2),
                        'ip' =>$marIP,
                        'tot_ip' => round($janIP /$marTerpenuhi *100,2),
                        'meas' =>$marMeas,
                        'tot_meas' => round($janMeas /$marTerpenuhi *100,2),
                        'other' =>$marOther,
                        'tot_other' => round($janOther /$marTerpenuhi *100,2),
                        'total_reject' => $marReject,
                        'p_total_reject' => round($marReject/$marTerpenuhi*100,2),
                        'total_check' => $marCheck,
                        'remark' => $value2->string1
                    ];
                }
            }
        }
        $TotalMar2 = collect($dataMar)
            ->groupBy('tgl_pengerjaan')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        $TotalMar = collect($TotalMar2)
            ->groupBy('id_line')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        // biar remark nya kebawa semua 
        $testMar = [];
        $cobaMar = collect($dataMar)->where('remark', '!=', null)->groupBy('tgl_pengerjaan');
        foreach ($cobaMar as $key => $value) {
        $testMar[] = [
                'tgl_pengerjaan' => $key,
                'remark'=>  $value->implode('remark', ' | ')
            ];
        }
        $MarTerpenuhi = collect($TotalMar)->sum('terpenuhi');
        $MarFG = collect($TotalMar)->sum('fg');
        $MarBroken = collect($TotalMar)->sum('broken');
        $MarSkip = collect($TotalMar)->sum('skip');
        $MarPktw = collect($TotalMar)->sum('pktw');
        $MarCrooked = collect($TotalMar)->sum('crooked');
        $MarPleated = collect($TotalMar)->sum('pleated');
        $MarRos = collect($TotalMar)->sum('ros');
        $MarHtl = collect($TotalMar)->sum('htl');
        $MarButton = collect($TotalMar)->sum('button');
        $MarPrint = collect($TotalMar)->sum('print');
        $MarBs = collect($TotalMar)->sum('bs');
        $MarUnb = collect($TotalMar)->sum('unb');
        $MarShading = collect($TotalMar)->sum('shading');
        $MarDof = collect($TotalMar)->sum('dof');
        $MarDirty = collect($TotalMar)->sum('dirty');
        $MarShiny = collect($TotalMar)->sum('shiny');
        $MarSticker = collect($TotalMar)->sum('sticker');
        $MarTrimming = collect($TotalMar)->sum('trimming');
        $MarIP = collect($TotalMar)->sum('ip');
        $MarMeas = collect($TotalMar)->sum('meas');
        $MarOther = collect($TotalMar)->sum('other');
        $MarTotalCheck = collect($TotalMar)->sum('total_check');
        $MarTotalReject = collect($TotalMar)->sum('total_reject');

        if($MarTerpenuhi != 0 || $MarFG != 0 || $MarBroken != 0 || $MarSkip != 0 || $MarPktw != 0 || $MarCrooked != 0
        || $MarPleated != 0 || $MarRos != 0 || $MarHtl != 0 || $MarButton != 0 || $MarPrint != 0 || $MarBs != 0
        || $MarUnb != 0 || $MarShading != 0 || $MarDof != 0 || $MarDirty != 0 || $MarShiny != 0 || $MarSticker != 0
        || $MarTrimming != 0 || $MarIP != 0 || $MarMeas != 0 || $MarOther != 0){
            $tot_fg = round($MarFG / $MarTerpenuhi *100,2);
            $tot_broken = round($MarBroken / $MarTerpenuhi *100,2);
            $tot_skip = round($MarSkip / $MarTerpenuhi *100,2);
            $tot_pktw = round($MarPktw / $MarTerpenuhi *100,2);
            $tot_crooked = round($MarCrooked / $MarTerpenuhi *100,2);
            $tot_pleated = round($MarPleated / $MarTerpenuhi *100,2);
            $tot_ros = round($MarRos / $MarTerpenuhi *100,2);
            $tot_htl = round($MarHtl / $MarTerpenuhi *100,2);
            $tot_button = round($MarButton / $MarTerpenuhi *100,2);
            $tot_print = round($MarPrint / $MarTerpenuhi *100,2);
            $tot_bs = round($MarBs / $MarTerpenuhi *100,2);
            $tot_unb = round($MarUnb / $MarTerpenuhi *100,2);
            $tot_shading = round($MarShading / $MarTerpenuhi *100,2);
            $tot_dof = round($MarDof / $MarTerpenuhi *100,2);
            $tot_dirty = round($MarDirty / $MarTerpenuhi *100,2);
            $tot_shiny = round($MarShiny / $MarTerpenuhi *100,2);
            $tot_sticker = round($MarSticker / $MarTerpenuhi *100,2);
            $tot_trimming = round($MarTrimming / $MarTerpenuhi *100,2);
            $tot_ip = round($MarIP / $MarTerpenuhi *100,2);
            $tot_meas = round($MarMeas / $MarTerpenuhi *100,2);
            $tot_other = round($MarOther / $MarTerpenuhi *100,2);
            $p_total_reject = round($MarTotalReject / $MarTerpenuhi *100,2);
        }else{
            $tot_fg = 0;
            $tot_broken = 0;
            $tot_skip = 0;
            $tot_pktw = 0;
            $tot_crooked = 0;
            $tot_pleated = 0;
            $tot_ros = 0;
            $tot_htl = 0;
            $tot_button = 0;
            $tot_print = 0;
            $tot_bs = 0;
            $tot_unb = 0;
            $tot_shading = 0;
            $tot_dof = 0;
            $tot_dirty = 0;
            $tot_shiny = 0;
            $tot_sticker = 0;
            $tot_trimming = 0;
            $tot_ip = 0;
            $tot_meas = 0;
            $tot_other = 0;
            $p_total_reject = 0;
        }
        
        $MarAll[] = [
            'target_terpenuhi' => $MarTerpenuhi,
            'fg' => $MarFG,
            'tot_fg' => $tot_fg,
            'broken' => $MarBroken,
            'tot_broken' => $tot_broken,
            'skip' => $MarSkip,
            'tot_skip' => $tot_skip,
            'pktw' => $MarPktw,
            'tot_pktw' => $tot_pktw,
            'crooked' => $MarCrooked,
            'tot_crooked' => $tot_crooked,
            'pleated' => $MarPleated,
            'tot_pleated' => $tot_pleated,
            'ros' => $MarRos,
            'tot_ros' => $tot_ros,
            'htl' => $MarHtl,
            'tot_htl' => $tot_htl,
            'button' => $MarButton,
            'tot_button' => $tot_button,
            'print' => $MarPrint,
            'tot_print' => $tot_print,
            'bs' => $MarBs,
            'tot_bs' => $tot_bs,
            'unb' => $MarUnb,
            'tot_unb' => $tot_unb,
            'shading' => $MarShading,
            'tot_shading' => $tot_shading,
            'dof' => $MarDof,
            'tot_dof' => $tot_dof,
            'dirty' => $MarDirty,
            'tot_dirty' => $tot_dirty,
            'shiny' => $MarShiny,
            'tot_shiny' => $tot_shiny,
            'sticker' => $MarSticker,
            'tot_sticker' => $tot_sticker,
            'trimming' => $MarTrimming,
            'tot_trimming' => $tot_trimming,
            'ip' => $MarIP,
            'tot_ip' => $tot_ip,
            'meas' => $MarMeas,
            'tot_meas' => $tot_meas,
            'other' => $MarOther,
            'tot_other' => $tot_other,
            'total_reject' => $MarTotalReject,
            'p_total_reject' => $p_total_reject,
            'total_check' => $MarTotalCheck
        ];
        $totalMaret = $MarAll[0];
        $MarRemark = collect($dataMar)->where('remark', '!=', null)->implode('remark', ' | ');
        // end data bulan maret 

        // data bulan april 
        $detailApr = LineDetail::where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get();
        $dataApr = [];
        foreach ($data as $key => $value) {
            foreach ($detailApr as $key2 => $value2) {
                if($value->id == $value2->id_line){
                    $aprTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('target_terpenuhi');
                    $aprCheck = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('total_check');
                    $aprReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('total_reject');
                    $aprFG = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('fg');
                    $aprBroken = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('broken');
                    $aprSkip = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('skip');
                    $aprPktw = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('pktw');
                    $aprCrooked = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('crooked');
                    $aprPleated = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('pleated');
                    $aprRos = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('ros');
                    $aprHtl = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('htl');
                    $aprButton = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('button');
                    $aprPrint = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('print');
                    $aprBs = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('bs');
                    $aprUnb = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('unb');
                    $aprShading = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('shading');
                    $aprDof = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('dof');
                    $aprDirty = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('dirty');
                    $aprShiny = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('shiny');
                    $aprSticker = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('sticker');
                    $aprTrimming = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('trimming');
                    $aprIP = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('ip');
                    $aprMeas = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('meas');
                    $aprOther = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('other');
                    $dataApr[] = [
                        'id_line' => $value2->id_line,
                        'tgl_pengerjaan' => $value2->tgl_pengerjaan,
                        'terpenuhi' => $aprTerpenuhi,
                        'fg' => $aprFG,
                        'tot_fg' => round($aprFG / $aprTerpenuhi *100,2),
                        'broken' => $aprBroken,
                        'tot_broken' => round($aprBroken / $aprTerpenuhi *100,2),
                        'skip' => $aprSkip,
                        'tot_skip' => round($aprSkip / $aprTerpenuhi *100,2),
                        'pktw' => $aprPktw,
                        'tot_pktw' => round($aprPktw / $aprTerpenuhi *100,2),
                        'crooked' => $aprCrooked,
                        'tot_crooked' => round($aprCrooked / $aprTerpenuhi *100,2),
                        'pleated' => $aprPleated,
                        'tot_pleated' => round($aprPleated / $aprTerpenuhi *100,2),
                        'ros' => $aprRos,
                        'tot_ros' => round($aprRos / $aprTerpenuhi *100,2),
                        'htl' => $aprHtl,
                        'tot_htl' => round($aprHtl / $aprTerpenuhi *100,2),
                        'button' => $aprButton,
                        'tot_button' => round($aprButton / $aprTerpenuhi *100,2),
                        'print' => $aprPrint,
                        'tot_print' => round($aprPrint / $aprTerpenuhi *100,2),
                        'bs' => $aprBs,
                        'tot_bs' => round($aprBs / $aprTerpenuhi *100,2),
                        'unb' => $aprUnb,
                        'tot_unb' => round($aprUnb / $aprTerpenuhi *100,2),
                        'shading' => $aprShading,
                        'tot_shading' => round($aprShading / $aprTerpenuhi *100,2),
                        'dof' => $aprDof,
                        'tot_dof' => round($aprDof / $aprTerpenuhi *100,2),
                        'dirty' => $aprDirty,
                        'tot_dirty' => round($aprDirty / $aprTerpenuhi *100,2),
                        'shiny' => $aprShiny,
                        'tot_shiny' => round($aprShiny / $aprTerpenuhi *100,2),
                        'sticker' => $aprSticker,
                        'tot_sticker' => round($aprSticker / $aprTerpenuhi *100,2),
                        'trimming' => $aprTrimming,
                        'tot_trimming' => round($aprTrimming / $aprTerpenuhi *100,2),
                        'ip' => $aprIP,
                        'tot_ip' => round($aprIP / $aprTerpenuhi *100,2),
                        'meas' => $aprMeas,
                        'tot_meas' => round($aprMeas / $aprTerpenuhi *100,2),
                        'other' => $aprOther,
                        'tot_other' => round($aprOther / $aprTerpenuhi *100,2),
                        'total_reject' => $aprReject,
                        'p_total_reject' => round($aprReject/$aprTerpenuhi*100,2),
                        'total_check' => $aprCheck,
                        'remark' => $value2->string1
                    ];
                }
            }
        }
        $TotalApr2 = collect($dataApr)
            ->groupBy('tgl_pengerjaan')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        $TotalApr = collect($TotalApr2)
            ->groupBy('id_line')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        // biar remark nya kebawa semua 
        $testApr = [];
        $cobaApr = collect($dataApr)->where('remark', '!=', null)->groupBy('tgl_pengerjaan');
        foreach ($cobaApr as $key => $value) {
        $testApr[] = [
                'tgl_pengerjaan' => $key,
                'remark'=>  $value->implode('remark', ' | ')
            ];
        }
        $AprTerpenuhi = collect($TotalApr)->sum('terpenuhi');
        $AprFG = collect($TotalApr)->sum('fg');
        $AprBroken = collect($TotalApr)->sum('broken');
        $AprSkip = collect($TotalApr)->sum('skip');
        $AprPktw = collect($TotalApr)->sum('pktw');
        $AprCrooked = collect($TotalApr)->sum('crooked');
        $AprPleated = collect($TotalApr)->sum('pleated');
        $AprRos = collect($TotalApr)->sum('ros');
        $AprHtl = collect($TotalApr)->sum('htl');
        $AprButton = collect($TotalApr)->sum('button');
        $AprPrint = collect($TotalApr)->sum('print');
        $AprBs = collect($TotalApr)->sum('bs');
        $AprUnb = collect($TotalApr)->sum('unb');
        $AprShading = collect($TotalApr)->sum('shading');
        $AprDof = collect($TotalApr)->sum('dof');
        $AprDirty = collect($TotalApr)->sum('dirty');
        $AprShiny = collect($TotalApr)->sum('shiny');
        $AprSticker = collect($TotalApr)->sum('sticker');
        $AprTrimming = collect($TotalApr)->sum('trimming');
        $AprIP = collect($TotalApr)->sum('ip');
        $AprMeas = collect($TotalApr)->sum('meas');
        $AprOther = collect($TotalApr)->sum('other');
        $AprTotalCheck = collect($TotalApr)->sum('total_check');
        $AprTotalReject = collect($TotalApr)->sum('total_reject');

        if($AprTerpenuhi != 0 || $AprFG != 0 || $AprBroken != 0 || $AprSkip != 0 || $AprPktw != 0 || $AprCrooked != 0
        || $AprPleated != 0 || $AprRos != 0 || $AprHtl != 0 || $AprButton != 0 || $AprPrint != 0 || $AprBs != 0
        || $AprUnb != 0 || $AprShading != 0 || $AprDof != 0 || $AprDirty != 0 || $AprShiny != 0 || $AprSticker != 0
        || $AprTrimming != 0 || $AprIP != 0 || $AprMeas != 0 || $AprOther != 0){
            $tot_fg = round($AprFG / $AprTerpenuhi *100,2);
            $tot_broken = round($AprBroken / $AprTerpenuhi *100,2);
            $tot_skip = round($AprSkip / $AprTerpenuhi *100,2);
            $tot_pktw = round($AprPktw / $AprTerpenuhi *100,2);
            $tot_crooked = round($AprCrooked / $AprTerpenuhi *100,2);
            $tot_pleated = round($AprPleated / $AprTerpenuhi *100,2);
            $tot_ros = round($AprRos / $AprTerpenuhi *100,2);
            $tot_htl = round($AprHtl / $AprTerpenuhi *100,2);
            $tot_button = round($AprButton / $AprTerpenuhi *100,2);
            $tot_print = round($AprPrint / $AprTerpenuhi *100,2);
            $tot_bs = round($AprBs / $AprTerpenuhi *100,2);
            $tot_unb = round($AprUnb / $AprTerpenuhi *100,2);
            $tot_shading = round($AprShading / $AprTerpenuhi *100,2);
            $tot_dof = round($AprDof / $AprTerpenuhi *100,2);
            $tot_dirty = round($AprDirty / $AprTerpenuhi *100,2);
            $tot_shiny = round($AprShiny / $AprTerpenuhi *100,2);
            $tot_sticker = round($AprSticker / $AprTerpenuhi *100,2);
            $tot_trimming = round($AprTrimming / $AprTerpenuhi *100,2);
            $tot_ip = round($AprIP / $AprTerpenuhi *100,2);
            $tot_meas = round($AprMeas / $AprTerpenuhi *100,2);
            $tot_other = round($AprOther / $AprTerpenuhi *100,2);
            $p_total_reject = round($AprTotalReject / $AprTerpenuhi *100,2);
        }else{
            $tot_fg = 0;
            $tot_broken = 0;
            $tot_skip = 0;
            $tot_pktw = 0;
            $tot_crooked = 0;
            $tot_pleated = 0;
            $tot_ros = 0;
            $tot_htl = 0;
            $tot_button = 0;
            $tot_print = 0;
            $tot_bs = 0;
            $tot_unb = 0;
            $tot_shading = 0;
            $tot_dof = 0;
            $tot_dirty = 0;
            $tot_shiny = 0;
            $tot_sticker = 0;
            $tot_trimming = 0;
            $tot_ip = 0;
            $tot_meas = 0;
            $tot_other = 0;
            $p_total_reject =0;
        }
        
        $AprAll[] = [
            'target_terpenuhi' => $AprTerpenuhi,
            'fg' => $AprFG,
            'tot_fg' => $tot_fg,
            'broken' => $AprBroken,
            'tot_broken' => $tot_broken,
            'skip' => $AprSkip,
            'tot_skip' => $tot_skip,
            'pktw' => $AprPktw,
            'tot_pktw' => $tot_pktw,
            'crooked' => $AprCrooked,
            'tot_crooked' => $tot_crooked,
            'pleated' => $AprPleated,
            'tot_pleated' => $tot_pleated,
            'ros' => $AprRos,
            'tot_ros' => $tot_ros,
            'htl' => $AprHtl,
            'tot_htl' => $tot_htl,
            'button' => $AprButton,
            'tot_button' => $tot_button,
            'print' => $AprPrint,
            'tot_print' => $tot_print,
            'bs' => $AprBs,
            'tot_bs' => $tot_bs,
            'unb' => $AprUnb,
            'tot_unb' => $tot_unb,
            'shading' => $AprShading,
            'tot_shading' => $tot_shading,
            'dof' => $AprDof,
            'tot_dof' => $tot_dof,
            'dirty' => $AprDirty,
            'tot_dirty' => $tot_dirty,
            'shiny' => $AprShiny,
            'tot_shiny' => $tot_shiny,
            'sticker' => $AprSticker,
            'tot_sticker' => $tot_sticker,
            'trimming' => $AprTrimming,
            'tot_trimming' => $tot_trimming,
            'ip' => $AprIP,
            'tot_ip' => $tot_ip,
            'meas' => $AprMeas,
            'tot_meas' => $tot_meas,
            'other' => $AprOther,
            'tot_other' => $tot_other,
            'total_reject' => $AprTotalReject,
            'p_total_reject' => $p_total_reject,
            'total_check' => $AprTotalCheck
        ];
        $totalApril = $AprAll[0];
        $AprRemark = collect($dataApr)->where('remark', '!=', null)->implode('remark', ' | ');
        // end data bulan april 

        // data bulan mei 
        $detailMei = LineDetail::where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get();
        $dataMei = [];
        foreach ($data as $key => $value) {
            foreach ($detailMei as $key2 => $value2) {
                if($value->id == $value2->id_line){
                    $meiTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('target_terpenuhi');
                    $meiCheck = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('total_check');
                    $meiReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('total_reject');
                    $meiFG = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('fg');
                    $meiBroken = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('broken');
                    $meiSkip = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('skip');
                    $meiPktw = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('pktw');
                    $meiCrooked = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('crooked');
                    $meiPleated = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('pleated');
                    $meiRos = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('ros');
                    $meiHtl = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('htl');
                    $meiButton = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('button');
                    $meiPrint = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('print');
                    $meiBs = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('bs');
                    $meiUnb = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('unb');
                    $meiShading = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('shading');
                    $meiDof = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('dof');
                    $meiDirty = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('dirty');
                    $meiShiny = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('shiny');
                    $meiSticker = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('sticker');
                    $meiTrimming = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('trimming');
                    $meiIP = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('ip');
                    $meiMeas = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('meas');
                    $meiOther = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('other');
                    $dataMei[] = [
                        'tgl_pengerjaan' => $value2->tgl_pengerjaan,
                        'terpenuhi' =>$meiTerpenuhi,
                        'fg' =>$meiFG,
                        'tot_fg' => round($janFG /$meiTerpenuhi *100,2),
                        'broken' =>$meiBroken,
                        'tot_broken' => round($janBroken /$meiTerpenuhi *100,2),
                        'skip' =>$meiSkip,
                        'tot_skip' => round($janSkip /$meiTerpenuhi *100,2),
                        'pktw' =>$meiPktw,
                        'tot_pktw' => round($janPktw /$meiTerpenuhi *100,2),
                        'crooked' =>$meiCrooked,
                        'tot_crooked' => round($janCrooked /$meiTerpenuhi *100,2),
                        'pleated' =>$meiPleated,
                        'tot_pleated' => round($janPleated /$meiTerpenuhi *100,2),
                        'ros' =>$meiRos,
                        'tot_ros' => round($janRos /$meiTerpenuhi *100,2),
                        'htl' =>$meiHtl,
                        'tot_htl' => round($janHtl /$meiTerpenuhi *100,2),
                        'button' =>$meiButton,
                        'tot_button' => round($janButton /$meiTerpenuhi *100,2),
                        'print' =>$meiPrint,
                        'tot_print' => round($janPrint /$meiTerpenuhi *100,2),
                        'bs' =>$meiBs,
                        'tot_bs' => round($janBs /$meiTerpenuhi *100,2),
                        'unb' =>$meiUnb,
                        'tot_unb' => round($janUnb /$meiTerpenuhi *100,2),
                        'shading' =>$meiShading,
                        'tot_shading' => round($janShading /$meiTerpenuhi *100,2),
                        'dof' =>$meiDof,
                        'tot_dof' => round($janDof /$meiTerpenuhi *100,2),
                        'dirty' =>$meiDirty,
                        'tot_dirty' => round($janDirty /$meiTerpenuhi *100,2),
                        'shiny' =>$meiShiny,
                        'tot_shiny' => round($janShiny /$meiTerpenuhi *100,2),
                        'sticker' =>$meiSticker,
                        'tot_sticker' => round($janSticker /$meiTerpenuhi *100,2),
                        'trimming' =>$meiTrimming,
                        'tot_trimming' => round($janTrimming /$meiTerpenuhi *100,2),
                        'ip' =>$meiIP,
                        'tot_ip' => round($janIP /$meiTerpenuhi *100,2),
                        'meas' =>$meiMeas,
                        'tot_meas' => round($janMeas /$meiTerpenuhi *100,2),
                        'other' =>$meiOther,
                        'tot_other' => round($janOther /$meiTerpenuhi *100,2),
                        'total_reject' => $meiReject, 
                        'p_total_reject' => round($meiReject/$meiTerpenuhi*100,2),
                        'total_check' =>$meiCheck,
                        'remark' => $value2->string1,
                        'id_line' => $value2->id_line
                    ];
                }
            }
        }
        $TotalMei2 = collect($dataMei)
            ->groupBy('tgl_pengerjaan')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        $TotalMei = collect($TotalMei2)
            ->groupBy('id_line')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        // biar remark nya kebawa semua 
        $testMei = [];
        $cobaMei = collect($dataMei)->where('remark', '!=', null)->groupBy('tgl_pengerjaan');
        foreach ($cobaMei as $key => $value) {
        $testMei[] = [
                'tgl_pengerjaan' => $key,
                'remark'=>  $value->implode('remark', ' | ')
            ];
        }
        $MeiTerpenuhi = collect($TotalMei)->sum('terpenuhi');
        $MeiFG = collect($TotalMei)->sum('fg');
        $MeiBroken = collect($TotalMei)->sum('broken');
        $MeiSkip = collect($TotalMei)->sum('skip');
        $MeiPktw = collect($TotalMei)->sum('pktw');
        $MeiCrooked = collect($TotalMei)->sum('crooked');
        $MeiPleated = collect($TotalMei)->sum('pleated');
        $MeiRos = collect($TotalMei)->sum('ros');
        $MeiHtl = collect($TotalMei)->sum('htl');
        $MeiButton = collect($TotalMei)->sum('button');
        $MeiPrint = collect($TotalMei)->sum('print');
        $MeiBs = collect($TotalMei)->sum('bs');
        $MeiUnb = collect($TotalMei)->sum('unb');
        $MeiShading = collect($TotalMei)->sum('shading');
        $MeiDof = collect($TotalMei)->sum('dof');
        $MeiDirty = collect($TotalMei)->sum('dirty');
        $MeiShiny = collect($TotalMei)->sum('shiny');
        $MeiSticker = collect($TotalMei)->sum('sticker');
        $MeiTrimming = collect($TotalMei)->sum('trimming');
        $MeiIP = collect($TotalMei)->sum('ip');
        $MeiMeas = collect($TotalMei)->sum('meas');
        $MeiOther = collect($TotalMei)->sum('other');
        $MeiTotalCheck = collect($TotalMei)->sum('total_check');
        $MeiTotalReject = collect($TotalMei)->sum('total_reject');

        if($MeiTerpenuhi != 0 || $MeiFG != 0 || $MeiBroken != 0 || $MeiSkip != 0 || $MeiPktw != 0 || $MeiCrooked != 0
        || $MeiPleated != 0 || $MeiRos != 0 || $MeiHtl != 0 || $MeiButton != 0 || $MeiPrint != 0 || $MeiBs != 0
        || $MeiUnb != 0 || $MeiShading != 0 || $MeiDof != 0 || $MeiDirty != 0 || $MeiShiny != 0 || $MeiSticker != 0
        || $MeiTrimming != 0 || $MeiIP != 0 || $MeiMeas != 0 || $MeiOther != 0){
            $tot_fg = round($MeiFG / $MeiTerpenuhi *100,2);
            $tot_broken = round($MeiBroken / $MeiTerpenuhi *100,2);
            $tot_skip = round($MeiSkip / $MeiTerpenuhi *100,2);
            $tot_pktw = round($MeiPktw / $MeiTerpenuhi *100,2);
            $tot_crooked = round($MeiCrooked / $MeiTerpenuhi *100,2);
            $tot_pleated = round($MeiPleated / $MeiTerpenuhi *100,2);
            $tot_ros = round($MeiRos / $MeiTerpenuhi *100,2);
            $tot_htl = round($MeiHtl / $MeiTerpenuhi *100,2);
            $tot_button = round($MeiButton / $MeiTerpenuhi *100,2);
            $tot_print = round($MeiPrint / $MeiTerpenuhi *100,2);
            $tot_bs = round($MeiBs / $MeiTerpenuhi *100,2);
            $tot_unb = round($MeiUnb / $MeiTerpenuhi *100,2);
            $tot_shading = round($MeiShading / $MeiTerpenuhi *100,2);
            $tot_dof = round($MeiDof / $MeiTerpenuhi *100,2);
            $tot_dirty = round($MeiDirty / $MeiTerpenuhi *100,2);
            $tot_shiny = round($MeiShiny / $MeiTerpenuhi *100,2);
            $tot_sticker = round($MeiSticker / $MeiTerpenuhi *100,2);
            $tot_trimming = round($MeiTrimming / $MeiTerpenuhi *100,2);
            $tot_ip = round($MeiIP / $MeiTerpenuhi *100,2);
            $tot_meas = round($MeiMeas / $MeiTerpenuhi *100,2);
            $tot_other = round($MeiOther / $MeiTerpenuhi *100,2);
            $p_total_reject = round($MeiTotalReject / $MeiTerpenuhi *100,2);
        }else{
            $tot_fg = 0;
            $tot_broken = 0;
            $tot_skip = 0;
            $tot_pktw = 0;
            $tot_crooked = 0;
            $tot_pleated = 0;
            $tot_ros = 0;
            $tot_htl = 0;
            $tot_button = 0;
            $tot_print = 0;
            $tot_bs = 0;
            $tot_unb = 0;
            $tot_shading = 0;
            $tot_dof = 0;
            $tot_dirty = 0;
            $tot_shiny = 0;
            $tot_sticker = 0;
            $tot_trimming = 0;
            $tot_ip = 0;
            $tot_meas = 0;
            $tot_other = 0;
            $p_total_reject = 0;
        }
        
        $MeiAll[] = [
            'target_terpenuhi' => $MeiTerpenuhi,
            'fg' => $MeiFG,
            'tot_fg' => $tot_fg,
            'broken' => $MeiBroken,
            'tot_broken' => $tot_broken,
            'skip' => $MeiSkip,
            'tot_skip' => $tot_skip,
            'pktw' => $MeiPktw,
            'tot_pktw' => $tot_pktw,
            'crooked' => $MeiCrooked,
            'tot_crooked' => $tot_crooked,
            'pleated' => $MeiPleated,
            'tot_pleated' => $tot_pleated,
            'ros' => $MeiRos,
            'tot_ros' => $tot_ros,
            'htl' => $MeiHtl,
            'tot_htl' => $tot_htl,
            'button' => $MeiButton,
            'tot_button' => $tot_button,
            'print' => $MeiPrint,
            'tot_print' => $tot_print,
            'bs' => $MeiBs,
            'tot_bs' => $tot_bs,
            'unb' => $MeiUnb,
            'tot_unb' => $tot_unb,
            'shading' => $MeiShading,
            'tot_shading' => $tot_shading,
            'dof' => $MeiDof,
            'tot_dof' => $tot_dof,
            'dirty' => $MeiDirty,
            'tot_dirty' => $tot_dirty,
            'shiny' => $MeiShiny,
            'tot_shiny' => $tot_shiny,
            'sticker' => $MeiSticker,
            'tot_sticker' => $tot_sticker,
            'trimming' => $MeiTrimming,
            'tot_trimming' => $tot_trimming,
            'ip' => $MeiIP,
            'tot_ip' => $tot_ip,
            'meas' => $MeiMeas,
            'tot_meas' => $tot_meas,
            'other' => $MeiOther,
            'tot_other' => $tot_other,
            'total_reject' => $MeiTotalReject,
            'p_total_reject' => $p_total_reject,
            'total_check' => $MeiTotalCheck
        ];
        $totalMei = $MeiAll[0];
        $MeiRemark = collect($dataMei)->where('remark', '!=', null)->implode('remark', ' | ');
        // end data bulan mei 

        // data bulan juni 
        $detailJun = LineDetail::where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get();
        $dataJun = [];
        foreach ($data as $key => $value) {
            foreach ($detailJun as $key2 => $value2) {
                if($value->id == $value2->id_line){
                    $junTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('target_terpenuhi');
                    $junCheck = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('total_check');
                    $junReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('total_reject');
                    $junFG = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('fg');
                    $junBroken = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('broken');
                    $junSkip = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('skip');
                    $junPktw = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('pktw');
                    $junCrooked = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('crooked');
                    $junPleated = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('pleated');
                    $junRos = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('ros');
                    $junHtl = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('htl');
                    $junButton = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('button');
                    $junPrint = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('print');
                    $junBs = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('bs');
                    $junUnb = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('unb');
                    $junShading = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('shading');
                    $junDof = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('dof');
                    $junDirty = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('dirty');
                    $junShiny = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('shiny');
                    $junSticker = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('sticker');
                    $junTrimming = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('trimming');
                    $junIP = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('ip');
                    $junMeas = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('meas');
                    $junOther = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('other');
                    $dataJun[] = [
                        'tgl_pengerjaan' => $value2->tgl_pengerjaan,
                        'terpenuhi' => $junTerpenuhi,
                        'fg' => $junFG,
                        'tot_fg' => round($junFG / $junTerpenuhi *100,2),
                        'broken' => $junBroken,
                        'tot_broken' => round($junBroken / $junTerpenuhi *100,2),
                        'skip' => $junSkip,
                        'tot_skip' => round($junSkip / $junTerpenuhi *100,2),
                        'pktw' => $junPktw,
                        'tot_pktw' => round($junPktw / $junTerpenuhi *100,2),
                        'crooked' => $junCrooked,
                        'tot_crooked' => round($junCrooked / $junTerpenuhi *100,2),
                        'pleated' => $junPleated,
                        'tot_pleated' => round($junPleated / $junTerpenuhi *100,2),
                        'ros' => $junRos,
                        'tot_ros' => round($junRos / $junTerpenuhi *100,2),
                        'htl' => $junHtl,
                        'tot_htl' => round($junHtl / $junTerpenuhi *100,2),
                        'button' => $junButton,
                        'tot_button' => round($junButton / $junTerpenuhi *100,2),
                        'print' => $junPrint,
                        'tot_print' => round($junPrint / $junTerpenuhi *100,2),
                        'bs' => $junBs,
                        'tot_bs' => round($junBs / $junTerpenuhi *100,2),
                        'unb' => $junUnb,
                        'tot_unb' => round($junUnb / $junTerpenuhi *100,2),
                        'shading' => $junShading,
                        'tot_shading' => round($junShading / $junTerpenuhi *100,2),
                        'dof' => $junDof,
                        'tot_dof' => round($junDof / $junTerpenuhi *100,2),
                        'dirty' => $junDirty,
                        'tot_dirty' => round($junDirty / $junTerpenuhi *100,2),
                        'shiny' => $junShiny,
                        'tot_shiny' => round($junShiny / $junTerpenuhi *100,2),
                        'sticker' => $junSticker,
                        'tot_sticker' => round($junSticker / $junTerpenuhi *100,2),
                        'trimming' => $junTrimming,
                        'tot_trimming' => round($junTrimming / $junTerpenuhi *100,2),
                        'ip' => $junIP,
                        'tot_ip' => round($junIP / $junTerpenuhi *100,2),
                        'meas' => $junMeas,
                        'tot_meas' => round($junMeas / $junTerpenuhi *100,2),
                        'other' => $junOther,
                        'tot_other' => round($junOther / $junTerpenuhi *100,2),
                        'total_reject' => $junReject,
                        'p_total_reject' => round($junReject/$junTerpenuhi*100,2),
                        'total_check' => $junCheck,
                        'remark' => $value2->string1,
                        'id_line' => $value2->id_line
                    ];
                }
            }
        }
        $TotalJun2 = collect($dataJun)
            ->groupBy('tgl_pengerjaan')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        $TotalJun = collect($TotalJun2)
            ->groupBy('id_line')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        // biar remark nya kebawa semua 
        $testJun = [];
        $cobaJun = collect($dataJun)->where('remark', '!=', null)->groupBy('tgl_pengerjaan');
        foreach ($cobaJun as $key => $value) {
        $testJun[] = [
                'tgl_pengerjaan' => $key,
                'remark'=>  $value->implode('remark', ' | ')
            ];
        }
        $JunTerpenuhi = collect($TotalJun)->sum('terpenuhi');
        $JunFG = collect($TotalJun)->sum('fg');
        $JunBroken = collect($TotalJun)->sum('broken');
        $JunSkip = collect($TotalJun)->sum('skip');
        $JunPktw = collect($TotalJun)->sum('pktw');
        $JunCrooked = collect($TotalJun)->sum('crooked');
        $JunPleated = collect($TotalJun)->sum('pleated');
        $JunRos = collect($TotalJun)->sum('ros');
        $JunHtl = collect($TotalJun)->sum('htl');
        $JunButton = collect($TotalJun)->sum('button');
        $JunPrint = collect($TotalJun)->sum('print');
        $JunBs = collect($TotalJun)->sum('bs');
        $JunUnb = collect($TotalJun)->sum('unb');
        $JunShading = collect($TotalJun)->sum('shading');
        $JunDof = collect($TotalJun)->sum('dof');
        $JunDirty = collect($TotalJun)->sum('dirty');
        $JunShiny = collect($TotalJun)->sum('shiny');
        $JunSticker = collect($TotalJun)->sum('sticker');
        $JunTrimming = collect($TotalJun)->sum('trimming');
        $JunIP = collect($TotalJun)->sum('ip');
        $JunMeas = collect($TotalJun)->sum('meas');
        $JunOther = collect($TotalJun)->sum('other');
        $JunTotalCheck = collect($TotalJun)->sum('total_check');
        $JunTotalReject = collect($TotalJun)->sum('total_reject');

        if($JunTerpenuhi != 0 || $JunFG != 0 || $JunBroken != 0 || $JunSkip != 0 || $JunPktw != 0 || $JunCrooked != 0
        || $JunPleated != 0 || $JunRos != 0 || $JunHtl != 0 || $JunButton != 0 || $JunPrint != 0 || $JunBs != 0
        || $JunUnb != 0 || $JunShading != 0 || $JunDof != 0 || $JunDirty != 0 || $JunShiny != 0 || $JunSticker != 0
        || $JunTrimming != 0 || $JunIP != 0 || $JunMeas != 0 || $JunOther != 0){
            $tot_fg = round($JunFG / $JunTerpenuhi *100,2);
            $tot_broken = round($JunBroken / $JunTerpenuhi *100,2);
            $tot_skip = round($JunSkip / $JunTerpenuhi *100,2);
            $tot_pktw = round($JunPktw / $JunTerpenuhi *100,2);
            $tot_crooked = round($JunCrooked / $JunTerpenuhi *100,2);
            $tot_pleated = round($JunPleated / $JunTerpenuhi *100,2);
            $tot_ros = round($JunRos / $JunTerpenuhi *100,2);
            $tot_htl = round($JunHtl / $JunTerpenuhi *100,2);
            $tot_button = round($JunButton / $JunTerpenuhi *100,2);
            $tot_print = round($JunPrint / $JunTerpenuhi *100,2);
            $tot_bs = round($JunBs / $JunTerpenuhi *100,2);
            $tot_unb = round($JunUnb / $JunTerpenuhi *100,2);
            $tot_shading = round($JunShading / $JunTerpenuhi *100,2);
            $tot_dof = round($JunDof / $JunTerpenuhi *100,2);
            $tot_dirty = round($JunDirty / $JunTerpenuhi *100,2);
            $tot_shiny = round($JunShiny / $JunTerpenuhi *100,2);
            $tot_sticker = round($JunSticker / $JunTerpenuhi *100,2);
            $tot_trimming = round($JunTrimming / $JunTerpenuhi *100,2);
            $tot_ip = round($JunIP / $JunTerpenuhi *100,2);
            $tot_meas = round($JunMeas / $JunTerpenuhi *100,2);
            $tot_other = round($JunOther / $JunTerpenuhi *100,2);
            $p_total_reject = round($JunTotalReject / $JunTerpenuhi *100,2);
        }else{
            $tot_fg = 0;
            $tot_broken = 0;
            $tot_skip = 0;
            $tot_pktw = 0;
            $tot_crooked = 0;
            $tot_pleated = 0;
            $tot_ros = 0;
            $tot_htl = 0;
            $tot_button = 0;
            $tot_print = 0;
            $tot_bs = 0;
            $tot_unb = 0;
            $tot_shading = 0;
            $tot_dof = 0;
            $tot_dirty = 0;
            $tot_shiny = 0;
            $tot_sticker = 0;
            $tot_trimming = 0;
            $tot_ip = 0;
            $tot_meas = 0;
            $tot_other = 0;
            $$p_total_reject = 0;
        }
        
        $JunAll[] = [
            'target_terpenuhi' => $JunTerpenuhi,
            'fg' => $JunFG,
            'tot_fg' => $tot_fg,
            'broken' => $JunBroken,
            'tot_broken' => $tot_broken,
            'skip' => $JunSkip,
            'tot_skip' => $tot_skip,
            'pktw' => $JunPktw,
            'tot_pktw' => $tot_pktw,
            'crooked' => $JunCrooked,
            'tot_crooked' => $tot_crooked,
            'pleated' => $JunPleated,
            'tot_pleated' => $tot_pleated,
            'ros' => $JunRos,
            'tot_ros' => $tot_ros,
            'htl' => $JunHtl,
            'tot_htl' => $tot_htl,
            'button' => $JunButton,
            'tot_button' => $tot_button,
            'print' => $JunPrint,
            'tot_print' => $tot_print,
            'bs' => $JunBs,
            'tot_bs' => $tot_bs,
            'unb' => $JunUnb,
            'tot_unb' => $tot_unb,
            'shading' => $JunShading,
            'tot_shading' => $tot_shading,
            'dof' => $JunDof,
            'tot_dof' => $tot_dof,
            'dirty' => $JunDirty,
            'tot_dirty' => $tot_dirty,
            'shiny' => $JunShiny,
            'tot_shiny' => $tot_shiny,
            'sticker' => $JunSticker,
            'tot_sticker' => $tot_sticker,
            'trimming' => $JunTrimming,
            'tot_trimming' => $tot_trimming,
            'ip' => $JunIP,
            'tot_ip' => $tot_ip,
            'meas' => $JunMeas,
            'tot_meas' => $tot_meas,
            'other' => $JunOther,
            'tot_other' => $tot_other,
            'total_reject' => $JunTotalReject,
            'p_total_reject' => $p_total_reject,
            'total_check' => $JunTotalCheck
        ];
        $totalJuni = $JunAll[0];
        $JunRemark = collect($dataJun)->where('remark', '!=', null)->implode('remark', ' | ');
        // end data bulan juni 

        // data bulan juli 
        $detailJul = LineDetail::where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get();
        $dataJul = [];
        foreach ($data as $key => $value) {
            foreach ($detailJul as $key2 => $value2) {
                if($value->id == $value2->id_line){
                    $julTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('target_terpenuhi');
                    $julCheck = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('total_check');
                    $julReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('total_reject');
                    $julFG = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('fg');
                    $julBroken = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('broken');
                    $julSkip = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('skip');
                    $julPktw = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('pktw');
                    $julCrooked = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('crooked');
                    $julPleated = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('pleated');
                    $julRos = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('ros');
                    $julHtl = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('htl');
                    $julButton = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('button');
                    $julPrint = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('print');
                    $julBs = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('bs');
                    $julUnb = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('unb');
                    $julShading = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('shading');
                    $julDof = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('dof');
                    $julDirty = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('dirty');
                    $julShiny = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('shiny');
                    $julSticker = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('sticker');
                    $julTrimming = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('trimming');
                    $julIP = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('ip');
                    $julMeas = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('meas');
                    $julOther = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('other');
                    $dataJul[] = [
                        'tgl_pengerjaan' => $value2->tgl_pengerjaan,
                        'terpenuhi' => $julTerpenuhi,
                        'fg' => $julFG,
                        'tot_fg' => round($julFG / $julTerpenuhi *100,2),
                        'broken' => $julBroken,
                        'tot_broken' => round($julBroken / $julTerpenuhi *100,2),
                        'skip' => $julSkip,
                        'tot_skip' => round($julSkip / $julTerpenuhi *100,2),
                        'pktw' => $julPktw,
                        'tot_pktw' => round($julPktw / $julTerpenuhi *100,2),
                        'crooked' => $julCrooked,
                        'tot_crooked' => round($julCrooked / $julTerpenuhi *100,2),
                        'pleated' => $julPleated,
                        'tot_pleated' => round($julPleated / $julTerpenuhi *100,2),
                        'ros' => $julRos,
                        'tot_ros' => round($julRos / $julTerpenuhi *100,2),
                        'htl' => $julHtl,
                        'tot_htl' => round($julHtl / $julTerpenuhi *100,2),
                        'button' => $julButton,
                        'tot_button' => round($julButton / $julTerpenuhi *100,2),
                        'print' => $julPrint,
                        'tot_print' => round($julPrint / $julTerpenuhi *100,2),
                        'bs' => $julBs,
                        'tot_bs' => round($julBs / $julTerpenuhi *100,2),
                        'unb' => $julUnb,
                        'tot_unb' => round($julUnb / $julTerpenuhi *100,2),
                        'shading' => $julShading,
                        'tot_shading' => round($julShading / $julTerpenuhi *100,2),
                        'dof' => $julDof,
                        'tot_dof' => round($julDof / $julTerpenuhi *100,2),
                        'dirty' => $julDirty,
                        'tot_dirty' => round($julDirty / $julTerpenuhi *100,2),
                        'shiny' => $julShiny,
                        'tot_shiny' => round($julShiny / $julTerpenuhi *100,2),
                        'sticker' => $julSticker,
                        'tot_sticker' => round($julSticker / $julTerpenuhi *100,2),
                        'trimming' => $julTrimming,
                        'tot_trimming' => round($julTrimming / $julTerpenuhi *100,2),
                        'ip' => $julIP,
                        'tot_ip' => round($julIP / $julTerpenuhi *100,2),
                        'meas' => $julMeas,
                        'tot_meas' => round($julMeas / $julTerpenuhi *100,2),
                        'other' => $julOther,
                        'tot_other' => round($julOther / $julTerpenuhi *100,2),
                        'total_reject' => $julReject,
                        'p_total_reject' => round($julReject/$julTerpenuhi*100,2),
                        'total_check' => $julCheck,
                        'remark' => $value2->string1,
                        'id_line' => $value2->id_line
                    ];
                }
            }
        }
        $TotalJul2 = collect($dataJul)
            ->groupBy('tgl_pengerjaan')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        $TotalJul = collect($TotalJul2)
            ->groupBy('id_line')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        // biar remark nya kebawa semua 
        $testJul = [];
        $cobaJul = collect($dataJul)->where('remark', '!=', null)->groupBy('tgl_pengerjaan');
        foreach ($cobaJul as $key => $value) {
        $testJul[] = [
                'tgl_pengerjaan' => $key,
                'remark'=>  $value->implode('remark', ' | ')
            ];
        }
        $JulTerpenuhi = collect($TotalJul)->sum('terpenuhi');
        $JulFG = collect($TotalJul)->sum('fg');
        $JulBroken = collect($TotalJul)->sum('broken');
        $JulSkip = collect($TotalJul)->sum('skip');
        $JulPktw = collect($TotalJul)->sum('pktw');
        $JulCrooked = collect($TotalJul)->sum('crooked');
        $JulPleated = collect($TotalJul)->sum('pleated');
        $JulRos = collect($TotalJul)->sum('ros');
        $JulHtl = collect($TotalJul)->sum('htl');
        $JulButton = collect($TotalJul)->sum('button');
        $JulPrint = collect($TotalJul)->sum('print');
        $JulBs = collect($TotalJul)->sum('bs');
        $JulUnb = collect($TotalJul)->sum('unb');
        $JulShading = collect($TotalJul)->sum('shading');
        $JulDof = collect($TotalJul)->sum('dof');
        $JulDirty = collect($TotalJul)->sum('dirty');
        $JulShiny = collect($TotalJul)->sum('shiny');
        $JulSticker = collect($TotalJul)->sum('sticker');
        $JulTrimming = collect($TotalJul)->sum('trimming');
        $JulIP = collect($TotalJul)->sum('ip');
        $JulMeas = collect($TotalJul)->sum('meas');
        $JulOther = collect($TotalJul)->sum('other');
        $JulTotalCheck = collect($TotalJul)->sum('total_check');
        $JulTotalReject = collect($TotalJul)->sum('total_reject');

        if($JulTerpenuhi != 0 || $JulFG != 0 || $JulBroken != 0 || $JulSkip != 0 || $JulPktw != 0 || $JulCrooked != 0
        || $JulPleated != 0 || $JulRos != 0 || $JulHtl != 0 || $JulButton != 0 || $JulPrint != 0 || $JulBs != 0
        || $JulUnb != 0 || $JulShading != 0 || $JulDof != 0 || $JulDirty != 0 || $JulShiny != 0 || $JulSticker != 0
        || $JulTrimming != 0 || $JulIP != 0 || $JulMeas != 0 || $JulOther != 0){
            $tot_fg = round($JulFG / $JulTerpenuhi *100,2);
            $tot_broken = round($JulBroken / $JulTerpenuhi *100,2);
            $tot_skip = round($JulSkip / $JulTerpenuhi *100,2);
            $tot_pktw = round($JulPktw / $JulTerpenuhi *100,2);
            $tot_crooked = round($JulCrooked / $JulTerpenuhi *100,2);
            $tot_pleated = round($JulPleated / $JulTerpenuhi *100,2);
            $tot_ros = round($JulRos / $JulTerpenuhi *100,2);
            $tot_htl = round($JulHtl / $JulTerpenuhi *100,2);
            $tot_button = round($JulButton / $JulTerpenuhi *100,2);
            $tot_print = round($JulPrint / $JulTerpenuhi *100,2);
            $tot_bs = round($JulBs / $JulTerpenuhi *100,2);
            $tot_unb = round($JulUnb / $JulTerpenuhi *100,2);
            $tot_shading = round($JulShading / $JulTerpenuhi *100,2);
            $tot_dof = round($JulDof / $JulTerpenuhi *100,2);
            $tot_dirty = round($JulDirty / $JulTerpenuhi *100,2);
            $tot_shiny = round($JulShiny / $JulTerpenuhi *100,2);
            $tot_sticker = round($JulSticker / $JulTerpenuhi *100,2);
            $tot_trimming = round($JulTrimming / $JulTerpenuhi *100,2);
            $tot_ip = round($JulIP / $JulTerpenuhi *100,2);
            $tot_meas = round($JulMeas / $JulTerpenuhi *100,2);
            $tot_other = round($JulOther / $JulTerpenuhi *100,2);
            $p_total_reject = round($JulTotalReject / $JulTerpenuhi *100,2);
        }else{
            $tot_fg = 0;
            $tot_broken = 0;
            $tot_skip = 0;
            $tot_pktw = 0;
            $tot_crooked = 0;
            $tot_pleated = 0;
            $tot_ros = 0;
            $tot_htl = 0;
            $tot_button = 0;
            $tot_print = 0;
            $tot_bs = 0;
            $tot_unb = 0;
            $tot_shading = 0;
            $tot_dof = 0;
            $tot_dirty = 0;
            $tot_shiny = 0;
            $tot_sticker = 0;
            $tot_trimming = 0;
            $tot_ip = 0;
            $tot_meas = 0;
            $tot_other = 0;
            $p_total_reject = 0;
        }
        
        $JulAll[] = [
            'target_terpenuhi' => $JulTerpenuhi,
            'fg' => $JulFG,
            'tot_fg' => $tot_fg,
            'broken' => $JulBroken,
            'tot_broken' => $tot_broken,
            'skip' => $JulSkip,
            'tot_skip' => $tot_skip,
            'pktw' => $JulPktw,
            'tot_pktw' => $tot_pktw,
            'crooked' => $JulCrooked,
            'tot_crooked' => $tot_crooked,
            'pleated' => $JulPleated,
            'tot_pleated' => $tot_pleated,
            'ros' => $JulRos,
            'tot_ros' => $tot_ros,
            'htl' => $JulHtl,
            'tot_htl' => $tot_htl,
            'button' => $JulButton,
            'tot_button' => $tot_button,
            'print' => $JulPrint,
            'tot_print' => $tot_print,
            'bs' => $JulBs,
            'tot_bs' => $tot_bs,
            'unb' => $JulUnb,
            'tot_unb' => $tot_unb,
            'shading' => $JulShading,
            'tot_shading' => $tot_shading,
            'dof' => $JulDof,
            'tot_dof' => $tot_dof,
            'dirty' => $JulDirty,
            'tot_dirty' => $tot_dirty,
            'shiny' => $JulShiny,
            'tot_shiny' => $tot_shiny,
            'sticker' => $JulSticker,
            'tot_sticker' => $tot_sticker,
            'trimming' => $JulTrimming,
            'tot_trimming' => $tot_trimming,
            'ip' => $JulIP,
            'tot_ip' => $tot_ip,
            'meas' => $JulMeas,
            'tot_meas' => $tot_meas,
            'other' => $JulOther,
            'tot_other' => $tot_other,
            'total_reject' => $JulTotalReject,
            'p_total_reject' => $p_total_reject,
            'total_check' => $JulTotalCheck
        ];
        $totalJuli = $JulAll[0];
        $JulRemark = collect($dataJul)->where('remark', '!=', null)->implode('remark', ' | ');
        // end data bulan juli 

        // data bulan agustus 
        $detailAgs = LineDetail::where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get();
        $dataAgs = [];
        foreach ($data as $key => $value) {
            foreach ($detailAgs as $key2 => $value2) {
                if($value->id == $value2->id_line){
                    $agsTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('target_terpenuhi');
                    $agsCheck = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('total_check');
                    $agsReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('total_reject');
                    $agsFG = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('fg');
                    $agsBroken = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('broken');
                    $agsSkip = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('skip');
                    $agsPktw = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('pktw');
                    $agsCrooked = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('crooked');
                    $agsPleated = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('pleated');
                    $agsRos = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('ros');
                    $agsHtl = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('htl');
                    $agsButton = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('button');
                    $agsPrint = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('print');
                    $agsBs = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('bs');
                    $agsUnb = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('unb');
                    $agsShading = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('shading');
                    $agsDof = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('dof');
                    $agsDirty = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('dirty');
                    $agsShiny = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('shiny');
                    $agsSticker = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('sticker');
                    $agsTrimming = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('trimming');
                    $agsIP = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('ip');
                    $agsMeas = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('meas');
                    $agsOther = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('other');
                    $dataAgs[] = [
                        'tgl_pengerjaan' => $value2->tgl_pengerjaan,
                        'terpenuhi' => $agsTerpenuhi,
                        'fg' => $agsFG,
                        'tot_fg' => round($agsFG / $agsTerpenuhi *100,2),
                        'broken' => $agsBroken,
                        'tot_broken' => round($agsBroken / $agsTerpenuhi *100,2),
                        'skip' => $agsSkip,
                        'tot_skip' => round($agsSkip / $agsTerpenuhi *100,2),
                        'pktw' => $agsPktw,
                        'tot_pktw' => round($agsPktw / $agsTerpenuhi *100,2),
                        'crooked' => $agsCrooked,
                        'tot_crooked' => round($agsCrooked / $agsTerpenuhi *100,2),
                        'pleated' => $agsPleated,
                        'tot_pleated' => round($agsPleated / $agsTerpenuhi *100,2),
                        'ros' => $agsRos,
                        'tot_ros' => round($agsRos / $agsTerpenuhi *100,2),
                        'htl' => $agsHtl,
                        'tot_htl' => round($agsHtl / $agsTerpenuhi *100,2),
                        'button' => $agsButton,
                        'tot_button' => round($agsButton / $agsTerpenuhi *100,2),
                        'print' => $agsPrint,
                        'tot_print' => round($agsPrint / $agsTerpenuhi *100,2),
                        'bs' => $agsBs,
                        'tot_bs' => round($agsBs / $agsTerpenuhi *100,2),
                        'unb' => $agsUnb,
                        'tot_unb' => round($agsUnb / $agsTerpenuhi *100,2),
                        'shading' => $agsShading,
                        'tot_shading' => round($agsShading / $agsTerpenuhi *100,2),
                        'dof' => $agsDof,
                        'tot_dof' => round($agsDof / $agsTerpenuhi *100,2),
                        'dirty' => $agsDirty,
                        'tot_dirty' => round($agsDirty / $agsTerpenuhi *100,2),
                        'shiny' => $agsShiny,
                        'tot_shiny' => round($agsShiny / $agsTerpenuhi *100,2),
                        'sticker' => $agsSticker,
                        'tot_sticker' => round($agsSticker / $agsTerpenuhi *100,2),
                        'trimming' => $agsTrimming,
                        'tot_trimming' => round($agsTrimming / $agsTerpenuhi *100,2),
                        'ip' => $agsIP,
                        'tot_ip' => round($agsIP / $agsTerpenuhi *100,2),
                        'meas' => $agsMeas,
                        'tot_meas' => round($agsMeas / $agsTerpenuhi *100,2),
                        'other' => $agsOther,
                        'tot_other' => round($agsOther / $agsTerpenuhi *100,2),
                        'total_reject' => $agsReject,
                        'p_total_reject' => round($agsReject/$agsTerpenuhi*100,2),
                        'total_check' => $agsCheck,
                        'remark' => $value2->string1,
                        'file' => $value2->file,
                        'sep' => 'sep',
                        'id_line' => $value2->id_line
                    ];
                }
            }
        }
        $TotalAgs2 = collect($dataAgs)
            ->groupBy('tgl_pengerjaan')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        $TotalAgs = collect($TotalAgs2)
        ->groupBy('id_line')
        ->map(function ($item) {
            return array_merge(...$item->toArray());
        })->values()->toArray();
        // biar remark nya kebawa semua 
        $testAgs = [];
        $cobaAgs = collect($dataAgs)->where('remark', '!=', null)->groupBy('tgl_pengerjaan');
        foreach ($cobaAgs as $key => $value) {
        $testAgs[] = [
                'tgl_pengerjaan' => $key,
                'remark'=>  $value->implode('remark', ' | ')
            ];
        }
        $AgsTerpenuhi = collect($TotalAgs)->sum('terpenuhi');
        $AgsFG = collect($TotalAgs)->sum('fg');
        $AgsBroken = collect($TotalAgs)->sum('broken');
        $AgsSkip = collect($TotalAgs)->sum('skip');
        $AgsPktw = collect($TotalAgs)->sum('pktw');
        $AgsCrooked = collect($TotalAgs)->sum('crooked');
        $AgsPleated = collect($TotalAgs)->sum('pleated');
        $AgsRos = collect($TotalAgs)->sum('ros');
        $AgsHtl = collect($TotalAgs)->sum('htl');
        $AgsButton = collect($TotalAgs)->sum('button');
        $AgsPrint = collect($TotalAgs)->sum('print');
        $AgsBs = collect($TotalAgs)->sum('bs');
        $AgsUnb = collect($TotalAgs)->sum('unb');
        $AgsShading = collect($TotalAgs)->sum('shading');
        $AgsDof = collect($TotalAgs)->sum('dof');
        $AgsDirty = collect($TotalAgs)->sum('dirty');
        $AgsShiny = collect($TotalAgs)->sum('shiny');
        $AgsSticker = collect($TotalAgs)->sum('sticker');
        $AgsTrimming = collect($TotalAgs)->sum('trimming');
        $AgsIP = collect($TotalAgs)->sum('ip');
        $AgsMeas = collect($TotalAgs)->sum('meas');
        $AgsOther = collect($TotalAgs)->sum('other');
        $AgsTotalCheck = collect($TotalAgs)->sum('total_check');
        $AgsTotalReject = collect($TotalAgs)->sum('total_reject');
        $AFile = collect($dataAgs)
                    ->groupBy('sep')
                    ->map(function ($item) {
                        return array_merge(...$item->toArray());
                    })->values()->toArray();
        if($AFile != null){
            $AgsFile = $AFile[0];
        }else{
            $AgsFile = null;
            $AgsFile['file'] = null;
        }
        

        if($AgsTerpenuhi != 0 || $AgsFG != 0 || $AgsBroken != 0 || $AgsSkip != 0 || $AgsPktw != 0 || $AgsCrooked != 0
        || $AgsPleated != 0 || $AgsRos != 0 || $AgsHtl != 0 || $AgsButton != 0 || $AgsPrint != 0 || $AgsBs != 0
        || $AgsUnb != 0 || $AgsShading != 0 || $AgsDof != 0 || $AgsDirty != 0 || $AgsShiny != 0 || $AgsSticker != 0
        || $AgsTrimming != 0 || $AgsIP != 0 || $AgsMeas != 0 || $AgsOther != 0){
            $tot_fg = round($AgsFG / $AgsTerpenuhi *100,2);
            $tot_broken = round($AgsBroken / $AgsTerpenuhi *100,2);
            $tot_skip = round($AgsSkip / $AgsTerpenuhi *100,2);
            $tot_pktw = round($AgsPktw / $AgsTerpenuhi *100,2);
            $tot_crooked = round($AgsCrooked / $AgsTerpenuhi *100,2);
            $tot_pleated = round($AgsPleated / $AgsTerpenuhi *100,2);
            $tot_ros = round($AgsRos / $AgsTerpenuhi *100,2);
            $tot_htl = round($AgsHtl / $AgsTerpenuhi *100,2);
            $tot_button = round($AgsButton / $AgsTerpenuhi *100,2);
            $tot_print = round($AgsPrint / $AgsTerpenuhi *100,2);
            $tot_bs = round($AgsBs / $AgsTerpenuhi *100,2);
            $tot_unb = round($AgsUnb / $AgsTerpenuhi *100,2);
            $tot_shading = round($AgsShading / $AgsTerpenuhi *100,2);
            $tot_dof = round($AgsDof / $AgsTerpenuhi *100,2);
            $tot_dirty = round($AgsDirty / $AgsTerpenuhi *100,2);
            $tot_shiny = round($AgsShiny / $AgsTerpenuhi *100,2);
            $tot_sticker = round($AgsSticker / $AgsTerpenuhi *100,2);
            $tot_trimming = round($AgsTrimming / $AgsTerpenuhi *100,2);
            $tot_ip = round($AgsIP / $AgsTerpenuhi *100,2);
            $tot_meas = round($AgsMeas / $AgsTerpenuhi *100,2);
            $tot_other = round($AgsOther / $AgsTerpenuhi *100,2);
            $p_total_reject = round($AgsTotalReject / $AgsTerpenuhi *100,2);
        }else{
            $tot_fg = 0;
            $tot_broken = 0;
            $tot_skip = 0;
            $tot_pktw = 0;
            $tot_crooked = 0;
            $tot_pleated = 0;
            $tot_ros = 0;
            $tot_htl = 0;
            $tot_button = 0;
            $tot_print = 0;
            $tot_bs = 0;
            $tot_unb = 0;
            $tot_shading = 0;
            $tot_dof = 0;
            $tot_dirty = 0;
            $tot_shiny = 0;
            $tot_sticker = 0;
            $tot_trimming = 0;
            $tot_ip = 0;
            $tot_meas = 0;
            $tot_other = 0;
            $p_total_reject = 0;
        }
        
        $AgsAll[] = [
            'target_terpenuhi' => $AgsTerpenuhi,
            'fg' => $AgsFG,
            'tot_fg' => $tot_fg,
            'broken' => $AgsBroken,
            'tot_broken' => $tot_broken,
            'skip' => $AgsSkip,
            'tot_skip' => $tot_skip,
            'pktw' => $AgsPktw,
            'tot_pktw' => $tot_pktw,
            'crooked' => $AgsCrooked,
            'tot_crooked' => $tot_crooked,
            'pleated' => $AgsPleated,
            'tot_pleated' => $tot_pleated,
            'ros' => $AgsRos,
            'tot_ros' => $tot_ros,
            'htl' => $AgsHtl,
            'tot_htl' => $tot_htl,
            'button' => $AgsButton,
            'tot_button' => $tot_button,
            'print' => $AgsPrint,
            'tot_print' => $tot_print,
            'bs' => $AgsBs,
            'tot_bs' => $tot_bs,
            'unb' => $AgsUnb,
            'tot_unb' => $tot_unb,
            'shading' => $AgsShading,
            'tot_shading' => $tot_shading,
            'dof' => $AgsDof,
            'tot_dof' => $tot_dof,
            'dirty' => $AgsDirty,
            'tot_dirty' => $tot_dirty,
            'shiny' => $AgsShiny,
            'tot_shiny' => $tot_shiny,
            'sticker' => $AgsSticker,
            'tot_sticker' => $tot_sticker,
            'trimming' => $AgsTrimming,
            'tot_trimming' => $tot_trimming,
            'ip' => $AgsIP,
            'tot_ip' => $tot_ip,
            'meas' => $AgsMeas,
            'tot_meas' => $tot_meas,
            'other' => $AgsOther,
            'tot_other' => $tot_other,
            'total_reject' => $AgsTotalReject,
            'p_total_reject' => $p_total_reject,
            'total_check' => $AgsTotalCheck,
            'file'=> $AgsFile['file']
        ];
        $totalAgustus = $AgsAll[0];
        $AgsRemark = collect($dataAgs)->where('remark', '!=', null)->implode('remark', ' | ');
        // end data bulan agustus 

        // data september
        $detailSep = LineDetail::where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get();
        $dataSep = [];
        foreach ($data as $key => $value) {
            foreach ($detailSep as $key2 => $value2) {
                if($value->id == $value2->id_line){
                    $sepTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('target_terpenuhi');
                    $sepCheck = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('total_check');
                    $sepReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('total_reject');
                    $sepFG = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('fg');
                    $sepBroken = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('broken');
                    $sepSkip = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('skip');
                    $sepPktw = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('pktw');
                    $sepCrooked = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('crooked');
                    $sepPleated = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('pleated');
                    $sepRos = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('ros');
                    $sepHtl = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('htl');
                    $sepButton = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('button');
                    $sepPrint = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('print');
                    $sepBs = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('bs');
                    $sepUnb = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('unb');
                    $sepShading = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('shading');
                    $sepDof = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('dof');
                    $sepDirty = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('dirty');
                    $sepShiny = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('shiny');
                    $sepSticker = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('sticker');
                    $sepTrimming = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('trimming');
                    $sepIP = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('ip');
                    $sepMeas = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('meas');
                    $sepOther = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('other');
                    $dataSep[] = [
                        'tgl_pengerjaan' => $value2->tgl_pengerjaan,
                        'terpenuhi' => $sepTerpenuhi,
                        'fg' => $sepFG,
                        'tot_fg' => round($sepFG / $sepTerpenuhi *100,2),
                        'broken' => $sepBroken,
                        'tot_broken' => round($sepBroken / $sepTerpenuhi *100,2),
                        'skip' => $sepSkip,
                        'tot_skip' => round($sepSkip / $sepTerpenuhi *100,2),
                        'pktw' => $sepPktw,
                        'tot_pktw' => round($sepPktw / $sepTerpenuhi *100,2),
                        'crooked' => $sepCrooked,
                        'tot_crooked' => round($sepCrooked / $sepTerpenuhi *100,2),
                        'pleated' => $sepPleated,
                        'tot_pleated' => round($sepPleated / $sepTerpenuhi *100,2),
                        'ros' => $sepRos,
                        'tot_ros' => round($sepRos / $sepTerpenuhi *100,2),
                        'htl' => $sepHtl,
                        'tot_htl' => round($sepHtl / $sepTerpenuhi *100,2),
                        'button' => $sepButton,
                        'tot_button' => round($sepButton / $sepTerpenuhi *100,2),
                        'print' => $sepPrint,
                        'tot_print' => round($sepPrint / $sepTerpenuhi *100,2),
                        'bs' => $sepBs,
                        'tot_bs' => round($sepBs / $sepTerpenuhi *100,2),
                        'unb' => $sepUnb,
                        'tot_unb' => round($sepUnb / $sepTerpenuhi *100,2),
                        'shading' => $sepShading,
                        'tot_shading' => round($sepShading / $sepTerpenuhi *100,2),
                        'dof' => $sepDof,
                        'tot_dof' => round($sepDof / $sepTerpenuhi *100,2),
                        'dirty' => $sepDirty,
                        'tot_dirty' => round($sepDirty / $sepTerpenuhi *100,2),
                        'shiny' => $sepShiny,
                        'tot_shiny' => round($sepShiny / $sepTerpenuhi *100,2),
                        'sticker' => $sepSticker,
                        'tot_sticker' => round($sepSticker / $sepTerpenuhi *100,2),
                        'trimming' => $sepTrimming,
                        'tot_trimming' => round($sepTrimming / $sepTerpenuhi *100,2),
                        'ip' => $sepIP,
                        'tot_ip' => round($sepIP / $sepTerpenuhi *100,2),
                        'meas' => $sepMeas,
                        'tot_meas' => round($sepMeas / $sepTerpenuhi *100,2),
                        'other' => $sepOther,
                        'tot_other' => round($sepOther / $sepTerpenuhi *100,2),
                        'total_reject' => $sepReject,
                        'p_total_reject' => round($sepReject/$sepTerpenuhi*100,2),
                        'total_check' => $sepCheck,
                        'remark' => $value2->string1,
                        'file' => $value2->file,
                        'sep' => 'sep',
                        'id_line' => $value2->id_line
                    ];
                }
            }
        }
        $TotalSep2 = collect($dataSep)
            ->groupBy('tgl_pengerjaan')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        $TotalSep = collect($TotalSep2)
            ->groupBy('id_line')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        // biar remark nya kebawa semua 
        $testSep = [];
        $cobaSep = collect($dataSep)->where('remark', '!=', null)->groupBy('tgl_pengerjaan');
        foreach ($cobaSep as $key => $value) {
        $testSep[] = [
                'tgl_pengerjaan' => $key,
                'remark'=>  $value->implode('remark', ' | ')
            ];
        }
        $SepTerpenuhi = collect($TotalSep)->sum('terpenuhi');
        $SepFG = collect($TotalSep)->sum('fg');
        $SepBroken = collect($TotalSep)->sum('broken');
        $SepSkip = collect($TotalSep)->sum('skip');
        $SepPktw = collect($TotalSep)->sum('pktw');
        $SepCrooked = collect($TotalSep)->sum('crooked');
        $SepPleated = collect($TotalSep)->sum('pleated');
        $SepRos = collect($TotalSep)->sum('ros');
        $SepHtl = collect($TotalSep)->sum('htl');
        $SepButton = collect($TotalSep)->sum('button');
        $SepPrint = collect($TotalSep)->sum('print');
        $SepBs = collect($TotalSep)->sum('bs');
        $SepUnb = collect($TotalSep)->sum('unb');
        $SepShading = collect($TotalSep)->sum('shading');
        $SepDof = collect($TotalSep)->sum('dof');
        $SepDirty = collect($TotalSep)->sum('dirty');
        $SepShiny = collect($TotalSep)->sum('shiny');
        $SepSticker = collect($TotalSep)->sum('sticker');
        $SepTrimming = collect($TotalSep)->sum('trimming');
        $SepIP = collect($TotalSep)->sum('ip');
        $SepMeas = collect($TotalSep)->sum('meas');
        $SepOther = collect($TotalSep)->sum('other');
        $SepTotalCheck = collect($TotalSep)->sum('total_check');
        $SepTotalReject = collect($TotalSep)->sum('total_reject');
        $BFile = collect($dataSep)
                    ->groupBy('sep')
                    ->map(function ($item) {
                        return array_merge(...$item->toArray());
                    })->values()->toArray();
        if($BFile != null){
            $SepFile = $BFile[0];
        }else{
            $SepFile = null;
            $SepFile['file'] = null;
        }
        

        if($SepTerpenuhi != 0 || $SepFG != 0 || $SepBroken != 0 || $SepSkip != 0 || $SepPktw != 0 || $SepCrooked != 0
        || $SepPleated != 0 || $SepRos != 0 || $SepHtl != 0 || $SepButton != 0 || $SepPrint != 0 || $SepBs != 0
        || $SepUnb != 0 || $SepShading != 0 || $SepDof != 0 || $SepDirty != 0 || $SepShiny != 0 || $SepSticker != 0
        || $SepTrimming != 0 || $SepIP != 0 || $SepMeas != 0 || $SepOther != 0){
            $tot_fg = round($SepFG / $SepTerpenuhi *100,2);
            $tot_broken = round($SepBroken / $SepTerpenuhi *100,2);
            $tot_skip = round($SepSkip / $SepTerpenuhi *100,2);
            $tot_pktw = round($SepPktw / $SepTerpenuhi *100,2);
            $tot_crooked = round($SepCrooked / $SepTerpenuhi *100,2);
            $tot_pleated = round($SepPleated / $SepTerpenuhi *100,2);
            $tot_ros = round($SepRos / $SepTerpenuhi *100,2);
            $tot_htl = round($SepHtl / $SepTerpenuhi *100,2);
            $tot_button = round($SepButton / $SepTerpenuhi *100,2);
            $tot_print = round($SepPrint / $SepTerpenuhi *100,2);
            $tot_bs = round($SepBs / $SepTerpenuhi *100,2);
            $tot_unb = round($SepUnb / $SepTerpenuhi *100,2);
            $tot_shading = round($SepShading / $SepTerpenuhi *100,2);
            $tot_dof = round($SepDof / $SepTerpenuhi *100,2);
            $tot_dirty = round($SepDirty / $SepTerpenuhi *100,2);
            $tot_shiny = round($SepShiny / $SepTerpenuhi *100,2);
            $tot_sticker = round($SepSticker / $SepTerpenuhi *100,2);
            $tot_trimming = round($SepTrimming / $SepTerpenuhi *100,2);
            $tot_ip = round($SepIP / $SepTerpenuhi *100,2);
            $tot_meas = round($SepMeas / $SepTerpenuhi *100,2);
            $tot_other = round($SepOther / $SepTerpenuhi *100,2);
            $p_total_reject = round($SepTotalReject / $SepTerpenuhi *100,2);
        }else{
            $tot_fg = 0;
            $tot_broken = 0;
            $tot_skip = 0;
            $tot_pktw = 0;
            $tot_crooked = 0;
            $tot_pleated = 0;
            $tot_ros = 0;
            $tot_htl = 0;
            $tot_button = 0;
            $tot_print = 0;
            $tot_bs = 0;
            $tot_unb = 0;
            $tot_shading = 0;
            $tot_dof = 0;
            $tot_dirty = 0;
            $tot_shiny = 0;
            $tot_sticker = 0;
            $tot_trimming = 0;
            $tot_ip = 0;
            $tot_meas = 0;
            $tot_other = 0;
            $p_total_reject = 0;
        }
        
        $SepAll[] = [
            'target_terpenuhi' => $SepTerpenuhi,
            'fg' => $SepFG,
            'tot_fg' => $tot_fg,
            'broken' => $SepBroken,
            'tot_broken' => $tot_broken,
            'skip' => $SepSkip,
            'tot_skip' => $tot_skip,
            'pktw' => $SepPktw,
            'tot_pktw' => $tot_pktw,
            'crooked' => $SepCrooked,
            'tot_crooked' => $tot_crooked,
            'pleated' => $SepPleated,
            'tot_pleated' => $tot_pleated,
            'ros' => $SepRos,
            'tot_ros' => $tot_ros,
            'htl' => $SepHtl,
            'tot_htl' => $tot_htl,
            'button' => $SepButton,
            'tot_button' => $tot_button,
            'print' => $SepPrint,
            'tot_print' => $tot_print,
            'bs' => $SepBs,
            'tot_bs' => $tot_bs,
            'unb' => $SepUnb,
            'tot_unb' => $tot_unb,
            'shading' => $SepShading,
            'tot_shading' => $tot_shading,
            'dof' => $SepDof,
            'tot_dof' => $tot_dof,
            'dirty' => $SepDirty,
            'tot_dirty' => $tot_dirty,
            'shiny' => $SepShiny,
            'tot_shiny' => $tot_shiny,
            'sticker' => $SepSticker,
            'tot_sticker' => $tot_sticker,
            'trimming' => $SepTrimming,
            'tot_trimming' => $tot_trimming,
            'ip' => $SepIP,
            'tot_ip' => $tot_ip,
            'meas' => $SepMeas,
            'tot_meas' => $tot_meas,
            'other' => $SepOther,
            'tot_other' => $tot_other,
            'total_reject' => $SepTotalReject,
            'p_total_reject' => $p_total_reject,
            'total_check' => $SepTotalCheck,
            'file'=> $SepFile['file']
        ];
        $totalSeptember = $SepAll[0];
        $SepRemark = collect($dataSep)->where('remark', '!=', null)->implode('remark', ' | ');
        // end data september

        // data bulan oktober
        $detailOkt = LineDetail::where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get();
        $dataOkt = [];
        foreach ($data as $key => $value) {
            foreach ($detailOkt as $key2 => $value2) {
                if($value->id == $value2->id_line){
                    $oktTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('target_terpenuhi');
                    $oktCheck = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('total_check');
                    $oktReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('total_reject');
                    $oktFG = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('fg');
                    $oktBroken = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('broken');
                    $oktSkip = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('skip');
                    $oktPktw = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('pktw');
                    $oktCrooked = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('crooked');
                    $oktPleated = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('pleated');
                    $oktRos = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('ros');
                    $oktHtl = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('htl');
                    $oktButton = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('button');
                    $oktPrint = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('print');
                    $oktBs = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('bs');
                    $oktUnb = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('unb');
                    $oktShading = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('shading');
                    $oktDof = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('dof');
                    $oktDirty = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('dirty');
                    $oktShiny = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('shiny');
                    $oktSticker = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('sticker');
                    $oktTrimming = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('trimming');
                    $oktIP = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('ip');
                    $oktMeas = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('meas');
                    $oktOther = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('other');
                    $dataOkt[] = [
                        'id_line' => $value2->id_line,
                        'tgl_pengerjaan' => $value2->tgl_pengerjaan,
                        'terpenuhi' => $oktTerpenuhi,
                        'fg' => $oktFG,
                        'tot_fg' => round($oktFG / $oktTerpenuhi *100,2),
                        'broken' => $oktBroken,
                        'tot_broken' => round($oktBroken / $oktTerpenuhi *100,2),
                        'skip' => $oktSkip,
                        'tot_skip' => round($oktSkip / $oktTerpenuhi *100,2),
                        'pktw' => $oktPktw,
                        'tot_pktw' => round($oktPktw / $oktTerpenuhi *100,2),
                        'crooked' => $oktCrooked,
                        'tot_crooked' => round($oktCrooked / $oktTerpenuhi *100,2),
                        'pleated' => $oktPleated,
                        'tot_pleated' => round($oktPleated / $oktTerpenuhi *100,2),
                        'ros' => $oktRos,
                        'tot_ros' => round($oktRos / $oktTerpenuhi *100,2),
                        'htl' => $oktHtl,
                        'tot_htl' => round($oktHtl / $oktTerpenuhi *100,2),
                        'button' => $oktButton,
                        'tot_button' => round($oktButton / $oktTerpenuhi *100,2),
                        'print' => $oktPrint,
                        'tot_print' => round($oktPrint / $oktTerpenuhi *100,2),
                        'bs' => $oktBs,
                        'tot_bs' => round($oktBs / $oktTerpenuhi *100,2),
                        'unb' => $oktUnb,
                        'tot_unb' => round($oktUnb / $oktTerpenuhi *100,2),
                        'shading' => $oktShading,
                        'tot_shading' => round($oktShading / $oktTerpenuhi *100,2),
                        'dof' => $oktDof,
                        'tot_dof' => round($oktDof / $oktTerpenuhi *100,2),
                        'dirty' => $oktDirty,
                        'tot_dirty' => round($oktDirty / $oktTerpenuhi *100,2),
                        'shiny' => $oktShiny,
                        'tot_shiny' => round($oktShiny / $oktTerpenuhi *100,2),
                        'sticker' => $oktSticker,
                        'tot_sticker' => round($oktSticker / $oktTerpenuhi *100,2),
                        'trimming' => $oktTrimming,
                        'tot_trimming' => round($oktTrimming / $oktTerpenuhi *100,2),
                        'ip' => $oktIP,
                        'tot_ip' => round($oktIP / $oktTerpenuhi *100,2),
                        'meas' => $oktMeas,
                        'tot_meas' => round($oktMeas / $oktTerpenuhi *100,2),
                        'other' => $oktOther,
                        'tot_other' => round($oktOther / $oktTerpenuhi *100,2),
                        'total_reject' => $oktReject,
                        'p_total_reject' => round($oktReject/$oktTerpenuhi*100,2),
                        'total_check' => $oktCheck,
                        'remark' => $value2->string1,
                        'file' => $value2->file,
                        'sep' => 'sep',
                    ];
                }
            }
        }
        $TotalOkt2 = collect($dataOkt)
            ->groupBy('id_line')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
            dd($TotalOkt2);
        $dataas = [];
        foreach ($TotalOkt2 as $key => $value) {
            $xterpenuhi = collect($TotalOkt2)->sum('terpenuhi');
            dd($xterpenuhi);
            $xtotal_reject = collect($TotalOkt2)->sum('total_reject');
            $xtotal_check = collect($TotalOkt2)->sum('total_check');
            $xfg = collect($TotalOkt2)->sum('fg');
            $xbroken = collect($TotalOkt2)->sum('broken');
            $xskip = collect($TotalOkt2)->sum('skip');
            $xpktw = collect($TotalOkt2)->sum('pktw');
            $xcrooked = collect($TotalOkt2)->sum('crooked');
            $xpleated = collect($TotalOkt2)->sum('pleated');
            $xros = collect($TotalOkt2)->sum('ros');
            $xhtl = collect($TotalOkt2)->sum('htl');
            $xbutton = collect($TotalOkt2)->sum('button');
            $xprint = collect($TotalOkt2)->sum('print');
            $xbs = collect($TotalOkt2)->sum('bs');
            $xunb = collect($TotalOkt2)->sum('unb');
            $xshading = collect($TotalOkt2)->sum('shading');
            $xdof = collect($TotalOkt2)->sum('dof');
            $xdirty = collect($TotalOkt2)->sum('dirty');
            $xshiny = collect($TotalOkt2)->sum('shiny');
            $xsticker = collect($TotalOkt2)->sum('sticker');
            $xtrimming = collect($TotalOkt2)->sum('trimming');
            $xip = collect($TotalOkt2)->sum('ip');
            $xmeas = collect($TotalOkt2)->sum('meas');
            $xother = collect($TotalOkt2)->sum('other');
            if($xterpenuhi == 0){
                $x_p_fg = 0;
                $x_p_broken = 0;
                $x_p_skip = 0;
                $x_p_pktw = 0;
                $x_p_crooked = 0;
                $x_p_pleated = 0;
                $x_p_ros = 0;
                $x_p_htl = 0;
                $x_p_button = 0;
                $x_p_print = 0;
                $x_p_bs = 0;
                $x_p_unb = 0;
                $x_p_shading = 0;
                $x_p_dof = 0;
                $x_p_dirty = 0;
                $x_p_shiny = 0;
                $x_p_sticker = 0;
                $x_p_trimming = 0;
                $x_p_ip = 0;
                $x_p_meas = 0;
                $x_p_other = 0;
                $x_total_reject = 0;
            }else{
                $x_p_fg = round($xfg/ $xterpenuhi *100,2);
                $x_p_broken = round($xbroken/ $xterpenuhi *100,2);
                $x_p_skip = round($xskip/ $xterpenuhi *100,2);
                $x_p_pktw = round($xpktw/ $xterpenuhi *100,2);
                $x_p_crooked = round($xcrooked/ $xterpenuhi *100,2);
                $x_p_pleated = round($xpleated/ $xterpenuhi *100,2);
                $x_p_ros = round($xros/ $xterpenuhi *100,2);
                $x_p_htl = round($xhtl/ $xterpenuhi *100,2);
                $x_p_button = round($xbutton/ $xterpenuhi *100,2);
                $x_p_print = round($xprint/ $xterpenuhi *100,2);
                $x_p_bs = round($xbs/ $xterpenuhi *100,2);
                $x_p_unb = round($xunb/ $xterpenuhi *100,2);
                $x_p_shading = round($xshading/ $xterpenuhi *100,2);
                $x_p_dof = round($xdof/ $xterpenuhi *100,2);
                $x_p_dirty = round($xdirty/ $xterpenuhi *100,2);
                $x_p_shiny = round($xshiny/ $xterpenuhi *100,2);
                $x_p_sticker = round($xsticker/ $xterpenuhi *100,2);
                $x_p_trimming = round($xtrimming/ $xterpenuhi *100,2);
                $x_p_ip = round($xip/ $xterpenuhi *100,2);
                $x_p_meas = round($xmeas/ $xterpenuhi *100,2);
                $x_p_other = round($xother/ $xterpenuhi *100,2);
                $x_total_reject =  round($xtotal_reject/ $xterpenuhi *100,2);
            }
            $dataas[] = [
                'target_terpenuhi' => $xterpenuhi,
                'tgl_pengerjaan' => $value['tgl_pengerjaan'],
                'file' => $value['file'],
                'no_wo' => $value2['no_wo'],
                'fg' => $xfg,
                'tot_fg' => $x_p_fg,
                'broken' => $xbroken,
                'tot_broken' => $x_p_broken,
                'skip' => $xskip,
                'tot_skip' => $x_p_skip,
                'pktw' => $xpktw,
                'tot_pktw' => $x_p_pktw,
                'crooked' => $xcrooked,
                'tot_crooked' => $x_p_crooked,
                'pleated' => $xpleated,
                'tot_pleated' => $x_p_pleated,
                'ros' => $xros,
                'tot_ros' => $x_p_ros,
                'htl' => $xhtl,
                'tot_htl' => $x_p_htl,
                'button' => $xbutton,
                'tot_button' => $x_p_button,
                'print' => $xprint,
                'tot_print' => $x_p_print,
                'bs' => $xbs,
                'tot_bs' => $x_p_bs,
                'unb' => $xunb,
                'tot_unb' => $x_p_unb,
                'shading' => $xshading,
                'tot_shading' => $x_p_shading,
                'dof' => $xdof,
                'tot_dof' => $x_p_dof,
                'dirty' => $xdirty,
                'tot_dirty' => $x_p_dirty,
                'shiny' => $xshiny,
                'tot_shiny' => $x_p_shiny,
                'sticker' => $xsticker,
                'tot_sticker' => $x_p_sticker,
                'trimming' => $xtrimming,
                'tot_trimming' => $x_p_trimming,
                'ip' => $xip,
                'tot_ip' => $x_p_ip,
                'meas' => $xmeas,
                'tot_meas' => $x_p_meas,
                'other' => $xother,
                'tot_other' => $x_p_other,
                'total_reject' => $xtotal_reject,
                'p_total_reject' => $x_total_reject,
                'total_check' => $xtotal_check,
            ];
        }

        $TotalOkt = collect($TotalOkt2)
        ->groupBy('id_line')
        ->map(function ($item) {
            return array_merge(...$item->toArray());
        })->values()->toArray();

        // biar remark nya kebawa semua 
        $testOkt = [];
        $cobaOkt = collect($dataOkt)->where('remark', '!=', null)->groupBy('tgl_pengerjaan');
        foreach ($cobaOkt as $key => $value) {
        $testOkt[] = [
                'tgl_pengerjaan' => $key,
                'remark'=>  $value->implode('remark', ' | ')
            ];
        }
        $OktTerpenuhi = collect($TotalOkt)->sum('terpenuhi');
        $OktFG = collect($TotalOkt)->sum('fg');
        $OktBroken = collect($TotalOkt)->sum('broken');
        $OktSkip = collect($TotalOkt)->sum('skip');
        $OktPktw = collect($TotalOkt)->sum('pktw');
        $OktCrooked = collect($TotalOkt)->sum('crooked');
        $OktPleated = collect($TotalOkt)->sum('pleated');
        $OktRos = collect($TotalOkt)->sum('ros');
        $OktHtl = collect($TotalOkt)->sum('htl');
        $OktButton = collect($TotalOkt)->sum('button');
        $OktPrint = collect($TotalOkt)->sum('print');
        $OktBs = collect($TotalOkt)->sum('bs');
        $OktUnb = collect($TotalOkt)->sum('unb');
        $OktShading = collect($TotalOkt)->sum('shading');
        $OktDof = collect($TotalOkt)->sum('dof');
        $OktDirty = collect($TotalOkt)->sum('dirty');
        $OktShiny = collect($TotalOkt)->sum('shiny');
        $OktSticker = collect($TotalOkt)->sum('sticker');
        $OktTrimming = collect($TotalOkt)->sum('trimming');
        $OktIP = collect($TotalOkt)->sum('ip');
        $OktMeas = collect($TotalOkt)->sum('meas');
        $OktOther = collect($TotalOkt)->sum('other');
        $OktTotalCheck = collect($TotalOkt)->sum('total_check');
        $OktTotalReject = collect($TotalOkt)->sum('total_reject');

        $CFile = collect($dataOkt)
                    ->where('file')
                    ->groupBy('sep')
                    ->map(function ($item) {
                        return array_merge(...$item->toArray());
                    })->values()->toArray();
        if($CFile != null){
            $OktFile = $CFile[0];
        }else{
            $OktFile = null;
            $OktFile['file'] = null;
        }

        if($OktTerpenuhi != 0 || $OktFG != 0 || $OktBroken != 0 || $OktSkip != 0 || $OktPktw != 0 || $OktCrooked != 0
        || $OktPleated != 0 || $OktRos != 0 || $OktHtl != 0 || $OktButton != 0 || $OktPrint != 0 || $OktBs != 0
        || $OktUnb != 0 || $OktShading != 0 || $OktDof != 0 || $OktDirty != 0 || $OktShiny != 0 || $OktSticker != 0
        || $OktTrimming != 0 || $OktIP != 0 || $OktMeas != 0 || $OktOther != 0){
            $tot_fg = round($OktFG / $OktTerpenuhi *100,2);
            $tot_broken = round($OktBroken / $OktTerpenuhi *100,2);
            $tot_skip = round($OktSkip / $OktTerpenuhi *100,2);
            $tot_pktw = round($OktPktw / $OktTerpenuhi *100,2);
            $tot_crooked = round($OktCrooked / $OktTerpenuhi *100,2);
            $tot_pleated = round($OktPleated / $OktTerpenuhi *100,2);
            $tot_ros = round($OktRos / $OktTerpenuhi *100,2);
            $tot_htl = round($OktHtl / $OktTerpenuhi *100,2);
            $tot_button = round($OktButton / $OktTerpenuhi *100,2);
            $tot_print = round($OktPrint / $OktTerpenuhi *100,2);
            $tot_bs = round($OktBs / $OktTerpenuhi *100,2);
            $tot_unb = round($OktUnb / $OktTerpenuhi *100,2);
            $tot_shading = round($OktShading / $OktTerpenuhi *100,2);
            $tot_dof = round($OktDof / $OktTerpenuhi *100,2);
            $tot_dirty = round($OktDirty / $OktTerpenuhi *100,2);
            $tot_shiny = round($OktShiny / $OktTerpenuhi *100,2);
            $tot_sticker = round($OktSticker / $OktTerpenuhi *100,2);
            $tot_trimming = round($OktTrimming / $OktTerpenuhi *100,2);
            $tot_ip = round($OktIP / $OktTerpenuhi *100,2);
            $tot_meas = round($OktMeas / $OktTerpenuhi *100,2);
            $tot_other = round($OktOther / $OktTerpenuhi *100,2);
            $p_total_reject = round($OktTotalReject / $OktTerpenuhi *100,2);
        }else{
            $tot_fg = 0;
            $tot_broken = 0;
            $tot_skip = 0;
            $tot_pktw = 0;
            $tot_crooked = 0;
            $tot_pleated = 0;
            $tot_ros = 0;
            $tot_htl = 0;
            $tot_button = 0;
            $tot_print = 0;
            $tot_bs = 0;
            $tot_unb = 0;
            $tot_shading = 0;
            $tot_dof = 0;
            $tot_dirty = 0;
            $tot_shiny = 0;
            $tot_sticker = 0;
            $tot_trimming = 0;
            $tot_ip = 0;
            $tot_meas = 0;
            $tot_other = 0;
            $p_total_reject = 0;
        }
        
        $OktAll[] = [
            'target_terpenuhi' => $OktTerpenuhi,
            'fg' => $OktFG,
            'tot_fg' => $tot_fg,
            'broken' => $OktBroken,
            'tot_broken' => $tot_broken,
            'skip' => $OktSkip,
            'tot_skip' => $tot_skip,
            'pktw' => $OktPktw,
            'tot_pktw' => $tot_pktw,
            'crooked' => $OktCrooked,
            'tot_crooked' => $tot_crooked,
            'pleated' => $OktPleated,
            'tot_pleated' => $tot_pleated,
            'ros' => $OktRos,
            'tot_ros' => $tot_ros,
            'htl' => $OktHtl,
            'tot_htl' => $tot_htl,
            'button' => $OktButton,
            'tot_button' => $tot_button,
            'print' => $OktPrint,
            'tot_print' => $tot_print,
            'bs' => $OktBs,
            'tot_bs' => $tot_bs,
            'unb' => $OktUnb,
            'tot_unb' => $tot_unb,
            'shading' => $OktShading,
            'tot_shading' => $tot_shading,
            'dof' => $OktDof,
            'tot_dof' => $tot_dof,
            'dirty' => $OktDirty,
            'tot_dirty' => $tot_dirty,
            'shiny' => $OktShiny,
            'tot_shiny' => $tot_shiny,
            'sticker' => $OktSticker,
            'tot_sticker' => $tot_sticker,
            'trimming' => $OktTrimming,
            'tot_trimming' => $tot_trimming,
            'ip' => $OktIP,
            'tot_ip' => $tot_ip,
            'meas' => $OktMeas,
            'tot_meas' => $tot_meas,
            'other' => $OktOther,
            'tot_other' => $tot_other,
            'total_reject' => $OktTotalReject,
            'p_total_reject' => $p_total_reject,
            'total_check' => $OktTotalCheck,
            'file' => $OktFile['file']
        ];
        $totalOktober = $OktAll[0];
        $OktRemark = collect($dataOkt)->where('remark', '!=', null)->implode('remark', ' | ');
        // end data bulan oktober

        // data bulan november 
        $detailNov = LineDetail::where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get();
        $dataNov = [];
        foreach ($data as $key => $value) {
            foreach ($detailNov as $key2 => $value2) {
                if($value->id == $value2->id_line){
                    $novTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('target_terpenuhi');
                    $novCheck = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('total_check');
                    $novReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('total_reject');
                    $novFG = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('fg');
                    $novBroken = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('broken');
                    $novSkip = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('skip');
                    $novPktw = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('pktw');
                    $novCrooked = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('crooked');
                    $novPleated = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('pleated');
                    $novRos = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('ros');
                    $novHtl = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('htl');
                    $novButton = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('button');
                    $novPrint = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('print');
                    $novBs = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('bs');
                    $novUnb = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('unb');
                    $novShading = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('shading');
                    $novDof = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('dof');
                    $novDirty = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('dirty');
                    $novShiny = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('shiny');
                    $novSticker = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('sticker');
                    $novTrimming = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('trimming');
                    $novIP = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('ip');
                    $novMeas = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('meas');
                    $novOther = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('other');
                    $dataNov[] = [
                        'tgl_pengerjaan' => $value2->tgl_pengerjaan,
                        'terpenuhi' => $novTerpenuhi,
                        'fg' => $novFG,
                        'tot_fg' => round($novFG / $novTerpenuhi *100,2),
                        'broken' => $novBroken,
                        'tot_broken' => round($novBroken / $novTerpenuhi *100,2),
                        'skip' => $novSkip,
                        'tot_skip' => round($novSkip / $novTerpenuhi *100,2),
                        'pktw' => $novPktw,
                        'tot_pktw' => round($novPktw / $novTerpenuhi *100,2),
                        'crooked' => $novCrooked,
                        'tot_crooked' => round($novCrooked / $novTerpenuhi *100,2),
                        'pleated' => $novPleated,
                        'tot_pleated' => round($novPleated / $novTerpenuhi *100,2),
                        'ros' => $novRos,
                        'tot_ros' => round($novRos / $novTerpenuhi *100,2),
                        'htl' => $novHtl,
                        'tot_htl' => round($novHtl / $novTerpenuhi *100,2),
                        'button' => $novButton,
                        'tot_button' => round($novButton / $novTerpenuhi *100,2),
                        'print' => $novPrint,
                        'tot_print' => round($novPrint / $novTerpenuhi *100,2),
                        'bs' => $novBs,
                        'tot_bs' => round($novBs / $novTerpenuhi *100,2),
                        'unb' => $novUnb,
                        'tot_unb' => round($novUnb / $novTerpenuhi *100,2),
                        'shading' => $novShading,
                        'tot_shading' => round($novShading / $novTerpenuhi *100,2),
                        'dof' => $novDof,
                        'tot_dof' => round($novDof / $novTerpenuhi *100,2),
                        'dirty' => $novDirty,
                        'tot_dirty' => round($novDirty / $novTerpenuhi *100,2),
                        'shiny' => $novShiny,
                        'tot_shiny' => round($novShiny / $novTerpenuhi *100,2),
                        'sticker' => $novSticker,
                        'tot_sticker' => round($novSticker / $novTerpenuhi *100,2),
                        'trimming' => $novTrimming,
                        'tot_trimming' => round($novTrimming / $novTerpenuhi *100,2),
                        'ip' => $novIP,
                        'tot_ip' => round($novIP / $novTerpenuhi *100,2),
                        'meas' => $novMeas,
                        'tot_meas' => round($novMeas / $novTerpenuhi *100,2),
                        'other' => $novOther,
                        'tot_other' => round($novOther / $novTerpenuhi *100,2),
                        'total_reject' => $novReject,
                        'p_total_reject' => round($novReject/$novTerpenuhi*100,2),
                        'total_check' => $novCheck,
                        'remark' => $value2->string1,
                        'file' => $value2->file,
                        'sep' => 'sep',
                        'id_line' => $value2->id_line
                    ];
                }
            }
        }
        $TotalNov2 = collect($dataNov)
            ->groupBy('tgl_pengerjaan')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        $TotalNov = collect($TotalNov2)
            ->groupBy('id_line')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        // biar remark nya kebawa semua 
        $testNov = [];
        $cobaNov = collect($dataNov)->where('remark', '!=', null)->groupBy('tgl_pengerjaan');
        foreach ($cobaNov as $key => $value) {
        $testNov[] = [
                'tgl_pengerjaan' => $key,
                'remark'=>  $value->implode('remark', ' | ')
            ];
        }
        $NovTerpenuhi = collect($TotalNov)->sum('terpenuhi');
        $NovFG = collect($TotalNov)->sum('fg');
        $NovBroken = collect($TotalNov)->sum('broken');
        $NovSkip = collect($TotalNov)->sum('skip');
        $NovPktw = collect($TotalNov)->sum('pktw');
        $NovCrooked = collect($TotalNov)->sum('crooked');
        $NovPleated = collect($TotalNov)->sum('pleated');
        $NovRos = collect($TotalNov)->sum('ros');
        $NovHtl = collect($TotalNov)->sum('htl');
        $NovButton = collect($TotalNov)->sum('button');
        $NovPrint = collect($TotalNov)->sum('print');
        $NovBs = collect($TotalNov)->sum('bs');
        $NovUnb = collect($TotalNov)->sum('unb');
        $NovShading = collect($TotalNov)->sum('shading');
        $NovDof = collect($TotalNov)->sum('dof');
        $NovDirty = collect($TotalNov)->sum('dirty');
        $NovShiny = collect($TotalNov)->sum('shiny');
        $NovSticker = collect($TotalNov)->sum('sticker');
        $NovTrimming = collect($TotalNov)->sum('trimming');
        $NovIP = collect($TotalNov)->sum('ip');
        $NovMeas = collect($TotalNov)->sum('meas');
        $NovOther = collect($TotalNov)->sum('other');
        $NovTotalCheck = collect($TotalNov)->sum('total_check');
        $NovTotalReject = collect($TotalNov)->sum('total_reject');
        $DFile = collect($dataNov)
                    ->groupBy('sep')
                    ->map(function ($item) {
                        return array_merge(...$item->toArray());
                    })->values()->toArray();
        if($DFile != null){
            $NovFile = $DFile[0];
        }else{
            $NovFile = null;
            $NovFile['file'] = null;
        }

        if($NovTerpenuhi != 0 || $NovFG != 0 || $NovBroken != 0 || $NovSkip != 0 || $NovPktw != 0 || $NovCrooked != 0
        || $NovPleated != 0 || $NovRos != 0 || $NovHtl != 0 || $NovButton != 0 || $NovPrint != 0 || $NovBs != 0
        || $NovUnb != 0 || $NovShading != 0 || $NovDof != 0 || $NovDirty != 0 || $NovShiny != 0 || $NovSticker != 0
        || $NovTrimming != 0 || $NovIP != 0 || $NovMeas != 0 || $NovOther != 0){
            $tot_fg = round($NovFG / $NovTerpenuhi *100,2);
            $tot_broken = round($NovBroken / $NovTerpenuhi *100,2);
            $tot_skip = round($NovSkip / $NovTerpenuhi *100,2);
            $tot_pktw = round($NovPktw / $NovTerpenuhi *100,2);
            $tot_crooked = round($NovCrooked / $NovTerpenuhi *100,2);
            $tot_pleated = round($NovPleated / $NovTerpenuhi *100,2);
            $tot_ros = round($NovRos / $NovTerpenuhi *100,2);
            $tot_htl = round($NovHtl / $NovTerpenuhi *100,2);
            $tot_button = round($NovButton / $NovTerpenuhi *100,2);
            $tot_print = round($NovPrint / $NovTerpenuhi *100,2);
            $tot_bs = round($NovBs / $NovTerpenuhi *100,2);
            $tot_unb = round($NovUnb / $NovTerpenuhi *100,2);
            $tot_shading = round($NovShading / $NovTerpenuhi *100,2);
            $tot_dof = round($NovDof / $NovTerpenuhi *100,2);
            $tot_dirty = round($NovDirty / $NovTerpenuhi *100,2);
            $tot_shiny = round($NovShiny / $NovTerpenuhi *100,2);
            $tot_sticker = round($NovSticker / $NovTerpenuhi *100,2);
            $tot_trimming = round($NovTrimming / $NovTerpenuhi *100,2);
            $tot_ip = round($NovIP / $NovTerpenuhi *100,2);
            $tot_meas = round($NovMeas / $NovTerpenuhi *100,2);
            $tot_other = round($NovOther / $NovTerpenuhi *100,2);
            $p_total_reject = round($NovTotalReject / $NovTerpenuhi *100,2);
        }else{
            $tot_fg = 0;
            $tot_broken = 0;
            $tot_skip = 0;
            $tot_pktw = 0;
            $tot_crooked = 0;
            $tot_pleated = 0;
            $tot_ros = 0;
            $tot_htl = 0;
            $tot_button = 0;
            $tot_print = 0;
            $tot_bs = 0;
            $tot_unb = 0;
            $tot_shading = 0;
            $tot_dof = 0;
            $tot_dirty = 0;
            $tot_shiny = 0;
            $tot_sticker = 0;
            $tot_trimming = 0;
            $tot_ip = 0;
            $tot_meas = 0;
            $tot_other = 0;
            $p_total_reject = 0;
        }
        
        $NovAll[] = [
            'target_terpenuhi' => $NovTerpenuhi,
            'fg' => $NovFG,
            'tot_fg' => $tot_fg,
            'broken' => $NovBroken,
            'tot_broken' => $tot_broken,
            'skip' => $NovSkip,
            'tot_skip' => $tot_skip,
            'pktw' => $NovPktw,
            'tot_pktw' => $tot_pktw,
            'crooked' => $NovCrooked,
            'tot_crooked' => $tot_crooked,
            'pleated' => $NovPleated,
            'tot_pleated' => $tot_pleated,
            'ros' => $NovRos,
            'tot_ros' => $tot_ros,
            'htl' => $NovHtl,
            'tot_htl' => $tot_htl,
            'button' => $NovButton,
            'tot_button' => $tot_button,
            'print' => $NovPrint,
            'tot_print' => $tot_print,
            'bs' => $NovBs,
            'tot_bs' => $tot_bs,
            'unb' => $NovUnb,
            'tot_unb' => $tot_unb,
            'shading' => $NovShading,
            'tot_shading' => $tot_shading,
            'dof' => $NovDof,
            'tot_dof' => $tot_dof,
            'dirty' => $NovDirty,
            'tot_dirty' => $tot_dirty,
            'shiny' => $NovShiny,
            'tot_shiny' => $tot_shiny,
            'sticker' => $NovSticker,
            'tot_sticker' => $tot_sticker,
            'trimming' => $NovTrimming,
            'tot_trimming' => $tot_trimming,
            'ip' => $NovIP,
            'tot_ip' => $tot_ip,
            'meas' => $NovMeas,
            'tot_meas' => $tot_meas,
            'other' => $NovOther,
            'tot_other' => $tot_other,
            'total_reject' => $NovTotalReject,
            'p_total_reject' => $p_total_reject,
            'total_check' => $NovTotalCheck,
            'file' => $NovFile['file']
        ];
        $totalNovember = $NovAll[0];
        $NovRemark = collect($dataNov)->where('remark', '!=', null)->implode('remark', ' | ');
        // end data bulan november 

        // data bulan desember
        $detailDes = LineDetail::where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get();
        $dataDes = [];
        foreach ($data as $key => $value) {
            foreach ($detailDes as $key2 => $value2) {
                if($value->id == $value2->id_line){
                    $desTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('target_terpenuhi');
                    $desCheck = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('total_check');
                    $desReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('total_reject');
                    $desFG = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('fg');
                    $desBroken = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('broken');
                    $desSkip = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('skip');
                    $desPktw = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('pktw');
                    $desCrooked = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('crooked');
                    $desPleated = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('pleated');
                    $desRos = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('ros');
                    $desHtl = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('htl');
                    $desButton = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('button');
                    $desPrint = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('print');
                    $desBs = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('bs');
                    $desUnb = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('unb');
                    $desShading = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('shading');
                    $desDof = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('dof');
                    $desDirty = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('dirty');
                    $desShiny = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('shiny');
                    $desSticker = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('sticker');
                    $desTrimming = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('trimming');
                    $desIP = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('ip');
                    $desMeas = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('meas');
                    $desOther = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('other');
                    $dataDes[] = [
                        'tgl_pengerjaan' => $value2->tgl_pengerjaan,
                        'terpenuhi' => $desTerpenuhi,
                        'fg' => $desFG,
                        'tot_fg' => round($desFG / $desTerpenuhi *100,2),
                        'broken' => $desBroken,
                        'tot_broken' => round($desBroken / $desTerpenuhi *100,2),
                        'skip' => $desSkip,
                        'tot_skip' => round($desSkip / $desTerpenuhi *100,2),
                        'pktw' => $desPktw,
                        'tot_pktw' => round($desPktw / $desTerpenuhi *100,2),
                        'crooked' => $desCrooked,
                        'tot_crooked' => round($desCrooked / $desTerpenuhi *100,2),
                        'pleated' => $desPleated,
                        'tot_pleated' => round($desPleated / $desTerpenuhi *100,2),
                        'ros' => $desRos,
                        'tot_ros' => round($desRos / $desTerpenuhi *100,2),
                        'htl' => $desHtl,
                        'tot_htl' => round($desHtl / $desTerpenuhi *100,2),
                        'button' => $desButton,
                        'tot_button' => round($desButton / $desTerpenuhi *100,2),
                        'print' => $desPrint,
                        'tot_print' => round($desPrint / $desTerpenuhi *100,2),
                        'bs' => $desBs,
                        'tot_bs' => round($desBs / $desTerpenuhi *100,2),
                        'unb' => $desUnb,
                        'tot_unb' => round($desUnb / $desTerpenuhi *100,2),
                        'shading' => $desShading,
                        'tot_shading' => round($desShading / $desTerpenuhi *100,2),
                        'dof' => $desDof,
                        'tot_dof' => round($desDof / $desTerpenuhi *100,2),
                        'dirty' => $desDirty,
                        'tot_dirty' => round($desDirty / $desTerpenuhi *100,2),
                        'shiny' => $desShiny,
                        'tot_shiny' => round($desShiny / $desTerpenuhi *100,2),
                        'sticker' => $desSticker,
                        'tot_sticker' => round($desSticker / $desTerpenuhi *100,2),
                        'trimming' => $desTrimming,
                        'tot_trimming' => round($desTrimming / $desTerpenuhi *100,2),
                        'ip' => $desIP,
                        'tot_ip' => round($desIP / $desTerpenuhi *100,2),
                        'meas' => $desMeas,
                        'tot_meas' => round($desMeas / $desTerpenuhi *100,2),
                        'other' => $desOther,
                        'tot_other' => round($desOther / $desTerpenuhi *100,2),
                        'total_reject' => $desReject,
                        'p_total_reject' => round($desReject/$desTerpenuhi*100,2),
                        'total_check' => $desCheck,
                        'remark' => $value2->string1,
                        'file' => $value2->file,
                        'sep' => 'sep',
                        'id_line' => $value2->id_line
                    ];
                }
            }
        }
        $TotalDes2 = collect($dataDes)
            ->groupBy('tgl_pengerjaan')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        $TotalDes = collect($TotalDes2)
            ->groupBy('id_line')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        // biar remark nya kebawa semua 
        $testDes = [];
        $cobaDes = collect($dataDes)->where('remark', '!=', null)->groupBy('tgl_pengerjaan');
        foreach ($cobaDes as $key => $value) {
        $testDes[] = [
                'tgl_pengerjaan' => $key,
                'remark'=>  $value->implode('remark', ' | ')
            ];
        }
        $DesTerpenuhi = collect($TotalDes)->sum('terpenuhi');
        $DesFG = collect($TotalDes)->sum('fg');
        $DesBroken = collect($TotalDes)->sum('broken');
        $DesSkip = collect($TotalDes)->sum('skip');
        $DesPktw = collect($TotalDes)->sum('pktw');
        $DesCrooked = collect($TotalDes)->sum('crooked');
        $DesPleated = collect($TotalDes)->sum('pleated');
        $DesRos = collect($TotalDes)->sum('ros');
        $DesHtl = collect($TotalDes)->sum('htl');
        $DesButton = collect($TotalDes)->sum('button');
        $DesPrint = collect($TotalDes)->sum('print');
        $DesBs = collect($TotalDes)->sum('bs');
        $DesUnb = collect($TotalDes)->sum('unb');
        $DesShading = collect($TotalDes)->sum('shading');
        $DesDof = collect($TotalDes)->sum('dof');
        $DesDirty = collect($TotalDes)->sum('dirty');
        $DesShiny = collect($TotalDes)->sum('shiny');
        $DesSticker = collect($TotalDes)->sum('sticker');
        $DesTrimming = collect($TotalDes)->sum('trimming');
        $DesIP = collect($TotalDes)->sum('ip');
        $DesMeas = collect($TotalDes)->sum('meas');
        $DesOther = collect($TotalDes)->sum('other');
        $DesTotalCheck = collect($TotalDes)->sum('total_check');
        $DesTotalReject = collect($TotalDes)->sum('total_reject');
        $EFile = collect($dataDes)
        ->groupBy('sep')
        ->map(function ($item) {
            return array_merge(...$item->toArray());
        })->values()->toArray();
        if($EFile != null){
            $DesFile = $EFile[0];
        }else{
            $DesFile = null;
            $DesFile['file'] = null;
        }
        
        if($DesTerpenuhi != 0 || $DesFG != 0 || $DesBroken != 0 || $DesSkip != 0 || $DesPktw != 0 || $DesCrooked != 0
        || $DesPleated != 0 || $DesRos != 0 || $DesHtl != 0 || $DesButton != 0 || $DesPrint != 0 || $DesBs != 0
        || $DesUnb != 0 || $DesShading != 0 || $DesDof != 0 || $DesDirty != 0 || $DesShiny != 0 || $DesSticker != 0
        || $DesTrimming != 0 || $DesIP != 0 || $DesMeas != 0 || $DesOther != 0){
            $tot_fg = round($DesFG / $DesTerpenuhi *100,2);
            $tot_broken = round($DesBroken / $DesTerpenuhi *100,2);
            $tot_skip = round($DesSkip / $DesTerpenuhi *100,2);
            $tot_pktw = round($DesPktw / $DesTerpenuhi *100,2);
            $tot_crooked = round($DesCrooked / $DesTerpenuhi *100,2);
            $tot_pleated = round($DesPleated / $DesTerpenuhi *100,2);
            $tot_ros = round($DesRos / $DesTerpenuhi *100,2);
            $tot_htl = round($DesHtl / $DesTerpenuhi *100,2);
            $tot_button = round($DesButton / $DesTerpenuhi *100,2);
            $tot_print = round($DesPrint / $DesTerpenuhi *100,2);
            $tot_bs = round($DesBs / $DesTerpenuhi *100,2);
            $tot_unb = round($DesUnb / $DesTerpenuhi *100,2);
            $tot_shading = round($DesShading / $DesTerpenuhi *100,2);
            $tot_dof = round($DesDof / $DesTerpenuhi *100,2);
            $tot_dirty = round($DesDirty / $DesTerpenuhi *100,2);
            $tot_shiny = round($DesShiny / $DesTerpenuhi *100,2);
            $tot_sticker = round($DesSticker / $DesTerpenuhi *100,2);
            $tot_trimming = round($DesTrimming / $DesTerpenuhi *100,2);
            $tot_ip = round($DesIP / $DesTerpenuhi *100,2);
            $tot_meas = round($DesMeas / $DesTerpenuhi *100,2);
            $tot_other = round($DesOther / $DesTerpenuhi *100,2);
            $p_total_reject = round($DesTotalReject / $DesTerpenuhi *100,2);
        }else{
            $tot_fg = 0;
            $tot_broken = 0;
            $tot_skip = 0;
            $tot_pktw = 0;
            $tot_crooked = 0;
            $tot_pleated = 0;
            $tot_ros = 0;
            $tot_htl = 0;
            $tot_button = 0;
            $tot_print = 0;
            $tot_bs = 0;
            $tot_unb = 0;
            $tot_shading = 0;
            $tot_dof = 0;
            $tot_dirty = 0;
            $tot_shiny = 0;
            $tot_sticker = 0;
            $tot_trimming = 0;
            $tot_ip = 0;
            $tot_meas = 0;
            $tot_other = 0;
            $p_total_reject = 0;
        }
        
        $DesAll[] = [
            'target_terpenuhi' => $DesTerpenuhi,
            'fg' => $DesFG,
            'tot_fg' => $tot_fg,
            'broken' => $DesBroken,
            'tot_broken' => $tot_broken,
            'skip' => $DesSkip,
            'tot_skip' => $tot_skip,
            'pktw' => $DesPktw,
            'tot_pktw' => $tot_pktw,
            'crooked' => $DesCrooked,
            'tot_crooked' => $tot_crooked,
            'pleated' => $DesPleated,
            'tot_pleated' => $tot_pleated,
            'ros' => $DesRos,
            'tot_ros' => $tot_ros,
            'htl' => $DesHtl,
            'tot_htl' => $tot_htl,
            'button' => $DesButton,
            'tot_button' => $tot_button,
            'print' => $DesPrint,
            'tot_print' => $tot_print,
            'bs' => $DesBs,
            'tot_bs' => $tot_bs,
            'unb' => $DesUnb,
            'tot_unb' => $tot_unb,
            'shading' => $DesShading,
            'tot_shading' => $tot_shading,
            'dof' => $DesDof,
            'tot_dof' => $tot_dof,
            'dirty' => $DesDirty,
            'tot_dirty' => $tot_dirty,
            'shiny' => $DesShiny,
            'tot_shiny' => $tot_shiny,
            'sticker' => $DesSticker,
            'tot_sticker' => $tot_sticker,
            'trimming' => $DesTrimming,
            'tot_trimming' => $tot_trimming,
            'ip' => $DesIP,
            'tot_ip' => $tot_ip,
            'meas' => $DesMeas,
            'tot_meas' => $tot_meas,
            'other' => $DesOther,
            'tot_other' => $tot_other,
            'total_reject' => $DesTotalReject,
            'p_total_reject' => $p_total_reject,
            'total_check' => $DesTotalCheck,
            'file' => $DesFile['file']
        ];
        $totalDesember = $DesAll[0];
        $DesRemark = collect($dataDes)->where('remark', '!=', null)->implode('remark', ' | ');
        // end data bulan desember 

        // data total All Line
        $allTerpenuhi = $totalJanuari['target_terpenuhi'] + $totalFebruari['target_terpenuhi'] + $totalMaret['target_terpenuhi'] + $totalApril['target_terpenuhi'] +
                        $totalMei['target_terpenuhi'] + $totalJuni['target_terpenuhi'] + $totalJuli['target_terpenuhi'] + $totalAgustus['target_terpenuhi'] +
                        $totalSeptember['target_terpenuhi'] + $totalOktober['target_terpenuhi'] + $totalNovember['target_terpenuhi'] + $totalDesember['target_terpenuhi'];
        $allFG = $totalJanuari['fg'] + $totalFebruari['fg'] + $totalMaret['fg'] + $totalApril['fg'] +
                        $totalMei['fg'] + $totalJuni['fg'] + $totalJuli['fg'] + $totalAgustus['fg'] +
                        $totalSeptember['fg'] + $totalOktober['fg'] + $totalNovember['fg'] + $totalDesember['fg'];
        $allBroken = $totalJanuari['broken'] + $totalFebruari['broken'] + $totalMaret['broken'] + $totalApril['broken'] +
                        $totalMei['broken'] + $totalJuni['broken'] + $totalJuli['broken'] + $totalAgustus['broken'] +
                        $totalSeptember['broken'] + $totalOktober['broken'] + $totalNovember['broken'] + $totalDesember['broken'];
        $allSkip = $totalJanuari['skip'] + $totalFebruari['skip'] + $totalMaret['skip'] + $totalApril['skip'] +
                        $totalMei['skip'] + $totalJuni['skip'] + $totalJuli['skip'] + $totalAgustus['skip'] +
                        $totalSeptember['skip'] + $totalOktober['skip'] + $totalNovember['skip'] + $totalDesember['skip'];
        $allPktw = $totalJanuari['pktw'] + $totalFebruari['pktw'] + $totalMaret['pktw'] + $totalApril['pktw'] +
                        $totalMei['pktw'] + $totalJuni['pktw'] + $totalJuli['pktw'] + $totalAgustus['pktw'] +
                        $totalSeptember['pktw'] + $totalOktober['pktw'] + $totalNovember['pktw'] + $totalDesember['pktw'];
        $allCrooked = $totalJanuari['crooked'] + $totalFebruari['crooked'] + $totalMaret['crooked'] + $totalApril['crooked'] +
                        $totalMei['crooked'] + $totalJuni['crooked'] + $totalJuli['crooked'] + $totalAgustus['crooked'] +
                        $totalSeptember['crooked'] + $totalOktober['crooked'] + $totalNovember['crooked'] + $totalDesember['crooked'];
        $allPleated = $totalJanuari['pleated'] + $totalFebruari['pleated'] + $totalMaret['pleated'] + $totalApril['pleated'] +
                        $totalMei['pleated'] + $totalJuni['pleated'] + $totalJuli['pleated'] + $totalAgustus['pleated'] +
                        $totalSeptember['pleated'] + $totalOktober['pleated'] + $totalNovember['pleated'] + $totalDesember['pleated'];
        $allRos = $totalJanuari['ros'] + $totalFebruari['ros'] + $totalMaret['ros'] + $totalApril['ros'] +
                        $totalMei['ros'] + $totalJuni['ros'] + $totalJuli['ros'] + $totalAgustus['ros'] +
                        $totalSeptember['ros'] + $totalOktober['ros'] + $totalNovember['ros'] + $totalDesember['ros'];
        $allHtl = $totalJanuari['htl'] + $totalFebruari['htl'] + $totalMaret['htl'] + $totalApril['htl'] +
                        $totalMei['htl'] + $totalJuni['htl'] + $totalJuli['htl'] + $totalAgustus['htl'] +
                        $totalSeptember['htl'] + $totalOktober['htl'] + $totalNovember['htl'] + $totalDesember['htl'];
        $allButton = $totalJanuari['button'] + $totalFebruari['button'] + $totalMaret['button'] + $totalApril['button'] +
                        $totalMei['button'] + $totalJuni['button'] + $totalJuli['button'] + $totalAgustus['button'] +
                        $totalSeptember['button'] + $totalOktober['button'] + $totalNovember['button'] + $totalDesember['button'];
        $allPrint = $totalJanuari['print'] + $totalFebruari['print'] + $totalMaret['print'] + $totalApril['print'] +
                        $totalMei['print'] + $totalJuni['print'] + $totalJuli['print'] + $totalAgustus['print'] +
                        $totalSeptember['print'] + $totalOktober['print'] + $totalNovember['print'] + $totalDesember['print'];
        $allBs = $totalJanuari['bs'] + $totalFebruari['bs'] + $totalMaret['bs'] + $totalApril['bs'] +
                        $totalMei['bs'] + $totalJuni['bs'] + $totalJuli['bs'] + $totalAgustus['bs'] +
                        $totalSeptember['bs'] + $totalOktober['bs'] + $totalNovember['bs'] + $totalDesember['bs']; 
        $allUnb = $totalJanuari['unb'] + $totalFebruari['unb'] + $totalMaret['unb'] + $totalApril['unb'] +
                        $totalMei['unb'] + $totalJuni['unb'] + $totalJuli['unb'] + $totalAgustus['unb'] +
                        $totalSeptember['unb'] + $totalOktober['unb'] + $totalNovember['unb'] + $totalDesember['unb'];
        $allShading = $totalJanuari['shading'] + $totalFebruari['shading'] + $totalMaret['shading'] + $totalApril['shading'] +
                        $totalMei['shading'] + $totalJuni['shading'] + $totalJuli['shading'] + $totalAgustus['shading'] +
                        $totalSeptember['shading'] + $totalOktober['shading'] + $totalNovember['shading'] + $totalDesember['shading'];
        $allDof = $totalJanuari['dof'] + $totalFebruari['dof'] + $totalMaret['dof'] + $totalApril['dof'] +
                        $totalMei['dof'] + $totalJuni['dof'] + $totalJuli['dof'] + $totalAgustus['dof'] +
                        $totalSeptember['dof'] + $totalOktober['dof'] + $totalNovember['dof'] + $totalDesember['dof'];
        $allDirty = $totalJanuari['dirty'] + $totalFebruari['dirty'] + $totalMaret['dirty'] + $totalApril['dirty'] +
                        $totalMei['dirty'] + $totalJuni['dirty'] + $totalJuli['dirty'] + $totalAgustus['dirty'] +
                        $totalSeptember['dirty'] + $totalOktober['dirty'] + $totalNovember['dirty'] + $totalDesember['dirty'];
        $allShiny = $totalJanuari['shiny'] + $totalFebruari['shiny'] + $totalMaret['shiny'] + $totalApril['shiny'] +
                        $totalMei['shiny'] + $totalJuni['shiny'] + $totalJuli['shiny'] + $totalAgustus['shiny'] +
                        $totalSeptember['shiny'] + $totalOktober['shiny'] + $totalNovember['shiny'] + $totalDesember['shiny'];
        $allSticker = $totalJanuari['sticker'] + $totalFebruari['sticker'] + $totalMaret['sticker'] + $totalApril['sticker'] +
                        $totalMei['sticker'] + $totalJuni['sticker'] + $totalJuli['sticker'] + $totalAgustus['sticker'] +
                        $totalSeptember['sticker'] + $totalOktober['sticker'] + $totalNovember['sticker'] + $totalDesember['sticker'];
        $allTrimming = $totalJanuari['trimming'] + $totalFebruari['trimming'] + $totalMaret['trimming'] + $totalApril['trimming'] +
                        $totalMei['trimming'] + $totalJuni['trimming'] + $totalJuli['trimming'] + $totalAgustus['trimming'] +
                        $totalSeptember['trimming'] + $totalOktober['trimming'] + $totalNovember['trimming'] + $totalDesember['trimming'];
        $allIP = $totalJanuari['ip'] + $totalFebruari['ip'] + $totalMaret['ip'] + $totalApril['ip'] +
                        $totalMei['ip'] + $totalJuni['ip'] + $totalJuli['ip'] + $totalAgustus['ip'] +
                        $totalSeptember['ip'] + $totalOktober['ip'] + $totalNovember['ip'] + $totalDesember['ip'];
        $allMeas = $totalJanuari['meas'] + $totalFebruari['meas'] + $totalMaret['meas'] + $totalApril['meas'] +
                        $totalMei['meas'] + $totalJuni['meas'] + $totalJuli['meas'] + $totalAgustus['meas'] +
                        $totalSeptember['meas'] + $totalOktober['meas'] + $totalNovember['meas'] + $totalDesember['meas']; 
        $allOther = $totalJanuari['other'] + $totalFebruari['other'] + $totalMaret['other'] + $totalApril['other'] +
                        $totalMei['other'] + $totalJuni['other'] + $totalJuli['other'] + $totalAgustus['other'] +
                        $totalSeptember['other'] + $totalOktober['other'] + $totalNovember['other'] + $totalDesember['other'];
        $allTotalReject = $totalJanuari['total_reject'] + $totalFebruari['total_reject'] + $totalMaret['total_reject'] + $totalApril['total_reject'] +
                        $totalMei['total_reject'] + $totalJuni['total_reject'] + $totalJuli['total_reject'] + $totalAgustus['total_reject'] +
                        $totalSeptember['total_reject'] + $totalOktober['total_reject'] + $totalNovember['total_reject'] + $totalDesember['total_reject'];
        $allTotalCheck = $totalJanuari['total_check'] + $totalFebruari['total_check'] + $totalMaret['total_check'] + $totalApril['total_check'] +
                        $totalMei['total_check'] + $totalJuni['total_check'] + $totalJuli['total_check'] + $totalAgustus['total_check'] +
                        $totalSeptember['total_check'] + $totalOktober['total_check'] + $totalNovember['total_check'] + $totalDesember['total_check'];
        
        if($allTerpenuhi != 0 || $allFG != 0 || $allBroken != 0 || $allSkip != 0 || $allPktw != 0 || $allCrooked != 0
        || $allPleated != 0 || $allRos != 0 || $allHtl != 0 || $allButton != 0 || $allPrint != 0 || $allBs != 0
        || $allUnb != 0 || $allShading != 0 || $allDof != 0 || $allDirty != 0 || $allShiny != 0 || $allSticker != 0
        || $allTrimming != 0 || $allIP != 0 || $allMeas != 0 || $allOther != 0){
            $tot_fg = round($allFG / $allTerpenuhi *100,2);
            $tot_broken = round($allBroken / $allTerpenuhi *100,2);
            $tot_skip = round($allSkip / $allTerpenuhi *100,2);
            $tot_pktw = round($allPktw / $allTerpenuhi *100,2);
            $tot_crooked = round($allCrooked / $allTerpenuhi *100,2);
            $tot_pleated = round($allPleated / $allTerpenuhi *100,2);
            $tot_ros = round($allRos / $allTerpenuhi *100,2);
            $tot_htl = round($allHtl / $allTerpenuhi *100,2);
            $tot_button = round($allButton / $allTerpenuhi *100,2);
            $tot_print = round($allPrint / $allTerpenuhi *100,2);
            $tot_bs = round($allBs / $allTerpenuhi *100,2);
            $tot_unb = round($allUnb / $allTerpenuhi *100,2);
            $tot_shading = round($allShading / $allTerpenuhi *100,2);
            $tot_dof = round($allDof / $allTerpenuhi *100,2);
            $tot_dirty = round($allDirty / $allTerpenuhi *100,2);
            $tot_shiny = round($allShiny / $allTerpenuhi *100,2);
            $tot_sticker = round($allSticker / $allTerpenuhi *100,2);
            $tot_trimming = round($allTrimming / $allTerpenuhi *100,2);
            $tot_ip = round($allIP / $allTerpenuhi *100,2);
            $tot_meas = round($allMeas / $allTerpenuhi *100,2);
            $tot_other = round($allOther / $allTerpenuhi *100,2);
            $p_total_reject = round($allTotalReject / $allTerpenuhi *100,2);
        }else{
            $tot_fg = 0;
            $tot_broken = 0;
            $tot_skip = 0;
            $tot_pktw = 0;
            $tot_crooked = 0;
            $tot_pleated = 0;
            $tot_ros = 0;
            $tot_htl = 0;
            $tot_button = 0;
            $tot_print = 0;
            $tot_bs = 0;
            $tot_unb = 0;
            $tot_shading = 0;
            $tot_dof = 0;
            $tot_dirty = 0;
            $tot_shiny = 0;
            $tot_sticker = 0;
            $tot_trimming = 0;
            $tot_ip = 0;
            $tot_meas = 0;
            $tot_other = 0;
            $p_total_reject = 0;
        }
        
        
        $totalData = [
            'fg' => $allFG,
            'target_terpenuhi' => $allTerpenuhi,
            'fg' => $allFG,
            'tot_fg' => $tot_fg,
            'broken' => $allBroken,
            'tot_broken' => $tot_broken,
            'skip' => $allSkip,
            'tot_skip' => $tot_skip,
            'pktw' => $allPktw,
            'tot_pktw' => $tot_pktw,
            'crooked' => $allCrooked,
            'tot_crooked' => $tot_crooked,
            'pleated' => $allPleated,
            'tot_pleated' => $tot_pleated,
            'ros' => $allRos,
            'tot_ros' => $tot_ros,
            'htl' => $allHtl,
            'tot_htl' => $tot_htl,
            'button' => $allButton,
            'tot_button' => $tot_button,
            'print' => $allPrint,
            'tot_print' => $tot_print,
            'bs' => $allBs,
            'tot_bs' => $tot_bs,
            'unb' => $allUnb,
            'tot_unb' => $tot_unb,
            'shading' => $allShading,
            'tot_shading' => $tot_shading,
            'dof' => $allDof,
            'tot_dof' => $tot_dof,
            'dirty' => $allDirty,
            'tot_dirty' => $tot_dirty,
            'shiny' => $allShiny,
            'tot_shiny' => $tot_shiny,
            'sticker' => $allSticker,
            'tot_sticker' => $tot_sticker,
            'trimming' => $allTrimming,
            'tot_trimming' => $tot_trimming,
            'ip' => $allIP,
            'tot_ip' => $tot_ip,
            'meas' => $allMeas,
            'tot_meas' => $tot_meas,
            'other' => $allOther,
            'tot_other' => $tot_other,
            'total_reject' => $allTotalReject,
            'p_total_reject' => $p_total_reject,
            'total_check' => $allTotalCheck
        ];
        // end data total All Line
        return view('qc/rework/report/rtahunan', compact('totalJanuari', 'JanRemark', 'totalFebruari', 'FebRemark', 'totalMaret', 'MarRemark',
        'totalApril', 'AprRemark', 'totalMei', 'MeiRemark', 'totalJuni', 'JunRemark', 'totalJuli', 'JulRemark', 
        'totalAgustus', 'AgsRemark', 'totalSeptember', 'SepRemark', 'totalOktober', 'OktRemark', 'totalNovember', 'NovRemark',
        'totalDesember', 'DesRemark', 'branch', 'branch_detail', 'tahun', 'totalData'));
    }

    public function tahunanPDF(Request $request)
    {
        // untuk filter branch
        if ($request->branch == 'CLN') {
            $branch = 'CLN';
            $branch_detail = 'CLN';
        }elseif($request->branch == 'MAJA1'){
            $branch = 'MAJA';
            $branch_detail = 'GM1';
        }elseif($request->branch == 'MAJA2'){
            $branch = 'MAJA';
            $branch_detail = 'GM2';
        }
        elseif($request->branch == 'GS'){
            $branch = 'GS';
            $branch_detail = 'GS';
        }elseif($request->branch == 'GK'){
            $branch = 'GK';
            $branch_detail = 'GK';
        }
        // end 
        $input = $request->all();
        $tahun = $request->tahun;
        // list bulan 
        $januari = date($tahun.'-01');
        $februari = date($tahun.'-02');
        $maret = date($tahun.'-03');
        $april = date($tahun.'-04');
        $mei = date($tahun.'-05');
        $juni = date($tahun.'-06');
        $juli = date($tahun.'-07');
        $agustus = date($tahun.'-08');
        $september = date($tahun.'-09');
        $oktober = date($tahun.'-10');
        $november = date($tahun.'-11');
        $desember = date($tahun.'-12');
        // end list bulan 

        // Inisialisasi untuk menentukan tanggal awal dan tanggal akhir tiap bulan 
        #januari
        $janAwal = Carbon::createFromFormat('Y-m', $januari)->firstOfMonth()->format('Y-m-d');
        $janAkhir = Carbon::createFromFormat('Y-m', $januari)->endOfMonth()->format('Y-m-d');
        #februari
        $febAwal = Carbon::createFromFormat('Y-m', $februari)->firstOfMonth()->format('Y-m-d');
        $febAkhir = Carbon::createFromFormat('Y-m', $februari)->endOfMonth()->format('Y-m-d');    
        #maret
        $marAwal = Carbon::createFromFormat('Y-m', $maret)->firstOfMonth()->format('Y-m-d');
        $marAkhir = Carbon::createFromFormat('Y-m', $maret)->endOfMonth()->format('Y-m-d');   
        #april
        $aprAwal = Carbon::createFromFormat('Y-m', $april)->firstOfMonth()->format('Y-m-d');
        $aprAkhir = Carbon::createFromFormat('Y-m', $april)->endOfMonth()->format('Y-m-d');   
        #mei
        $meiAwal = Carbon::createFromFormat('Y-m', $mei)->firstOfMonth()->format('Y-m-d');
        $meiAkhir = Carbon::createFromFormat('Y-m', $mei)->endOfMonth()->format('Y-m-d');
        #juni
        $junAwal = Carbon::createFromFormat('Y-m', $juni)->firstOfMonth()->format('Y-m-d');
        $junAkhir = Carbon::createFromFormat('Y-m', $juni)->endOfMonth()->format('Y-m-d');   
        #juli
        $julAwal = Carbon::createFromFormat('Y-m', $juli)->firstOfMonth()->format('Y-m-d');
        $julAkhir = Carbon::createFromFormat('Y-m', $juli)->endOfMonth()->format('Y-m-d');   
        #agustus
        $agsAwal = Carbon::createFromFormat('Y-m', $agustus)->firstOfMonth()->format('Y-m-d');
        $agsAkhir = Carbon::createFromFormat('Y-m', $agustus)->endOfMonth()->format('Y-m-d');   
        #september
        $sepAwal = Carbon::createFromFormat('Y-m', $september)->firstOfMonth()->format('Y-m-d');
        $sepAkhir = Carbon::createFromFormat('Y-m', $september)->endOfMonth()->format('Y-m-d');   
        #oktober
        $oktAwal = Carbon::createFromFormat('Y-m', $oktober)->firstOfMonth()->format('Y-m-d');
        $oktAkhir = Carbon::createFromFormat('Y-m', $oktober)->endOfMonth()->format('Y-m-d');   
        #november
        $novAwal = Carbon::createFromFormat('Y-m', $november)->firstOfMonth()->format('Y-m-d');
        $novAkhir = Carbon::createFromFormat('Y-m', $november)->endOfMonth()->format('Y-m-d');   
        #desember
        $desAwal = Carbon::createFromFormat('Y-m', $desember)->firstOfMonth()->format('Y-m-d');
        $desAkhir = Carbon::createFromFormat('Y-m', $desember)->endOfMonth()->format('Y-m-d');   
        // end Inisialisasi 

        // data di bulan Januari 
        $data =  MasterLine::where('branch', $branch)
                ->where('branch_detail', $branch_detail)
                ->get();
        $detailJan = LineDetail::where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get();
        $dataJan = [];
        foreach ($data as $key => $value) {
            foreach ($detailJan as $key2 => $value2) {
                if($value->id == $value2->id_line){
                    $janTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('target_terpenuhi');
                    $janCheck = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('total_check');
                    $janReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('total_reject');
                    $janFG = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('fg');
                    $janBroken = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('broken');
                    $janSkip = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('skip');
                    $janPktw = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('pktw');
                    $janCrooked = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('crooked');
                    $janPleated = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('pleated');
                    $janRos = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('ros');
                    $janHtl = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('htl');
                    $janButton = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('button');
                    $janPrint = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('print');
                    $janBs = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('bs');
                    $janUnb = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('unb');
                    $janShading = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('shading');
                    $janDof = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('dof');
                    $janDirty = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('dirty');
                    $janShiny = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('shiny');
                    $janSticker = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('sticker');
                    $janTrimming = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('trimming');
                    $janIP = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('ip');
                    $janMeas = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('meas');
                    $janOther = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('other');
                    $dataJan[] = [
                        'id_line' => $value2->id_line,
                        'tgl_pengerjaan' => $value2->tgl_pengerjaan,
                        'terpenuhi' => $janTerpenuhi,
                        'fg' => $janFG,
                        'tot_fg' => round($janFG / $janTerpenuhi *100,2),
                        'broken' => $janBroken,
                        'tot_broken' => round($janBroken / $janTerpenuhi *100,2),
                        'skip' => $janSkip,
                        'tot_skip' => round($janSkip / $janTerpenuhi *100,2),
                        'pktw' => $janPktw,
                        'tot_pktw' => round($janPktw / $janTerpenuhi *100,2),
                        'crooked' => $janCrooked,
                        'tot_crooked' => round($janCrooked / $janTerpenuhi *100,2),
                        'pleated' => $janPleated,
                        'tot_pleated' => round($janPleated / $janTerpenuhi *100,2),
                        'ros' => $janRos,
                        'tot_ros' => round($janRos / $janTerpenuhi *100,2),
                        'htl' => $janHtl,
                        'tot_htl' => round($janHtl / $janTerpenuhi *100,2),
                        'button' => $janButton,
                        'tot_button' => round($janButton / $janTerpenuhi *100,2),
                        'print' => $janPrint,
                        'tot_print' => round($janPrint / $janTerpenuhi *100,2),
                        'bs' => $janBs,
                        'tot_bs' => round($janBs / $janTerpenuhi *100,2),
                        'unb' => $janUnb,
                        'tot_unb' => round($janUnb / $janTerpenuhi *100,2),
                        'shading' => $janShading,
                        'tot_shading' => round($janShading / $janTerpenuhi *100,2),
                        'dof' => $janDof,
                        'tot_dof' => round($janDof / $janTerpenuhi *100,2),
                        'dirty' => $janDirty,
                        'tot_dirty' => round($janDirty / $janTerpenuhi *100,2),
                        'shiny' => $janShiny,
                        'tot_shiny' => round($janShiny / $janTerpenuhi *100,2),
                        'sticker' => $janSticker,
                        'tot_sticker' => round($janSticker / $janTerpenuhi *100,2),
                        'trimming' => $janTrimming,
                        'tot_trimming' => round($janTrimming / $janTerpenuhi *100,2),
                        'ip' => $janIP,
                        'tot_ip' => round($janIP / $janTerpenuhi *100,2),
                        'meas' => $janMeas,
                        'tot_meas' => round($janMeas / $janTerpenuhi *100,2),
                        'other' => $janOther,
                        'tot_other' => round($janOther / $janTerpenuhi *100,2),
                        'total_reject' => $janReject,
                        'p_total_reject' => round($janReject / $janTerpenuhi *100,2),
                        'total_check' => $janCheck,
                        'remark' => $value2->string1
                    ];
                }
            }
        }
        $TotalJan2 = collect($dataJan)
            ->groupBy('tgl_pengerjaan')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        $TotalJan = collect($TotalJan2)
        ->groupBy('id_line')
        ->map(function ($item) {
            return array_merge(...$item->toArray());
        })->values()->toArray();

        // biar remark nya kebawa semua 
        $testJan = [];
        $cobaJan = collect($dataJan)->where('remark', '!=', null)->groupBy('tgl_pengerjaan');
        foreach ($cobaJan as $key => $value) {
        $testJan[] = [
                'tgl_pengerjaan' => $key,
                'remark'=>  $value->implode('remark', ' | ')
            ];
        }
        $JanTerpenuhi = collect($TotalJan)->sum('terpenuhi');
        $JanFG = collect($TotalJan)->sum('fg');
        $JanBroken = collect($TotalJan)->sum('broken');
        $JanSkip = collect($TotalJan)->sum('skip');
        $JanPktw = collect($TotalJan)->sum('pktw');
        $JanCrooked = collect($TotalJan)->sum('crooked');
        $JanPleated = collect($TotalJan)->sum('pleated');
        $JanRos = collect($TotalJan)->sum('ros');
        $JanHtl = collect($TotalJan)->sum('htl');
        $JanButton = collect($TotalJan)->sum('button');
        $JanPrint = collect($TotalJan)->sum('print');
        $JanBs = collect($TotalJan)->sum('bs');
        $JanUnb = collect($TotalJan)->sum('unb');
        $JanShading = collect($TotalJan)->sum('shading');
        $JanDof = collect($TotalJan)->sum('dof');
        $JanDirty = collect($TotalJan)->sum('dirty');
        $JanShiny = collect($TotalJan)->sum('shiny');
        $JanSticker = collect($TotalJan)->sum('sticker');
        $JanTrimming = collect($TotalJan)->sum('trimming');
        $JanIP = collect($TotalJan)->sum('ip');
        $JanMeas = collect($TotalJan)->sum('meas');
        $JanOther = collect($TotalJan)->sum('other');
        $JanTotalCheck = collect($TotalJan)->sum('total_check');
        $JanTotalReject = collect($TotalJan)->sum('total_reject');

        if($JanTerpenuhi != 0 || $JanFG != 0 || $JanBroken != 0 || $JanSkip != 0 || $JanPktw != 0 || $JanCrooked != 0
        || $JanPleated != 0 || $JanRos != 0 || $JanHtl != 0 || $JanButton != 0 || $JanPrint != 0 || $JanBs != 0
        || $JanUnb != 0 || $JanShading != 0 || $JanDof != 0 || $JanDirty != 0 || $JanShiny != 0 || $JanSticker != 0
        || $JanTrimming != 0 || $JanIP != 0 || $JanMeas != 0 || $JanOther != 0){
            $tot_fg = round($JanFG / $JanTerpenuhi *100,2);
            $tot_broken = round($JanBroken / $JanTerpenuhi *100,2);
            $tot_skip = round($JanSkip / $JanTerpenuhi *100,2);
            $tot_pktw = round($JanPktw / $JanTerpenuhi *100,2);
            $tot_crooked = round($JanCrooked / $JanTerpenuhi *100,2);
            $tot_pleated = round($JanPleated / $JanTerpenuhi *100,2);
            $tot_ros = round($JanRos / $JanTerpenuhi *100,2);
            $tot_htl = round($JanHtl / $JanTerpenuhi *100,2);
            $tot_button = round($JanButton / $JanTerpenuhi *100,2);
            $tot_print = round($JanPrint / $JanTerpenuhi *100,2);
            $tot_bs = round($JanBs / $JanTerpenuhi *100,2);
            $tot_unb = round($JanUnb / $JanTerpenuhi *100,2);
            $tot_shading = round($JanShading / $JanTerpenuhi *100,2);
            $tot_dof = round($JanDof / $JanTerpenuhi *100,2);
            $tot_dirty = round($JanDirty / $JanTerpenuhi *100,2);
            $tot_shiny = round($JanShiny / $JanTerpenuhi *100,2);
            $tot_sticker = round($JanSticker / $JanTerpenuhi *100,2);
            $tot_trimming = round($JanTrimming / $JanTerpenuhi *100,2);
            $tot_ip = round($JanIP / $JanTerpenuhi *100,2);
            $tot_meas = round($JanMeas / $JanTerpenuhi *100,2);
            $tot_other = round($JanOther / $JanTerpenuhi *100,2);
            $p_total_reject = round($JanTotalReject/$JanTerpenuhi*100,2);
        }else{
            $tot_fg = 0;
            $tot_broken = 0;
            $tot_skip = 0;
            $tot_pktw = 0;
            $tot_crooked = 0;
            $tot_pleated = 0;
            $tot_ros = 0;
            $tot_htl = 0;
            $tot_button = 0;
            $tot_print = 0;
            $tot_bs = 0;
            $tot_unb = 0;
            $tot_shading = 0;
            $tot_dof = 0;
            $tot_dirty = 0;
            $tot_shiny = 0;
            $tot_sticker = 0;
            $tot_trimming = 0;
            $tot_ip = 0;
            $tot_meas = 0;
            $tot_other = 0;
            $p_total_reject = 0;
        }
        
        $JanAll[] = [
            'target_terpenuhi' => $JanTerpenuhi,
            'fg' => $JanFG,
            'tot_fg' => $tot_fg,
            'broken' => $JanBroken,
            'tot_broken' => $tot_broken,
            'skip' => $JanSkip,
            'tot_skip' => $tot_skip,
            'pktw' => $JanPktw,
            'tot_pktw' => $tot_pktw,
            'crooked' => $JanCrooked,
            'tot_crooked' => $tot_crooked,
            'pleated' => $JanPleated,
            'tot_pleated' => $tot_pleated,
            'ros' => $JanRos,
            'tot_ros' => $tot_ros,
            'htl' => $JanHtl,
            'tot_htl' => $tot_htl,
            'button' => $JanButton,
            'tot_button' => $tot_button,
            'print' => $JanPrint,
            'tot_print' => $tot_print,
            'bs' => $JanBs,
            'tot_bs' => $tot_bs,
            'unb' => $JanUnb,
            'tot_unb' => $tot_unb,
            'shading' => $JanShading,
            'tot_shading' => $tot_shading,
            'dof' => $JanDof,
            'tot_dof' => $tot_dof,
            'dirty' => $JanDirty,
            'tot_dirty' => $tot_dirty,
            'shiny' => $JanShiny,
            'tot_shiny' => $tot_shiny,
            'sticker' => $JanSticker,
            'tot_sticker' => $tot_sticker,
            'trimming' => $JanTrimming,
            'tot_trimming' => $tot_trimming,
            'ip' => $JanIP,
            'tot_ip' => $tot_ip,
            'meas' => $JanMeas,
            'tot_meas' => $tot_meas,
            'other' => $JanOther,
            'tot_other' => $tot_other,
            'total_reject' => $JanTotalReject,
            'p_total_reject' => $p_total_reject,
            'total_check' => $JanTotalCheck
        ];
        $totalJanuari = $JanAll[0];
        $JanRemark = collect($dataJan)->where('remark', '!=', null)->implode('remark', ' | ');
        // end data januari

        // data bulan februari
        $detailFeb = LineDetail::where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get();
        $dataFeb = [];
        foreach ($data as $key => $value) {
            foreach ($detailFeb as $key2 => $value2) {
                if($value->id == $value2->id_line){
                    $febTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('target_terpenuhi');
                    $febCheck = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('total_check');
                    $febReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('total_reject');
                    $febFG = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('fg');
                    $febBroken = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('broken');
                    $febSkip = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('skip');
                    $febPktw = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('pktw');
                    $febCrooked = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('crooked');
                    $febPleated = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('pleated');
                    $febRos = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('ros');
                    $febHtl = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('htl');
                    $febButton = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('button');
                    $febPrint = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('print');
                    $febBs = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('bs');
                    $febUnb = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('unb');
                    $febShading = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('shading');
                    $febDof = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('dof');
                    $febDirty = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('dirty');
                    $febShiny = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('shiny');
                    $febSticker = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('sticker');
                    $febTrimming = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('trimming');
                    $febIP = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('ip');
                    $febMeas = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('meas');
                    $febOther = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('other');
                    $dataFeb[] = [
                        'id_line' => $value2->id_line,
                        'tgl_pengerjaan' => $value2->tgl_pengerjaan,
                        'terpenuhi' => $febTerpenuhi,
                        'fg' => $febFG,
                        'tot_fg' => round($febFG / $febTerpenuhi *100,2),
                        'broken' => $febBroken,
                        'tot_broken' => round($febBroken / $febTerpenuhi *100,2),
                        'skip' => $febSkip,
                        'tot_skip' => round($febSkip / $febTerpenuhi *100,2),
                        'pktw' => $febPktw,
                        'tot_pktw' => round($febPktw / $febTerpenuhi *100,2),
                        'crooked' => $febCrooked,
                        'tot_crooked' => round($febCrooked / $febTerpenuhi *100,2),
                        'pleated' => $febPleated,
                        'tot_pleated' => round($febPleated / $febTerpenuhi *100,2),
                        'ros' => $febRos,
                        'tot_ros' => round($febRos / $febTerpenuhi *100,2),
                        'htl' => $febHtl,
                        'tot_htl' => round($febHtl / $febTerpenuhi *100,2),
                        'button' => $febButton,
                        'tot_button' => round($febButton / $febTerpenuhi *100,2),
                        'print' => $febPrint,
                        'tot_print' => round($febPrint / $febTerpenuhi *100,2),
                        'bs' => $febBs,
                        'tot_bs' => round($febBs / $febTerpenuhi *100,2),
                        'unb' => $febUnb,
                        'tot_unb' => round($febUnb / $febTerpenuhi *100,2),
                        'shading' => $febShading,
                        'tot_shading' => round($febShading / $febTerpenuhi *100,2),
                        'dof' => $febDof,
                        'tot_dof' => round($febDof / $febTerpenuhi *100,2),
                        'dirty' => $febDirty,
                        'tot_dirty' => round($febDirty / $febTerpenuhi *100,2),
                        'shiny' => $febShiny,
                        'tot_shiny' => round($febShiny / $febTerpenuhi *100,2),
                        'sticker' => $febSticker,
                        'tot_sticker' => round($febSticker / $febTerpenuhi *100,2),
                        'trimming' => $febTrimming,
                        'tot_trimming' => round($febTrimming / $febTerpenuhi *100,2),
                        'ip' => $febIP,
                        'tot_ip' => round($febIP / $febTerpenuhi *100,2),
                        'meas' => $febMeas,
                        'tot_meas' => round($febMeas / $febTerpenuhi *100,2),
                        'other' => $febOther,
                        'tot_other' => round($febOther / $febTerpenuhi *100,2),
                        'total_reject' => $febReject,
                        'p_total_reject' => round($febReject/$febTerpenuhi*100,2),
                        'total_check' => $febCheck,
                        'remark' => $value2->string1
                    ];
                }
            }
        }
        $TotalFeb2 = collect($dataFeb)
            ->groupBy('tgl_pengerjaan')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        $TotalFeb = collect($TotalFeb2)
            ->groupBy('id_line')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        // biar remark nya kebawa semua 
        $testFeb = [];
        $cobaFeb = collect($dataFeb)->where('remark', '!=', null)->groupBy('tgl_pengerjaan');
        foreach ($cobaFeb as $key => $value) {
        $testFeb[] = [
                'tgl_pengerjaan' => $key,
                'remark'=>  $value->implode('remark', ' | ')
            ];
        }
        $FebTerpenuhi = collect($TotalFeb)->sum('terpenuhi');
        $FebFG = collect($TotalFeb)->sum('fg');
        $FebBroken = collect($TotalFeb)->sum('broken');
        $FebSkip = collect($TotalFeb)->sum('skip');
        $FebPktw = collect($TotalFeb)->sum('pktw');
        $FebCrooked = collect($TotalFeb)->sum('crooked');
        $FebPleated = collect($TotalFeb)->sum('pleated');
        $FebRos = collect($TotalFeb)->sum('ros');
        $FebHtl = collect($TotalFeb)->sum('htl');
        $FebButton = collect($TotalFeb)->sum('button');
        $FebPrint = collect($TotalFeb)->sum('print');
        $FebBs = collect($TotalFeb)->sum('bs');
        $FebUnb = collect($TotalFeb)->sum('unb');
        $FebShading = collect($TotalFeb)->sum('shading');
        $FebDof = collect($TotalFeb)->sum('dof');
        $FebDirty = collect($TotalFeb)->sum('dirty');
        $FebShiny = collect($TotalFeb)->sum('shiny');
        $FebSticker = collect($TotalFeb)->sum('sticker');
        $FebTrimming = collect($TotalFeb)->sum('trimming');
        $FebIP = collect($TotalFeb)->sum('ip');
        $FebMeas = collect($TotalFeb)->sum('meas');
        $FebOther = collect($TotalFeb)->sum('other');
        $FebTotalCheck = collect($TotalFeb)->sum('total_check');
        $FebTotalReject = collect($TotalFeb)->sum('total_reject');

        if($FebTerpenuhi != 0 || $FebFG != 0 || $FebBroken != 0 || $FebSkip != 0 || $FebPktw != 0 || $FebCrooked != 0
        || $FebPleated != 0 || $FebRos != 0 || $FebHtl != 0 || $FebButton != 0 || $FebPrint != 0 || $FebBs != 0
        || $FebUnb != 0 || $FebShading != 0 || $FebDof != 0 || $FebDirty != 0 || $FebShiny != 0 || $FebSticker != 0
        || $FebTrimming != 0 || $FebIP != 0 || $FebMeas != 0 || $FebOther != 0){
            $tot_fg = round($FebFG / $FebTerpenuhi *100,2);
            $tot_broken = round($FebBroken / $FebTerpenuhi *100,2);
            $tot_skip = round($FebSkip / $FebTerpenuhi *100,2);
            $tot_pktw = round($FebPktw / $FebTerpenuhi *100,2);
            $tot_crooked = round($FebCrooked / $FebTerpenuhi *100,2);
            $tot_pleated = round($FebPleated / $FebTerpenuhi *100,2);
            $tot_ros = round($FebRos / $FebTerpenuhi *100,2);
            $tot_htl = round($FebHtl / $FebTerpenuhi *100,2);
            $tot_button = round($FebButton / $FebTerpenuhi *100,2);
            $tot_print = round($FebPrint / $FebTerpenuhi *100,2);
            $tot_bs = round($FebBs / $FebTerpenuhi *100,2);
            $tot_unb = round($FebUnb / $FebTerpenuhi *100,2);
            $tot_shading = round($FebShading / $FebTerpenuhi *100,2);
            $tot_dof = round($FebDof / $FebTerpenuhi *100,2);
            $tot_dirty = round($FebDirty / $FebTerpenuhi *100,2);
            $tot_shiny = round($FebShiny / $FebTerpenuhi *100,2);
            $tot_sticker = round($FebSticker / $FebTerpenuhi *100,2);
            $tot_trimming = round($FebTrimming / $FebTerpenuhi *100,2);
            $tot_ip = round($FebIP / $FebTerpenuhi *100,2);
            $tot_meas = round($FebMeas / $FebTerpenuhi *100,2);
            $tot_other = round($FebOther / $FebTerpenuhi *100,2);
            $p_total_reject = round($FebTotalReject / $FebTerpenuhi *100,2);
        }else{
            $tot_fg = 0;
            $tot_broken = 0;
            $tot_skip = 0;
            $tot_pktw = 0;
            $tot_crooked = 0;
            $tot_pleated = 0;
            $tot_ros = 0;
            $tot_htl = 0;
            $tot_button = 0;
            $tot_print = 0;
            $tot_bs = 0;
            $tot_unb = 0;
            $tot_shading = 0;
            $tot_dof = 0;
            $tot_dirty = 0;
            $tot_shiny = 0;
            $tot_sticker = 0;
            $tot_trimming = 0;
            $tot_ip = 0;
            $tot_meas = 0;
            $tot_other = 0;
            $p_total_reject = 0;
        }
        
        $FebAll[] = [
            'target_terpenuhi' => $FebTerpenuhi,
            'fg' => $FebFG,
            'tot_fg' => $tot_fg,
            'broken' => $FebBroken,
            'tot_broken' => $tot_broken,
            'skip' => $FebSkip,
            'tot_skip' => $tot_skip,
            'pktw' => $FebPktw,
            'tot_pktw' => $tot_pktw,
            'crooked' => $FebCrooked,
            'tot_crooked' => $tot_crooked,
            'pleated' => $FebPleated,
            'tot_pleated' => $tot_pleated,
            'ros' => $FebRos,
            'tot_ros' => $tot_ros,
            'htl' => $FebHtl,
            'tot_htl' => $tot_htl,
            'button' => $FebButton,
            'tot_button' => $tot_button,
            'print' => $FebPrint,
            'tot_print' => $tot_print,
            'bs' => $FebBs,
            'tot_bs' => $tot_bs,
            'unb' => $FebUnb,
            'tot_unb' => $tot_unb,
            'shading' => $FebShading,
            'tot_shading' => $tot_shading,
            'dof' => $FebDof,
            'tot_dof' => $tot_dof,
            'dirty' => $FebDirty,
            'tot_dirty' => $tot_dirty,
            'shiny' => $FebShiny,
            'tot_shiny' => $tot_shiny,
            'sticker' => $FebSticker,
            'tot_sticker' => $tot_sticker,
            'trimming' => $FebTrimming,
            'tot_trimming' => $tot_trimming,
            'ip' => $FebIP,
            'tot_ip' => $tot_ip,
            'meas' => $FebMeas,
            'tot_meas' => $tot_meas,
            'other' => $FebOther,
            'tot_other' => $tot_other,
            'total_reject' => $FebTotalReject,
            'p_total_reject' => $p_total_reject,
            'total_check' => $FebTotalCheck
        ];
        $totalFebruari = $FebAll[0];
        $FebRemark = collect($dataFeb)->where('remark', '!=', null)->implode('remark', ' | ');
        // end data bulan februari

        // data bulan maret
        $detailMar = LineDetail::where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get();
        $dataMar = [];
        foreach ($data as $key => $value) {
            foreach ($detailMar as $key2 => $value2) {
                if($value->id == $value2->id_line){
                    $marTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('target_terpenuhi');
                    $marCheck = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('total_check');
                    $marReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('total_reject');
                    $marFG = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('fg');
                    $marBroken = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('broken');
                    $marSkip = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('skip');
                    $marPktw = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('pktw');
                    $marCrooked = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('crooked');
                    $marPleated = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('pleated');
                    $marRos = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('ros');
                    $marHtl = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('htl');
                    $marButton = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('button');
                    $marPrint = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('print');
                    $marBs = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('bs');
                    $marUnb = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('unb');
                    $marShading = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('shading');
                    $marDof = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('dof');
                    $marDirty = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('dirty');
                    $marShiny = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('shiny');
                    $marSticker = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('sticker');
                    $marTrimming = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('trimming');
                    $marIP = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('ip');
                    $marMeas = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('meas');
                    $marOther = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('other');
                    $dataMar[] = [
                        'id_line' => $value2->id_line,
                        'tgl_pengerjaan' => $value2->tgl_pengerjaan,
                        'terpenuhi' =>$marTerpenuhi,
                        'fg' =>$marFG,
                        'tot_fg' => round($janFG /$marTerpenuhi *100,2),
                        'broken' =>$marBroken,
                        'tot_broken' => round($janBroken /$marTerpenuhi *100,2),
                        'skip' =>$marSkip,
                        'tot_skip' => round($janSkip /$marTerpenuhi *100,2),
                        'pktw' =>$marPktw,
                        'tot_pktw' => round($janPktw /$marTerpenuhi *100,2),
                        'crooked' =>$marCrooked,
                        'tot_crooked' => round($janCrooked /$marTerpenuhi *100,2),
                        'pleated' =>$marPleated,
                        'tot_pleated' => round($janPleated /$marTerpenuhi *100,2),
                        'ros' =>$marRos,
                        'tot_ros' => round($janRos /$marTerpenuhi *100,2),
                        'htl' =>$marHtl,
                        'tot_htl' => round($janHtl /$marTerpenuhi *100,2),
                        'button' =>$marButton,
                        'tot_button' => round($janButton /$marTerpenuhi *100,2),
                        'print' =>$marPrint,
                        'tot_print' => round($janPrint /$marTerpenuhi *100,2),
                        'bs' =>$marBs,
                        'tot_bs' => round($janBs /$marTerpenuhi *100,2),
                        'unb' =>$marUnb,
                        'tot_unb' => round($janUnb /$marTerpenuhi *100,2),
                        'shading' =>$marShading,
                        'tot_shading' => round($janShading /$marTerpenuhi *100,2),
                        'dof' =>$marDof,
                        'tot_dof' => round($janDof /$marTerpenuhi *100,2),
                        'dirty' =>$marDirty,
                        'tot_dirty' => round($janDirty /$marTerpenuhi *100,2),
                        'shiny' =>$marShiny,
                        'tot_shiny' => round($janShiny /$marTerpenuhi *100,2),
                        'sticker' =>$marSticker,
                        'tot_sticker' => round($janSticker /$marTerpenuhi *100,2),
                        'trimming' =>$marTrimming,
                        'tot_trimming' => round($janTrimming /$marTerpenuhi *100,2),
                        'ip' =>$marIP,
                        'tot_ip' => round($janIP /$marTerpenuhi *100,2),
                        'meas' =>$marMeas,
                        'tot_meas' => round($janMeas /$marTerpenuhi *100,2),
                        'other' =>$marOther,
                        'tot_other' => round($janOther /$marTerpenuhi *100,2),
                        'total_reject' => $marReject,
                        'p_total_reject' => round($marReject/$marTerpenuhi*100,2),
                        'total_check' => $marCheck,
                        'remark' => $value2->string1
                    ];
                }
            }
        }
        $TotalMar2 = collect($dataMar)
            ->groupBy('tgl_pengerjaan')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        $TotalMar = collect($TotalMar2)
            ->groupBy('id_line')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        // biar remark nya kebawa semua 
        $testMar = [];
        $cobaMar = collect($dataMar)->where('remark', '!=', null)->groupBy('tgl_pengerjaan');
        foreach ($cobaMar as $key => $value) {
        $testMar[] = [
                'tgl_pengerjaan' => $key,
                'remark'=>  $value->implode('remark', ' | ')
            ];
        }
        $MarTerpenuhi = collect($TotalMar)->sum('terpenuhi');
        $MarFG = collect($TotalMar)->sum('fg');
        $MarBroken = collect($TotalMar)->sum('broken');
        $MarSkip = collect($TotalMar)->sum('skip');
        $MarPktw = collect($TotalMar)->sum('pktw');
        $MarCrooked = collect($TotalMar)->sum('crooked');
        $MarPleated = collect($TotalMar)->sum('pleated');
        $MarRos = collect($TotalMar)->sum('ros');
        $MarHtl = collect($TotalMar)->sum('htl');
        $MarButton = collect($TotalMar)->sum('button');
        $MarPrint = collect($TotalMar)->sum('print');
        $MarBs = collect($TotalMar)->sum('bs');
        $MarUnb = collect($TotalMar)->sum('unb');
        $MarShading = collect($TotalMar)->sum('shading');
        $MarDof = collect($TotalMar)->sum('dof');
        $MarDirty = collect($TotalMar)->sum('dirty');
        $MarShiny = collect($TotalMar)->sum('shiny');
        $MarSticker = collect($TotalMar)->sum('sticker');
        $MarTrimming = collect($TotalMar)->sum('trimming');
        $MarIP = collect($TotalMar)->sum('ip');
        $MarMeas = collect($TotalMar)->sum('meas');
        $MarOther = collect($TotalMar)->sum('other');
        $MarTotalCheck = collect($TotalMar)->sum('total_check');
        $MarTotalReject = collect($TotalMar)->sum('total_reject');

        if($MarTerpenuhi != 0 || $MarFG != 0 || $MarBroken != 0 || $MarSkip != 0 || $MarPktw != 0 || $MarCrooked != 0
        || $MarPleated != 0 || $MarRos != 0 || $MarHtl != 0 || $MarButton != 0 || $MarPrint != 0 || $MarBs != 0
        || $MarUnb != 0 || $MarShading != 0 || $MarDof != 0 || $MarDirty != 0 || $MarShiny != 0 || $MarSticker != 0
        || $MarTrimming != 0 || $MarIP != 0 || $MarMeas != 0 || $MarOther != 0){
            $tot_fg = round($MarFG / $MarTerpenuhi *100,2);
            $tot_broken = round($MarBroken / $MarTerpenuhi *100,2);
            $tot_skip = round($MarSkip / $MarTerpenuhi *100,2);
            $tot_pktw = round($MarPktw / $MarTerpenuhi *100,2);
            $tot_crooked = round($MarCrooked / $MarTerpenuhi *100,2);
            $tot_pleated = round($MarPleated / $MarTerpenuhi *100,2);
            $tot_ros = round($MarRos / $MarTerpenuhi *100,2);
            $tot_htl = round($MarHtl / $MarTerpenuhi *100,2);
            $tot_button = round($MarButton / $MarTerpenuhi *100,2);
            $tot_print = round($MarPrint / $MarTerpenuhi *100,2);
            $tot_bs = round($MarBs / $MarTerpenuhi *100,2);
            $tot_unb = round($MarUnb / $MarTerpenuhi *100,2);
            $tot_shading = round($MarShading / $MarTerpenuhi *100,2);
            $tot_dof = round($MarDof / $MarTerpenuhi *100,2);
            $tot_dirty = round($MarDirty / $MarTerpenuhi *100,2);
            $tot_shiny = round($MarShiny / $MarTerpenuhi *100,2);
            $tot_sticker = round($MarSticker / $MarTerpenuhi *100,2);
            $tot_trimming = round($MarTrimming / $MarTerpenuhi *100,2);
            $tot_ip = round($MarIP / $MarTerpenuhi *100,2);
            $tot_meas = round($MarMeas / $MarTerpenuhi *100,2);
            $tot_other = round($MarOther / $MarTerpenuhi *100,2);
            $p_total_reject = round($MarTotalReject / $MarTerpenuhi *100,2);
        }else{
            $tot_fg = 0;
            $tot_broken = 0;
            $tot_skip = 0;
            $tot_pktw = 0;
            $tot_crooked = 0;
            $tot_pleated = 0;
            $tot_ros = 0;
            $tot_htl = 0;
            $tot_button = 0;
            $tot_print = 0;
            $tot_bs = 0;
            $tot_unb = 0;
            $tot_shading = 0;
            $tot_dof = 0;
            $tot_dirty = 0;
            $tot_shiny = 0;
            $tot_sticker = 0;
            $tot_trimming = 0;
            $tot_ip = 0;
            $tot_meas = 0;
            $tot_other = 0;
            $p_total_reject = 0;
        }
        
        $MarAll[] = [
            'target_terpenuhi' => $MarTerpenuhi,
            'fg' => $MarFG,
            'tot_fg' => $tot_fg,
            'broken' => $MarBroken,
            'tot_broken' => $tot_broken,
            'skip' => $MarSkip,
            'tot_skip' => $tot_skip,
            'pktw' => $MarPktw,
            'tot_pktw' => $tot_pktw,
            'crooked' => $MarCrooked,
            'tot_crooked' => $tot_crooked,
            'pleated' => $MarPleated,
            'tot_pleated' => $tot_pleated,
            'ros' => $MarRos,
            'tot_ros' => $tot_ros,
            'htl' => $MarHtl,
            'tot_htl' => $tot_htl,
            'button' => $MarButton,
            'tot_button' => $tot_button,
            'print' => $MarPrint,
            'tot_print' => $tot_print,
            'bs' => $MarBs,
            'tot_bs' => $tot_bs,
            'unb' => $MarUnb,
            'tot_unb' => $tot_unb,
            'shading' => $MarShading,
            'tot_shading' => $tot_shading,
            'dof' => $MarDof,
            'tot_dof' => $tot_dof,
            'dirty' => $MarDirty,
            'tot_dirty' => $tot_dirty,
            'shiny' => $MarShiny,
            'tot_shiny' => $tot_shiny,
            'sticker' => $MarSticker,
            'tot_sticker' => $tot_sticker,
            'trimming' => $MarTrimming,
            'tot_trimming' => $tot_trimming,
            'ip' => $MarIP,
            'tot_ip' => $tot_ip,
            'meas' => $MarMeas,
            'tot_meas' => $tot_meas,
            'other' => $MarOther,
            'tot_other' => $tot_other,
            'total_reject' => $MarTotalReject,
            'p_total_reject' => $p_total_reject,
            'total_check' => $MarTotalCheck
        ];
        $totalMaret = $MarAll[0];
        $MarRemark = collect($dataMar)->where('remark', '!=', null)->implode('remark', ' | ');
        // end data bulan maret 

        // data bulan april 
        $detailApr = LineDetail::where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get();
        $dataApr = [];
        foreach ($data as $key => $value) {
            foreach ($detailApr as $key2 => $value2) {
                if($value->id == $value2->id_line){
                    $aprTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('target_terpenuhi');
                    $aprCheck = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('total_check');
                    $aprReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('total_reject');
                    $aprFG = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('fg');
                    $aprBroken = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('broken');
                    $aprSkip = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('skip');
                    $aprPktw = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('pktw');
                    $aprCrooked = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('crooked');
                    $aprPleated = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('pleated');
                    $aprRos = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('ros');
                    $aprHtl = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('htl');
                    $aprButton = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('button');
                    $aprPrint = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('print');
                    $aprBs = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('bs');
                    $aprUnb = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('unb');
                    $aprShading = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('shading');
                    $aprDof = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('dof');
                    $aprDirty = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('dirty');
                    $aprShiny = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('shiny');
                    $aprSticker = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('sticker');
                    $aprTrimming = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('trimming');
                    $aprIP = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('ip');
                    $aprMeas = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('meas');
                    $aprOther = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('other');
                    $dataApr[] = [
                        'id_line' => $value2->id_line,
                        'tgl_pengerjaan' => $value2->tgl_pengerjaan,
                        'terpenuhi' => $aprTerpenuhi,
                        'fg' => $aprFG,
                        'tot_fg' => round($aprFG / $aprTerpenuhi *100,2),
                        'broken' => $aprBroken,
                        'tot_broken' => round($aprBroken / $aprTerpenuhi *100,2),
                        'skip' => $aprSkip,
                        'tot_skip' => round($aprSkip / $aprTerpenuhi *100,2),
                        'pktw' => $aprPktw,
                        'tot_pktw' => round($aprPktw / $aprTerpenuhi *100,2),
                        'crooked' => $aprCrooked,
                        'tot_crooked' => round($aprCrooked / $aprTerpenuhi *100,2),
                        'pleated' => $aprPleated,
                        'tot_pleated' => round($aprPleated / $aprTerpenuhi *100,2),
                        'ros' => $aprRos,
                        'tot_ros' => round($aprRos / $aprTerpenuhi *100,2),
                        'htl' => $aprHtl,
                        'tot_htl' => round($aprHtl / $aprTerpenuhi *100,2),
                        'button' => $aprButton,
                        'tot_button' => round($aprButton / $aprTerpenuhi *100,2),
                        'print' => $aprPrint,
                        'tot_print' => round($aprPrint / $aprTerpenuhi *100,2),
                        'bs' => $aprBs,
                        'tot_bs' => round($aprBs / $aprTerpenuhi *100,2),
                        'unb' => $aprUnb,
                        'tot_unb' => round($aprUnb / $aprTerpenuhi *100,2),
                        'shading' => $aprShading,
                        'tot_shading' => round($aprShading / $aprTerpenuhi *100,2),
                        'dof' => $aprDof,
                        'tot_dof' => round($aprDof / $aprTerpenuhi *100,2),
                        'dirty' => $aprDirty,
                        'tot_dirty' => round($aprDirty / $aprTerpenuhi *100,2),
                        'shiny' => $aprShiny,
                        'tot_shiny' => round($aprShiny / $aprTerpenuhi *100,2),
                        'sticker' => $aprSticker,
                        'tot_sticker' => round($aprSticker / $aprTerpenuhi *100,2),
                        'trimming' => $aprTrimming,
                        'tot_trimming' => round($aprTrimming / $aprTerpenuhi *100,2),
                        'ip' => $aprIP,
                        'tot_ip' => round($aprIP / $aprTerpenuhi *100,2),
                        'meas' => $aprMeas,
                        'tot_meas' => round($aprMeas / $aprTerpenuhi *100,2),
                        'other' => $aprOther,
                        'tot_other' => round($aprOther / $aprTerpenuhi *100,2),
                        'total_reject' => $aprReject,
                        'p_total_reject' => round($aprReject/$aprTerpenuhi*100,2),
                        'total_check' => $aprCheck,
                        'remark' => $value2->string1
                    ];
                }
            }
        }
        $TotalApr2 = collect($dataApr)
            ->groupBy('tgl_pengerjaan')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        $TotalApr = collect($TotalApr2)
            ->groupBy('id_line')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        // biar remark nya kebawa semua 
        $testApr = [];
        $cobaApr = collect($dataApr)->where('remark', '!=', null)->groupBy('tgl_pengerjaan');
        foreach ($cobaApr as $key => $value) {
        $testApr[] = [
                'tgl_pengerjaan' => $key,
                'remark'=>  $value->implode('remark', ' | ')
            ];
        }
        $AprTerpenuhi = collect($TotalApr)->sum('terpenuhi');
        $AprFG = collect($TotalApr)->sum('fg');
        $AprBroken = collect($TotalApr)->sum('broken');
        $AprSkip = collect($TotalApr)->sum('skip');
        $AprPktw = collect($TotalApr)->sum('pktw');
        $AprCrooked = collect($TotalApr)->sum('crooked');
        $AprPleated = collect($TotalApr)->sum('pleated');
        $AprRos = collect($TotalApr)->sum('ros');
        $AprHtl = collect($TotalApr)->sum('htl');
        $AprButton = collect($TotalApr)->sum('button');
        $AprPrint = collect($TotalApr)->sum('print');
        $AprBs = collect($TotalApr)->sum('bs');
        $AprUnb = collect($TotalApr)->sum('unb');
        $AprShading = collect($TotalApr)->sum('shading');
        $AprDof = collect($TotalApr)->sum('dof');
        $AprDirty = collect($TotalApr)->sum('dirty');
        $AprShiny = collect($TotalApr)->sum('shiny');
        $AprSticker = collect($TotalApr)->sum('sticker');
        $AprTrimming = collect($TotalApr)->sum('trimming');
        $AprIP = collect($TotalApr)->sum('ip');
        $AprMeas = collect($TotalApr)->sum('meas');
        $AprOther = collect($TotalApr)->sum('other');
        $AprTotalCheck = collect($TotalApr)->sum('total_check');
        $AprTotalReject = collect($TotalApr)->sum('total_reject');

        if($AprTerpenuhi != 0 || $AprFG != 0 || $AprBroken != 0 || $AprSkip != 0 || $AprPktw != 0 || $AprCrooked != 0
        || $AprPleated != 0 || $AprRos != 0 || $AprHtl != 0 || $AprButton != 0 || $AprPrint != 0 || $AprBs != 0
        || $AprUnb != 0 || $AprShading != 0 || $AprDof != 0 || $AprDirty != 0 || $AprShiny != 0 || $AprSticker != 0
        || $AprTrimming != 0 || $AprIP != 0 || $AprMeas != 0 || $AprOther != 0){
            $tot_fg = round($AprFG / $AprTerpenuhi *100,2);
            $tot_broken = round($AprBroken / $AprTerpenuhi *100,2);
            $tot_skip = round($AprSkip / $AprTerpenuhi *100,2);
            $tot_pktw = round($AprPktw / $AprTerpenuhi *100,2);
            $tot_crooked = round($AprCrooked / $AprTerpenuhi *100,2);
            $tot_pleated = round($AprPleated / $AprTerpenuhi *100,2);
            $tot_ros = round($AprRos / $AprTerpenuhi *100,2);
            $tot_htl = round($AprHtl / $AprTerpenuhi *100,2);
            $tot_button = round($AprButton / $AprTerpenuhi *100,2);
            $tot_print = round($AprPrint / $AprTerpenuhi *100,2);
            $tot_bs = round($AprBs / $AprTerpenuhi *100,2);
            $tot_unb = round($AprUnb / $AprTerpenuhi *100,2);
            $tot_shading = round($AprShading / $AprTerpenuhi *100,2);
            $tot_dof = round($AprDof / $AprTerpenuhi *100,2);
            $tot_dirty = round($AprDirty / $AprTerpenuhi *100,2);
            $tot_shiny = round($AprShiny / $AprTerpenuhi *100,2);
            $tot_sticker = round($AprSticker / $AprTerpenuhi *100,2);
            $tot_trimming = round($AprTrimming / $AprTerpenuhi *100,2);
            $tot_ip = round($AprIP / $AprTerpenuhi *100,2);
            $tot_meas = round($AprMeas / $AprTerpenuhi *100,2);
            $tot_other = round($AprOther / $AprTerpenuhi *100,2);
            $p_total_reject = round($AprTotalReject / $AprTerpenuhi *100,2);
        }else{
            $tot_fg = 0;
            $tot_broken = 0;
            $tot_skip = 0;
            $tot_pktw = 0;
            $tot_crooked = 0;
            $tot_pleated = 0;
            $tot_ros = 0;
            $tot_htl = 0;
            $tot_button = 0;
            $tot_print = 0;
            $tot_bs = 0;
            $tot_unb = 0;
            $tot_shading = 0;
            $tot_dof = 0;
            $tot_dirty = 0;
            $tot_shiny = 0;
            $tot_sticker = 0;
            $tot_trimming = 0;
            $tot_ip = 0;
            $tot_meas = 0;
            $tot_other = 0;
            $p_total_reject =0;
        }
        
        $AprAll[] = [
            'target_terpenuhi' => $AprTerpenuhi,
            'fg' => $AprFG,
            'tot_fg' => $tot_fg,
            'broken' => $AprBroken,
            'tot_broken' => $tot_broken,
            'skip' => $AprSkip,
            'tot_skip' => $tot_skip,
            'pktw' => $AprPktw,
            'tot_pktw' => $tot_pktw,
            'crooked' => $AprCrooked,
            'tot_crooked' => $tot_crooked,
            'pleated' => $AprPleated,
            'tot_pleated' => $tot_pleated,
            'ros' => $AprRos,
            'tot_ros' => $tot_ros,
            'htl' => $AprHtl,
            'tot_htl' => $tot_htl,
            'button' => $AprButton,
            'tot_button' => $tot_button,
            'print' => $AprPrint,
            'tot_print' => $tot_print,
            'bs' => $AprBs,
            'tot_bs' => $tot_bs,
            'unb' => $AprUnb,
            'tot_unb' => $tot_unb,
            'shading' => $AprShading,
            'tot_shading' => $tot_shading,
            'dof' => $AprDof,
            'tot_dof' => $tot_dof,
            'dirty' => $AprDirty,
            'tot_dirty' => $tot_dirty,
            'shiny' => $AprShiny,
            'tot_shiny' => $tot_shiny,
            'sticker' => $AprSticker,
            'tot_sticker' => $tot_sticker,
            'trimming' => $AprTrimming,
            'tot_trimming' => $tot_trimming,
            'ip' => $AprIP,
            'tot_ip' => $tot_ip,
            'meas' => $AprMeas,
            'tot_meas' => $tot_meas,
            'other' => $AprOther,
            'tot_other' => $tot_other,
            'total_reject' => $AprTotalReject,
            'p_total_reject' => $p_total_reject,
            'total_check' => $AprTotalCheck
        ];
        $totalApril = $AprAll[0];
        $AprRemark = collect($dataApr)->where('remark', '!=', null)->implode('remark', ' | ');
        // end data bulan april 

        // data bulan mei 
        $detailMei = LineDetail::where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get();
        $dataMei = [];
        foreach ($data as $key => $value) {
            foreach ($detailMei as $key2 => $value2) {
                if($value->id == $value2->id_line){
                    $meiTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('target_terpenuhi');
                    $meiCheck = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('total_check');
                    $meiReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('total_reject');
                    $meiFG = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('fg');
                    $meiBroken = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('broken');
                    $meiSkip = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('skip');
                    $meiPktw = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('pktw');
                    $meiCrooked = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('crooked');
                    $meiPleated = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('pleated');
                    $meiRos = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('ros');
                    $meiHtl = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('htl');
                    $meiButton = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('button');
                    $meiPrint = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('print');
                    $meiBs = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('bs');
                    $meiUnb = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('unb');
                    $meiShading = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('shading');
                    $meiDof = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('dof');
                    $meiDirty = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('dirty');
                    $meiShiny = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('shiny');
                    $meiSticker = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('sticker');
                    $meiTrimming = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('trimming');
                    $meiIP = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('ip');
                    $meiMeas = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('meas');
                    $meiOther = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('other');
                    $dataMei[] = [
                        'tgl_pengerjaan' => $value2->tgl_pengerjaan,
                        'terpenuhi' =>$meiTerpenuhi,
                        'fg' =>$meiFG,
                        'tot_fg' => round($janFG /$meiTerpenuhi *100,2),
                        'broken' =>$meiBroken,
                        'tot_broken' => round($janBroken /$meiTerpenuhi *100,2),
                        'skip' =>$meiSkip,
                        'tot_skip' => round($janSkip /$meiTerpenuhi *100,2),
                        'pktw' =>$meiPktw,
                        'tot_pktw' => round($janPktw /$meiTerpenuhi *100,2),
                        'crooked' =>$meiCrooked,
                        'tot_crooked' => round($janCrooked /$meiTerpenuhi *100,2),
                        'pleated' =>$meiPleated,
                        'tot_pleated' => round($janPleated /$meiTerpenuhi *100,2),
                        'ros' =>$meiRos,
                        'tot_ros' => round($janRos /$meiTerpenuhi *100,2),
                        'htl' =>$meiHtl,
                        'tot_htl' => round($janHtl /$meiTerpenuhi *100,2),
                        'button' =>$meiButton,
                        'tot_button' => round($janButton /$meiTerpenuhi *100,2),
                        'print' =>$meiPrint,
                        'tot_print' => round($janPrint /$meiTerpenuhi *100,2),
                        'bs' =>$meiBs,
                        'tot_bs' => round($janBs /$meiTerpenuhi *100,2),
                        'unb' =>$meiUnb,
                        'tot_unb' => round($janUnb /$meiTerpenuhi *100,2),
                        'shading' =>$meiShading,
                        'tot_shading' => round($janShading /$meiTerpenuhi *100,2),
                        'dof' =>$meiDof,
                        'tot_dof' => round($janDof /$meiTerpenuhi *100,2),
                        'dirty' =>$meiDirty,
                        'tot_dirty' => round($janDirty /$meiTerpenuhi *100,2),
                        'shiny' =>$meiShiny,
                        'tot_shiny' => round($janShiny /$meiTerpenuhi *100,2),
                        'sticker' =>$meiSticker,
                        'tot_sticker' => round($janSticker /$meiTerpenuhi *100,2),
                        'trimming' =>$meiTrimming,
                        'tot_trimming' => round($janTrimming /$meiTerpenuhi *100,2),
                        'ip' =>$meiIP,
                        'tot_ip' => round($janIP /$meiTerpenuhi *100,2),
                        'meas' =>$meiMeas,
                        'tot_meas' => round($janMeas /$meiTerpenuhi *100,2),
                        'other' =>$meiOther,
                        'tot_other' => round($janOther /$meiTerpenuhi *100,2),
                        'total_reject' => $meiReject, 
                        'p_total_reject' => round($meiReject/$meiTerpenuhi*100,2),
                        'total_check' =>$meiCheck,
                        'remark' => $value2->string1,
                        'id_line' => $value2->id_line
                    ];
                }
            }
        }
        $TotalMei2 = collect($dataMei)
            ->groupBy('tgl_pengerjaan')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        $TotalMei = collect($TotalMei2)
            ->groupBy('id_line')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        // biar remark nya kebawa semua 
        $testMei = [];
        $cobaMei = collect($dataMei)->where('remark', '!=', null)->groupBy('tgl_pengerjaan');
        foreach ($cobaMei as $key => $value) {
        $testMei[] = [
                'tgl_pengerjaan' => $key,
                'remark'=>  $value->implode('remark', ' | ')
            ];
        }
        $MeiTerpenuhi = collect($TotalMei)->sum('terpenuhi');
        $MeiFG = collect($TotalMei)->sum('fg');
        $MeiBroken = collect($TotalMei)->sum('broken');
        $MeiSkip = collect($TotalMei)->sum('skip');
        $MeiPktw = collect($TotalMei)->sum('pktw');
        $MeiCrooked = collect($TotalMei)->sum('crooked');
        $MeiPleated = collect($TotalMei)->sum('pleated');
        $MeiRos = collect($TotalMei)->sum('ros');
        $MeiHtl = collect($TotalMei)->sum('htl');
        $MeiButton = collect($TotalMei)->sum('button');
        $MeiPrint = collect($TotalMei)->sum('print');
        $MeiBs = collect($TotalMei)->sum('bs');
        $MeiUnb = collect($TotalMei)->sum('unb');
        $MeiShading = collect($TotalMei)->sum('shading');
        $MeiDof = collect($TotalMei)->sum('dof');
        $MeiDirty = collect($TotalMei)->sum('dirty');
        $MeiShiny = collect($TotalMei)->sum('shiny');
        $MeiSticker = collect($TotalMei)->sum('sticker');
        $MeiTrimming = collect($TotalMei)->sum('trimming');
        $MeiIP = collect($TotalMei)->sum('ip');
        $MeiMeas = collect($TotalMei)->sum('meas');
        $MeiOther = collect($TotalMei)->sum('other');
        $MeiTotalCheck = collect($TotalMei)->sum('total_check');
        $MeiTotalReject = collect($TotalMei)->sum('total_reject');

        if($MeiTerpenuhi != 0 || $MeiFG != 0 || $MeiBroken != 0 || $MeiSkip != 0 || $MeiPktw != 0 || $MeiCrooked != 0
        || $MeiPleated != 0 || $MeiRos != 0 || $MeiHtl != 0 || $MeiButton != 0 || $MeiPrint != 0 || $MeiBs != 0
        || $MeiUnb != 0 || $MeiShading != 0 || $MeiDof != 0 || $MeiDirty != 0 || $MeiShiny != 0 || $MeiSticker != 0
        || $MeiTrimming != 0 || $MeiIP != 0 || $MeiMeas != 0 || $MeiOther != 0){
            $tot_fg = round($MeiFG / $MeiTerpenuhi *100,2);
            $tot_broken = round($MeiBroken / $MeiTerpenuhi *100,2);
            $tot_skip = round($MeiSkip / $MeiTerpenuhi *100,2);
            $tot_pktw = round($MeiPktw / $MeiTerpenuhi *100,2);
            $tot_crooked = round($MeiCrooked / $MeiTerpenuhi *100,2);
            $tot_pleated = round($MeiPleated / $MeiTerpenuhi *100,2);
            $tot_ros = round($MeiRos / $MeiTerpenuhi *100,2);
            $tot_htl = round($MeiHtl / $MeiTerpenuhi *100,2);
            $tot_button = round($MeiButton / $MeiTerpenuhi *100,2);
            $tot_print = round($MeiPrint / $MeiTerpenuhi *100,2);
            $tot_bs = round($MeiBs / $MeiTerpenuhi *100,2);
            $tot_unb = round($MeiUnb / $MeiTerpenuhi *100,2);
            $tot_shading = round($MeiShading / $MeiTerpenuhi *100,2);
            $tot_dof = round($MeiDof / $MeiTerpenuhi *100,2);
            $tot_dirty = round($MeiDirty / $MeiTerpenuhi *100,2);
            $tot_shiny = round($MeiShiny / $MeiTerpenuhi *100,2);
            $tot_sticker = round($MeiSticker / $MeiTerpenuhi *100,2);
            $tot_trimming = round($MeiTrimming / $MeiTerpenuhi *100,2);
            $tot_ip = round($MeiIP / $MeiTerpenuhi *100,2);
            $tot_meas = round($MeiMeas / $MeiTerpenuhi *100,2);
            $tot_other = round($MeiOther / $MeiTerpenuhi *100,2);
            $p_total_reject = round($MeiTotalReject / $MeiTerpenuhi *100,2);
        }else{
            $tot_fg = 0;
            $tot_broken = 0;
            $tot_skip = 0;
            $tot_pktw = 0;
            $tot_crooked = 0;
            $tot_pleated = 0;
            $tot_ros = 0;
            $tot_htl = 0;
            $tot_button = 0;
            $tot_print = 0;
            $tot_bs = 0;
            $tot_unb = 0;
            $tot_shading = 0;
            $tot_dof = 0;
            $tot_dirty = 0;
            $tot_shiny = 0;
            $tot_sticker = 0;
            $tot_trimming = 0;
            $tot_ip = 0;
            $tot_meas = 0;
            $tot_other = 0;
            $p_total_reject = 0;
        }
        
        $MeiAll[] = [
            'target_terpenuhi' => $MeiTerpenuhi,
            'fg' => $MeiFG,
            'tot_fg' => $tot_fg,
            'broken' => $MeiBroken,
            'tot_broken' => $tot_broken,
            'skip' => $MeiSkip,
            'tot_skip' => $tot_skip,
            'pktw' => $MeiPktw,
            'tot_pktw' => $tot_pktw,
            'crooked' => $MeiCrooked,
            'tot_crooked' => $tot_crooked,
            'pleated' => $MeiPleated,
            'tot_pleated' => $tot_pleated,
            'ros' => $MeiRos,
            'tot_ros' => $tot_ros,
            'htl' => $MeiHtl,
            'tot_htl' => $tot_htl,
            'button' => $MeiButton,
            'tot_button' => $tot_button,
            'print' => $MeiPrint,
            'tot_print' => $tot_print,
            'bs' => $MeiBs,
            'tot_bs' => $tot_bs,
            'unb' => $MeiUnb,
            'tot_unb' => $tot_unb,
            'shading' => $MeiShading,
            'tot_shading' => $tot_shading,
            'dof' => $MeiDof,
            'tot_dof' => $tot_dof,
            'dirty' => $MeiDirty,
            'tot_dirty' => $tot_dirty,
            'shiny' => $MeiShiny,
            'tot_shiny' => $tot_shiny,
            'sticker' => $MeiSticker,
            'tot_sticker' => $tot_sticker,
            'trimming' => $MeiTrimming,
            'tot_trimming' => $tot_trimming,
            'ip' => $MeiIP,
            'tot_ip' => $tot_ip,
            'meas' => $MeiMeas,
            'tot_meas' => $tot_meas,
            'other' => $MeiOther,
            'tot_other' => $tot_other,
            'total_reject' => $MeiTotalReject,
            'p_total_reject' => $p_total_reject,
            'total_check' => $MeiTotalCheck
        ];
        $totalMei = $MeiAll[0];
        $MeiRemark = collect($dataMei)->where('remark', '!=', null)->implode('remark', ' | ');
        // end data bulan mei 

        // data bulan juni 
        $detailJun = LineDetail::where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get();
        $dataJun = [];
        foreach ($data as $key => $value) {
            foreach ($detailJun as $key2 => $value2) {
                if($value->id == $value2->id_line){
                    $junTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('target_terpenuhi');
                    $junCheck = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('total_check');
                    $junReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('total_reject');
                    $junFG = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('fg');
                    $junBroken = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('broken');
                    $junSkip = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('skip');
                    $junPktw = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('pktw');
                    $junCrooked = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('crooked');
                    $junPleated = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('pleated');
                    $junRos = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('ros');
                    $junHtl = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('htl');
                    $junButton = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('button');
                    $junPrint = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('print');
                    $junBs = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('bs');
                    $junUnb = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('unb');
                    $junShading = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('shading');
                    $junDof = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('dof');
                    $junDirty = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('dirty');
                    $junShiny = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('shiny');
                    $junSticker = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('sticker');
                    $junTrimming = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('trimming');
                    $junIP = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('ip');
                    $junMeas = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('meas');
                    $junOther = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('other');
                    $dataJun[] = [
                        'tgl_pengerjaan' => $value2->tgl_pengerjaan,
                        'terpenuhi' => $junTerpenuhi,
                        'fg' => $junFG,
                        'tot_fg' => round($junFG / $junTerpenuhi *100,2),
                        'broken' => $junBroken,
                        'tot_broken' => round($junBroken / $junTerpenuhi *100,2),
                        'skip' => $junSkip,
                        'tot_skip' => round($junSkip / $junTerpenuhi *100,2),
                        'pktw' => $junPktw,
                        'tot_pktw' => round($junPktw / $junTerpenuhi *100,2),
                        'crooked' => $junCrooked,
                        'tot_crooked' => round($junCrooked / $junTerpenuhi *100,2),
                        'pleated' => $junPleated,
                        'tot_pleated' => round($junPleated / $junTerpenuhi *100,2),
                        'ros' => $junRos,
                        'tot_ros' => round($junRos / $junTerpenuhi *100,2),
                        'htl' => $junHtl,
                        'tot_htl' => round($junHtl / $junTerpenuhi *100,2),
                        'button' => $junButton,
                        'tot_button' => round($junButton / $junTerpenuhi *100,2),
                        'print' => $junPrint,
                        'tot_print' => round($junPrint / $junTerpenuhi *100,2),
                        'bs' => $junBs,
                        'tot_bs' => round($junBs / $junTerpenuhi *100,2),
                        'unb' => $junUnb,
                        'tot_unb' => round($junUnb / $junTerpenuhi *100,2),
                        'shading' => $junShading,
                        'tot_shading' => round($junShading / $junTerpenuhi *100,2),
                        'dof' => $junDof,
                        'tot_dof' => round($junDof / $junTerpenuhi *100,2),
                        'dirty' => $junDirty,
                        'tot_dirty' => round($junDirty / $junTerpenuhi *100,2),
                        'shiny' => $junShiny,
                        'tot_shiny' => round($junShiny / $junTerpenuhi *100,2),
                        'sticker' => $junSticker,
                        'tot_sticker' => round($junSticker / $junTerpenuhi *100,2),
                        'trimming' => $junTrimming,
                        'tot_trimming' => round($junTrimming / $junTerpenuhi *100,2),
                        'ip' => $junIP,
                        'tot_ip' => round($junIP / $junTerpenuhi *100,2),
                        'meas' => $junMeas,
                        'tot_meas' => round($junMeas / $junTerpenuhi *100,2),
                        'other' => $junOther,
                        'tot_other' => round($junOther / $junTerpenuhi *100,2),
                        'total_reject' => $junReject,
                        'p_total_reject' => round($junReject/$junTerpenuhi*100,2),
                        'total_check' => $junCheck,
                        'remark' => $value2->string1,
                        'id_line' => $value2->id_line
                    ];
                }
            }
        }
        $TotalJun2 = collect($dataJun)
            ->groupBy('tgl_pengerjaan')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        $TotalJun = collect($TotalJun2)
            ->groupBy('id_line')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        // biar remark nya kebawa semua 
        $testJun = [];
        $cobaJun = collect($dataJun)->where('remark', '!=', null)->groupBy('tgl_pengerjaan');
        foreach ($cobaJun as $key => $value) {
        $testJun[] = [
                'tgl_pengerjaan' => $key,
                'remark'=>  $value->implode('remark', ' | ')
            ];
        }
        $JunTerpenuhi = collect($TotalJun)->sum('terpenuhi');
        $JunFG = collect($TotalJun)->sum('fg');
        $JunBroken = collect($TotalJun)->sum('broken');
        $JunSkip = collect($TotalJun)->sum('skip');
        $JunPktw = collect($TotalJun)->sum('pktw');
        $JunCrooked = collect($TotalJun)->sum('crooked');
        $JunPleated = collect($TotalJun)->sum('pleated');
        $JunRos = collect($TotalJun)->sum('ros');
        $JunHtl = collect($TotalJun)->sum('htl');
        $JunButton = collect($TotalJun)->sum('button');
        $JunPrint = collect($TotalJun)->sum('print');
        $JunBs = collect($TotalJun)->sum('bs');
        $JunUnb = collect($TotalJun)->sum('unb');
        $JunShading = collect($TotalJun)->sum('shading');
        $JunDof = collect($TotalJun)->sum('dof');
        $JunDirty = collect($TotalJun)->sum('dirty');
        $JunShiny = collect($TotalJun)->sum('shiny');
        $JunSticker = collect($TotalJun)->sum('sticker');
        $JunTrimming = collect($TotalJun)->sum('trimming');
        $JunIP = collect($TotalJun)->sum('ip');
        $JunMeas = collect($TotalJun)->sum('meas');
        $JunOther = collect($TotalJun)->sum('other');
        $JunTotalCheck = collect($TotalJun)->sum('total_check');
        $JunTotalReject = collect($TotalJun)->sum('total_reject');

        if($JunTerpenuhi != 0 || $JunFG != 0 || $JunBroken != 0 || $JunSkip != 0 || $JunPktw != 0 || $JunCrooked != 0
        || $JunPleated != 0 || $JunRos != 0 || $JunHtl != 0 || $JunButton != 0 || $JunPrint != 0 || $JunBs != 0
        || $JunUnb != 0 || $JunShading != 0 || $JunDof != 0 || $JunDirty != 0 || $JunShiny != 0 || $JunSticker != 0
        || $JunTrimming != 0 || $JunIP != 0 || $JunMeas != 0 || $JunOther != 0){
            $tot_fg = round($JunFG / $JunTerpenuhi *100,2);
            $tot_broken = round($JunBroken / $JunTerpenuhi *100,2);
            $tot_skip = round($JunSkip / $JunTerpenuhi *100,2);
            $tot_pktw = round($JunPktw / $JunTerpenuhi *100,2);
            $tot_crooked = round($JunCrooked / $JunTerpenuhi *100,2);
            $tot_pleated = round($JunPleated / $JunTerpenuhi *100,2);
            $tot_ros = round($JunRos / $JunTerpenuhi *100,2);
            $tot_htl = round($JunHtl / $JunTerpenuhi *100,2);
            $tot_button = round($JunButton / $JunTerpenuhi *100,2);
            $tot_print = round($JunPrint / $JunTerpenuhi *100,2);
            $tot_bs = round($JunBs / $JunTerpenuhi *100,2);
            $tot_unb = round($JunUnb / $JunTerpenuhi *100,2);
            $tot_shading = round($JunShading / $JunTerpenuhi *100,2);
            $tot_dof = round($JunDof / $JunTerpenuhi *100,2);
            $tot_dirty = round($JunDirty / $JunTerpenuhi *100,2);
            $tot_shiny = round($JunShiny / $JunTerpenuhi *100,2);
            $tot_sticker = round($JunSticker / $JunTerpenuhi *100,2);
            $tot_trimming = round($JunTrimming / $JunTerpenuhi *100,2);
            $tot_ip = round($JunIP / $JunTerpenuhi *100,2);
            $tot_meas = round($JunMeas / $JunTerpenuhi *100,2);
            $tot_other = round($JunOther / $JunTerpenuhi *100,2);
            $p_total_reject = round($JunTotalReject / $JunTerpenuhi *100,2);
        }else{
            $tot_fg = 0;
            $tot_broken = 0;
            $tot_skip = 0;
            $tot_pktw = 0;
            $tot_crooked = 0;
            $tot_pleated = 0;
            $tot_ros = 0;
            $tot_htl = 0;
            $tot_button = 0;
            $tot_print = 0;
            $tot_bs = 0;
            $tot_unb = 0;
            $tot_shading = 0;
            $tot_dof = 0;
            $tot_dirty = 0;
            $tot_shiny = 0;
            $tot_sticker = 0;
            $tot_trimming = 0;
            $tot_ip = 0;
            $tot_meas = 0;
            $tot_other = 0;
            $$p_total_reject = 0;
        }
        
        $JunAll[] = [
            'target_terpenuhi' => $JunTerpenuhi,
            'fg' => $JunFG,
            'tot_fg' => $tot_fg,
            'broken' => $JunBroken,
            'tot_broken' => $tot_broken,
            'skip' => $JunSkip,
            'tot_skip' => $tot_skip,
            'pktw' => $JunPktw,
            'tot_pktw' => $tot_pktw,
            'crooked' => $JunCrooked,
            'tot_crooked' => $tot_crooked,
            'pleated' => $JunPleated,
            'tot_pleated' => $tot_pleated,
            'ros' => $JunRos,
            'tot_ros' => $tot_ros,
            'htl' => $JunHtl,
            'tot_htl' => $tot_htl,
            'button' => $JunButton,
            'tot_button' => $tot_button,
            'print' => $JunPrint,
            'tot_print' => $tot_print,
            'bs' => $JunBs,
            'tot_bs' => $tot_bs,
            'unb' => $JunUnb,
            'tot_unb' => $tot_unb,
            'shading' => $JunShading,
            'tot_shading' => $tot_shading,
            'dof' => $JunDof,
            'tot_dof' => $tot_dof,
            'dirty' => $JunDirty,
            'tot_dirty' => $tot_dirty,
            'shiny' => $JunShiny,
            'tot_shiny' => $tot_shiny,
            'sticker' => $JunSticker,
            'tot_sticker' => $tot_sticker,
            'trimming' => $JunTrimming,
            'tot_trimming' => $tot_trimming,
            'ip' => $JunIP,
            'tot_ip' => $tot_ip,
            'meas' => $JunMeas,
            'tot_meas' => $tot_meas,
            'other' => $JunOther,
            'tot_other' => $tot_other,
            'total_reject' => $JunTotalReject,
            'p_total_reject' => $p_total_reject,
            'total_check' => $JunTotalCheck
        ];
        $totalJuni = $JunAll[0];
        $JunRemark = collect($dataJun)->where('remark', '!=', null)->implode('remark', ' | ');
        // end data bulan juni 

        // data bulan juli 
        $detailJul = LineDetail::where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get();
        $dataJul = [];
        foreach ($data as $key => $value) {
            foreach ($detailJul as $key2 => $value2) {
                if($value->id == $value2->id_line){
                    $julTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('target_terpenuhi');
                    $julCheck = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('total_check');
                    $julReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('total_reject');
                    $julFG = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('fg');
                    $julBroken = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('broken');
                    $julSkip = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('skip');
                    $julPktw = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('pktw');
                    $julCrooked = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('crooked');
                    $julPleated = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('pleated');
                    $julRos = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('ros');
                    $julHtl = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('htl');
                    $julButton = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('button');
                    $julPrint = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('print');
                    $julBs = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('bs');
                    $julUnb = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('unb');
                    $julShading = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('shading');
                    $julDof = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('dof');
                    $julDirty = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('dirty');
                    $julShiny = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('shiny');
                    $julSticker = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('sticker');
                    $julTrimming = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('trimming');
                    $julIP = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('ip');
                    $julMeas = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('meas');
                    $julOther = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('other');
                    $dataJul[] = [
                        'tgl_pengerjaan' => $value2->tgl_pengerjaan,
                        'terpenuhi' => $julTerpenuhi,
                        'fg' => $julFG,
                        'tot_fg' => round($julFG / $julTerpenuhi *100,2),
                        'broken' => $julBroken,
                        'tot_broken' => round($julBroken / $julTerpenuhi *100,2),
                        'skip' => $julSkip,
                        'tot_skip' => round($julSkip / $julTerpenuhi *100,2),
                        'pktw' => $julPktw,
                        'tot_pktw' => round($julPktw / $julTerpenuhi *100,2),
                        'crooked' => $julCrooked,
                        'tot_crooked' => round($julCrooked / $julTerpenuhi *100,2),
                        'pleated' => $julPleated,
                        'tot_pleated' => round($julPleated / $julTerpenuhi *100,2),
                        'ros' => $julRos,
                        'tot_ros' => round($julRos / $julTerpenuhi *100,2),
                        'htl' => $julHtl,
                        'tot_htl' => round($julHtl / $julTerpenuhi *100,2),
                        'button' => $julButton,
                        'tot_button' => round($julButton / $julTerpenuhi *100,2),
                        'print' => $julPrint,
                        'tot_print' => round($julPrint / $julTerpenuhi *100,2),
                        'bs' => $julBs,
                        'tot_bs' => round($julBs / $julTerpenuhi *100,2),
                        'unb' => $julUnb,
                        'tot_unb' => round($julUnb / $julTerpenuhi *100,2),
                        'shading' => $julShading,
                        'tot_shading' => round($julShading / $julTerpenuhi *100,2),
                        'dof' => $julDof,
                        'tot_dof' => round($julDof / $julTerpenuhi *100,2),
                        'dirty' => $julDirty,
                        'tot_dirty' => round($julDirty / $julTerpenuhi *100,2),
                        'shiny' => $julShiny,
                        'tot_shiny' => round($julShiny / $julTerpenuhi *100,2),
                        'sticker' => $julSticker,
                        'tot_sticker' => round($julSticker / $julTerpenuhi *100,2),
                        'trimming' => $julTrimming,
                        'tot_trimming' => round($julTrimming / $julTerpenuhi *100,2),
                        'ip' => $julIP,
                        'tot_ip' => round($julIP / $julTerpenuhi *100,2),
                        'meas' => $julMeas,
                        'tot_meas' => round($julMeas / $julTerpenuhi *100,2),
                        'other' => $julOther,
                        'tot_other' => round($julOther / $julTerpenuhi *100,2),
                        'total_reject' => $julReject,
                        'p_total_reject' => round($julReject/$julTerpenuhi*100,2),
                        'total_check' => $julCheck,
                        'remark' => $value2->string1,
                        'id_line' => $value2->id_line
                    ];
                }
            }
        }
        $TotalJul2 = collect($dataJul)
            ->groupBy('tgl_pengerjaan')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        $TotalJul = collect($TotalJul2)
            ->groupBy('id_line')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        // biar remark nya kebawa semua 
        $testJul = [];
        $cobaJul = collect($dataJul)->where('remark', '!=', null)->groupBy('tgl_pengerjaan');
        foreach ($cobaJul as $key => $value) {
        $testJul[] = [
                'tgl_pengerjaan' => $key,
                'remark'=>  $value->implode('remark', ' | ')
            ];
        }
        $JulTerpenuhi = collect($TotalJul)->sum('terpenuhi');
        $JulFG = collect($TotalJul)->sum('fg');
        $JulBroken = collect($TotalJul)->sum('broken');
        $JulSkip = collect($TotalJul)->sum('skip');
        $JulPktw = collect($TotalJul)->sum('pktw');
        $JulCrooked = collect($TotalJul)->sum('crooked');
        $JulPleated = collect($TotalJul)->sum('pleated');
        $JulRos = collect($TotalJul)->sum('ros');
        $JulHtl = collect($TotalJul)->sum('htl');
        $JulButton = collect($TotalJul)->sum('button');
        $JulPrint = collect($TotalJul)->sum('print');
        $JulBs = collect($TotalJul)->sum('bs');
        $JulUnb = collect($TotalJul)->sum('unb');
        $JulShading = collect($TotalJul)->sum('shading');
        $JulDof = collect($TotalJul)->sum('dof');
        $JulDirty = collect($TotalJul)->sum('dirty');
        $JulShiny = collect($TotalJul)->sum('shiny');
        $JulSticker = collect($TotalJul)->sum('sticker');
        $JulTrimming = collect($TotalJul)->sum('trimming');
        $JulIP = collect($TotalJul)->sum('ip');
        $JulMeas = collect($TotalJul)->sum('meas');
        $JulOther = collect($TotalJul)->sum('other');
        $JulTotalCheck = collect($TotalJul)->sum('total_check');
        $JulTotalReject = collect($TotalJul)->sum('total_reject');

        if($JulTerpenuhi != 0 || $JulFG != 0 || $JulBroken != 0 || $JulSkip != 0 || $JulPktw != 0 || $JulCrooked != 0
        || $JulPleated != 0 || $JulRos != 0 || $JulHtl != 0 || $JulButton != 0 || $JulPrint != 0 || $JulBs != 0
        || $JulUnb != 0 || $JulShading != 0 || $JulDof != 0 || $JulDirty != 0 || $JulShiny != 0 || $JulSticker != 0
        || $JulTrimming != 0 || $JulIP != 0 || $JulMeas != 0 || $JulOther != 0){
            $tot_fg = round($JulFG / $JulTerpenuhi *100,2);
            $tot_broken = round($JulBroken / $JulTerpenuhi *100,2);
            $tot_skip = round($JulSkip / $JulTerpenuhi *100,2);
            $tot_pktw = round($JulPktw / $JulTerpenuhi *100,2);
            $tot_crooked = round($JulCrooked / $JulTerpenuhi *100,2);
            $tot_pleated = round($JulPleated / $JulTerpenuhi *100,2);
            $tot_ros = round($JulRos / $JulTerpenuhi *100,2);
            $tot_htl = round($JulHtl / $JulTerpenuhi *100,2);
            $tot_button = round($JulButton / $JulTerpenuhi *100,2);
            $tot_print = round($JulPrint / $JulTerpenuhi *100,2);
            $tot_bs = round($JulBs / $JulTerpenuhi *100,2);
            $tot_unb = round($JulUnb / $JulTerpenuhi *100,2);
            $tot_shading = round($JulShading / $JulTerpenuhi *100,2);
            $tot_dof = round($JulDof / $JulTerpenuhi *100,2);
            $tot_dirty = round($JulDirty / $JulTerpenuhi *100,2);
            $tot_shiny = round($JulShiny / $JulTerpenuhi *100,2);
            $tot_sticker = round($JulSticker / $JulTerpenuhi *100,2);
            $tot_trimming = round($JulTrimming / $JulTerpenuhi *100,2);
            $tot_ip = round($JulIP / $JulTerpenuhi *100,2);
            $tot_meas = round($JulMeas / $JulTerpenuhi *100,2);
            $tot_other = round($JulOther / $JulTerpenuhi *100,2);
            $p_total_reject = round($JulTotalReject / $JulTerpenuhi *100,2);
        }else{
            $tot_fg = 0;
            $tot_broken = 0;
            $tot_skip = 0;
            $tot_pktw = 0;
            $tot_crooked = 0;
            $tot_pleated = 0;
            $tot_ros = 0;
            $tot_htl = 0;
            $tot_button = 0;
            $tot_print = 0;
            $tot_bs = 0;
            $tot_unb = 0;
            $tot_shading = 0;
            $tot_dof = 0;
            $tot_dirty = 0;
            $tot_shiny = 0;
            $tot_sticker = 0;
            $tot_trimming = 0;
            $tot_ip = 0;
            $tot_meas = 0;
            $tot_other = 0;
            $p_total_reject = 0;
        }
        
        $JulAll[] = [
            'target_terpenuhi' => $JulTerpenuhi,
            'fg' => $JulFG,
            'tot_fg' => $tot_fg,
            'broken' => $JulBroken,
            'tot_broken' => $tot_broken,
            'skip' => $JulSkip,
            'tot_skip' => $tot_skip,
            'pktw' => $JulPktw,
            'tot_pktw' => $tot_pktw,
            'crooked' => $JulCrooked,
            'tot_crooked' => $tot_crooked,
            'pleated' => $JulPleated,
            'tot_pleated' => $tot_pleated,
            'ros' => $JulRos,
            'tot_ros' => $tot_ros,
            'htl' => $JulHtl,
            'tot_htl' => $tot_htl,
            'button' => $JulButton,
            'tot_button' => $tot_button,
            'print' => $JulPrint,
            'tot_print' => $tot_print,
            'bs' => $JulBs,
            'tot_bs' => $tot_bs,
            'unb' => $JulUnb,
            'tot_unb' => $tot_unb,
            'shading' => $JulShading,
            'tot_shading' => $tot_shading,
            'dof' => $JulDof,
            'tot_dof' => $tot_dof,
            'dirty' => $JulDirty,
            'tot_dirty' => $tot_dirty,
            'shiny' => $JulShiny,
            'tot_shiny' => $tot_shiny,
            'sticker' => $JulSticker,
            'tot_sticker' => $tot_sticker,
            'trimming' => $JulTrimming,
            'tot_trimming' => $tot_trimming,
            'ip' => $JulIP,
            'tot_ip' => $tot_ip,
            'meas' => $JulMeas,
            'tot_meas' => $tot_meas,
            'other' => $JulOther,
            'tot_other' => $tot_other,
            'total_reject' => $JulTotalReject,
            'p_total_reject' => $p_total_reject,
            'total_check' => $JulTotalCheck
        ];
        $totalJuli = $JulAll[0];
        $JulRemark = collect($dataJul)->where('remark', '!=', null)->implode('remark', ' | ');
        // end data bulan juli 

        // data bulan agustus 
        $detailAgs = LineDetail::where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get();
        $dataAgs = [];
        foreach ($data as $key => $value) {
            foreach ($detailAgs as $key2 => $value2) {
                if($value->id == $value2->id_line){
                    $agsTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('target_terpenuhi');
                    $agsCheck = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('total_check');
                    $agsReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('total_reject');
                    $agsFG = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('fg');
                    $agsBroken = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('broken');
                    $agsSkip = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('skip');
                    $agsPktw = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('pktw');
                    $agsCrooked = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('crooked');
                    $agsPleated = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('pleated');
                    $agsRos = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('ros');
                    $agsHtl = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('htl');
                    $agsButton = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('button');
                    $agsPrint = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('print');
                    $agsBs = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('bs');
                    $agsUnb = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('unb');
                    $agsShading = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('shading');
                    $agsDof = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('dof');
                    $agsDirty = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('dirty');
                    $agsShiny = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('shiny');
                    $agsSticker = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('sticker');
                    $agsTrimming = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('trimming');
                    $agsIP = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('ip');
                    $agsMeas = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('meas');
                    $agsOther = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('other');
                    $dataAgs[] = [
                        'tgl_pengerjaan' => $value2->tgl_pengerjaan,
                        'terpenuhi' => $agsTerpenuhi,
                        'fg' => $agsFG,
                        'tot_fg' => round($agsFG / $agsTerpenuhi *100,2),
                        'broken' => $agsBroken,
                        'tot_broken' => round($agsBroken / $agsTerpenuhi *100,2),
                        'skip' => $agsSkip,
                        'tot_skip' => round($agsSkip / $agsTerpenuhi *100,2),
                        'pktw' => $agsPktw,
                        'tot_pktw' => round($agsPktw / $agsTerpenuhi *100,2),
                        'crooked' => $agsCrooked,
                        'tot_crooked' => round($agsCrooked / $agsTerpenuhi *100,2),
                        'pleated' => $agsPleated,
                        'tot_pleated' => round($agsPleated / $agsTerpenuhi *100,2),
                        'ros' => $agsRos,
                        'tot_ros' => round($agsRos / $agsTerpenuhi *100,2),
                        'htl' => $agsHtl,
                        'tot_htl' => round($agsHtl / $agsTerpenuhi *100,2),
                        'button' => $agsButton,
                        'tot_button' => round($agsButton / $agsTerpenuhi *100,2),
                        'print' => $agsPrint,
                        'tot_print' => round($agsPrint / $agsTerpenuhi *100,2),
                        'bs' => $agsBs,
                        'tot_bs' => round($agsBs / $agsTerpenuhi *100,2),
                        'unb' => $agsUnb,
                        'tot_unb' => round($agsUnb / $agsTerpenuhi *100,2),
                        'shading' => $agsShading,
                        'tot_shading' => round($agsShading / $agsTerpenuhi *100,2),
                        'dof' => $agsDof,
                        'tot_dof' => round($agsDof / $agsTerpenuhi *100,2),
                        'dirty' => $agsDirty,
                        'tot_dirty' => round($agsDirty / $agsTerpenuhi *100,2),
                        'shiny' => $agsShiny,
                        'tot_shiny' => round($agsShiny / $agsTerpenuhi *100,2),
                        'sticker' => $agsSticker,
                        'tot_sticker' => round($agsSticker / $agsTerpenuhi *100,2),
                        'trimming' => $agsTrimming,
                        'tot_trimming' => round($agsTrimming / $agsTerpenuhi *100,2),
                        'ip' => $agsIP,
                        'tot_ip' => round($agsIP / $agsTerpenuhi *100,2),
                        'meas' => $agsMeas,
                        'tot_meas' => round($agsMeas / $agsTerpenuhi *100,2),
                        'other' => $agsOther,
                        'tot_other' => round($agsOther / $agsTerpenuhi *100,2),
                        'total_reject' => $agsReject,
                        'p_total_reject' => round($agsReject/$agsTerpenuhi*100,2),
                        'total_check' => $agsCheck,
                        'remark' => $value2->string1,
                        'file' => $value2->file,
                        'sep' => 'sep',
                        'id_line' => $value2->id_line
                    ];
                }
            }
        }
        $TotalAgs2 = collect($dataAgs)
            ->groupBy('tgl_pengerjaan')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        $TotalAgs = collect($TotalAgs2)
        ->groupBy('id_line')
        ->map(function ($item) {
            return array_merge(...$item->toArray());
        })->values()->toArray();
        // biar remark nya kebawa semua 
        $testAgs = [];
        $cobaAgs = collect($dataAgs)->where('remark', '!=', null)->groupBy('tgl_pengerjaan');
        foreach ($cobaAgs as $key => $value) {
        $testAgs[] = [
                'tgl_pengerjaan' => $key,
                'remark'=>  $value->implode('remark', ' | ')
            ];
        }
        $AgsTerpenuhi = collect($TotalAgs)->sum('terpenuhi');
        $AgsFG = collect($TotalAgs)->sum('fg');
        $AgsBroken = collect($TotalAgs)->sum('broken');
        $AgsSkip = collect($TotalAgs)->sum('skip');
        $AgsPktw = collect($TotalAgs)->sum('pktw');
        $AgsCrooked = collect($TotalAgs)->sum('crooked');
        $AgsPleated = collect($TotalAgs)->sum('pleated');
        $AgsRos = collect($TotalAgs)->sum('ros');
        $AgsHtl = collect($TotalAgs)->sum('htl');
        $AgsButton = collect($TotalAgs)->sum('button');
        $AgsPrint = collect($TotalAgs)->sum('print');
        $AgsBs = collect($TotalAgs)->sum('bs');
        $AgsUnb = collect($TotalAgs)->sum('unb');
        $AgsShading = collect($TotalAgs)->sum('shading');
        $AgsDof = collect($TotalAgs)->sum('dof');
        $AgsDirty = collect($TotalAgs)->sum('dirty');
        $AgsShiny = collect($TotalAgs)->sum('shiny');
        $AgsSticker = collect($TotalAgs)->sum('sticker');
        $AgsTrimming = collect($TotalAgs)->sum('trimming');
        $AgsIP = collect($TotalAgs)->sum('ip');
        $AgsMeas = collect($TotalAgs)->sum('meas');
        $AgsOther = collect($TotalAgs)->sum('other');
        $AgsTotalCheck = collect($TotalAgs)->sum('total_check');
        $AgsTotalReject = collect($TotalAgs)->sum('total_reject');
        $AFile = collect($dataAgs)
                    ->groupBy('sep')
                    ->map(function ($item) {
                        return array_merge(...$item->toArray());
                    })->values()->toArray();
        if($AFile != null){
            $AgsFile = $AFile[0];
        }else{
            $AgsFile = null;
            $AgsFile['file'] = null;
        }
        

        if($AgsTerpenuhi != 0 || $AgsFG != 0 || $AgsBroken != 0 || $AgsSkip != 0 || $AgsPktw != 0 || $AgsCrooked != 0
        || $AgsPleated != 0 || $AgsRos != 0 || $AgsHtl != 0 || $AgsButton != 0 || $AgsPrint != 0 || $AgsBs != 0
        || $AgsUnb != 0 || $AgsShading != 0 || $AgsDof != 0 || $AgsDirty != 0 || $AgsShiny != 0 || $AgsSticker != 0
        || $AgsTrimming != 0 || $AgsIP != 0 || $AgsMeas != 0 || $AgsOther != 0){
            $tot_fg = round($AgsFG / $AgsTerpenuhi *100,2);
            $tot_broken = round($AgsBroken / $AgsTerpenuhi *100,2);
            $tot_skip = round($AgsSkip / $AgsTerpenuhi *100,2);
            $tot_pktw = round($AgsPktw / $AgsTerpenuhi *100,2);
            $tot_crooked = round($AgsCrooked / $AgsTerpenuhi *100,2);
            $tot_pleated = round($AgsPleated / $AgsTerpenuhi *100,2);
            $tot_ros = round($AgsRos / $AgsTerpenuhi *100,2);
            $tot_htl = round($AgsHtl / $AgsTerpenuhi *100,2);
            $tot_button = round($AgsButton / $AgsTerpenuhi *100,2);
            $tot_print = round($AgsPrint / $AgsTerpenuhi *100,2);
            $tot_bs = round($AgsBs / $AgsTerpenuhi *100,2);
            $tot_unb = round($AgsUnb / $AgsTerpenuhi *100,2);
            $tot_shading = round($AgsShading / $AgsTerpenuhi *100,2);
            $tot_dof = round($AgsDof / $AgsTerpenuhi *100,2);
            $tot_dirty = round($AgsDirty / $AgsTerpenuhi *100,2);
            $tot_shiny = round($AgsShiny / $AgsTerpenuhi *100,2);
            $tot_sticker = round($AgsSticker / $AgsTerpenuhi *100,2);
            $tot_trimming = round($AgsTrimming / $AgsTerpenuhi *100,2);
            $tot_ip = round($AgsIP / $AgsTerpenuhi *100,2);
            $tot_meas = round($AgsMeas / $AgsTerpenuhi *100,2);
            $tot_other = round($AgsOther / $AgsTerpenuhi *100,2);
            $p_total_reject = round($AgsTotalReject / $AgsTerpenuhi *100,2);
        }else{
            $tot_fg = 0;
            $tot_broken = 0;
            $tot_skip = 0;
            $tot_pktw = 0;
            $tot_crooked = 0;
            $tot_pleated = 0;
            $tot_ros = 0;
            $tot_htl = 0;
            $tot_button = 0;
            $tot_print = 0;
            $tot_bs = 0;
            $tot_unb = 0;
            $tot_shading = 0;
            $tot_dof = 0;
            $tot_dirty = 0;
            $tot_shiny = 0;
            $tot_sticker = 0;
            $tot_trimming = 0;
            $tot_ip = 0;
            $tot_meas = 0;
            $tot_other = 0;
            $p_total_reject = 0;
        }
        
        $AgsAll[] = [
            'target_terpenuhi' => $AgsTerpenuhi,
            'fg' => $AgsFG,
            'tot_fg' => $tot_fg,
            'broken' => $AgsBroken,
            'tot_broken' => $tot_broken,
            'skip' => $AgsSkip,
            'tot_skip' => $tot_skip,
            'pktw' => $AgsPktw,
            'tot_pktw' => $tot_pktw,
            'crooked' => $AgsCrooked,
            'tot_crooked' => $tot_crooked,
            'pleated' => $AgsPleated,
            'tot_pleated' => $tot_pleated,
            'ros' => $AgsRos,
            'tot_ros' => $tot_ros,
            'htl' => $AgsHtl,
            'tot_htl' => $tot_htl,
            'button' => $AgsButton,
            'tot_button' => $tot_button,
            'print' => $AgsPrint,
            'tot_print' => $tot_print,
            'bs' => $AgsBs,
            'tot_bs' => $tot_bs,
            'unb' => $AgsUnb,
            'tot_unb' => $tot_unb,
            'shading' => $AgsShading,
            'tot_shading' => $tot_shading,
            'dof' => $AgsDof,
            'tot_dof' => $tot_dof,
            'dirty' => $AgsDirty,
            'tot_dirty' => $tot_dirty,
            'shiny' => $AgsShiny,
            'tot_shiny' => $tot_shiny,
            'sticker' => $AgsSticker,
            'tot_sticker' => $tot_sticker,
            'trimming' => $AgsTrimming,
            'tot_trimming' => $tot_trimming,
            'ip' => $AgsIP,
            'tot_ip' => $tot_ip,
            'meas' => $AgsMeas,
            'tot_meas' => $tot_meas,
            'other' => $AgsOther,
            'tot_other' => $tot_other,
            'total_reject' => $AgsTotalReject,
            'p_total_reject' => $p_total_reject,
            'total_check' => $AgsTotalCheck,
            'file'=> $AgsFile['file']
        ];
        $totalAgustus = $AgsAll[0];
        $AgsRemark = collect($dataAgs)->where('remark', '!=', null)->implode('remark', ' | ');
        // end data bulan agustus 

        // data september
        $detailSep = LineDetail::where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get();
        $dataSep = [];
        foreach ($data as $key => $value) {
            foreach ($detailSep as $key2 => $value2) {
                if($value->id == $value2->id_line){
                    $sepTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('target_terpenuhi');
                    $sepCheck = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('total_check');
                    $sepReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('total_reject');
                    $sepFG = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('fg');
                    $sepBroken = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('broken');
                    $sepSkip = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('skip');
                    $sepPktw = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('pktw');
                    $sepCrooked = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('crooked');
                    $sepPleated = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('pleated');
                    $sepRos = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('ros');
                    $sepHtl = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('htl');
                    $sepButton = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('button');
                    $sepPrint = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('print');
                    $sepBs = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('bs');
                    $sepUnb = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('unb');
                    $sepShading = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('shading');
                    $sepDof = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('dof');
                    $sepDirty = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('dirty');
                    $sepShiny = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('shiny');
                    $sepSticker = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('sticker');
                    $sepTrimming = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('trimming');
                    $sepIP = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('ip');
                    $sepMeas = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('meas');
                    $sepOther = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('other');
                    $dataSep[] = [
                        'tgl_pengerjaan' => $value2->tgl_pengerjaan,
                        'terpenuhi' => $sepTerpenuhi,
                        'fg' => $sepFG,
                        'tot_fg' => round($sepFG / $sepTerpenuhi *100,2),
                        'broken' => $sepBroken,
                        'tot_broken' => round($sepBroken / $sepTerpenuhi *100,2),
                        'skip' => $sepSkip,
                        'tot_skip' => round($sepSkip / $sepTerpenuhi *100,2),
                        'pktw' => $sepPktw,
                        'tot_pktw' => round($sepPktw / $sepTerpenuhi *100,2),
                        'crooked' => $sepCrooked,
                        'tot_crooked' => round($sepCrooked / $sepTerpenuhi *100,2),
                        'pleated' => $sepPleated,
                        'tot_pleated' => round($sepPleated / $sepTerpenuhi *100,2),
                        'ros' => $sepRos,
                        'tot_ros' => round($sepRos / $sepTerpenuhi *100,2),
                        'htl' => $sepHtl,
                        'tot_htl' => round($sepHtl / $sepTerpenuhi *100,2),
                        'button' => $sepButton,
                        'tot_button' => round($sepButton / $sepTerpenuhi *100,2),
                        'print' => $sepPrint,
                        'tot_print' => round($sepPrint / $sepTerpenuhi *100,2),
                        'bs' => $sepBs,
                        'tot_bs' => round($sepBs / $sepTerpenuhi *100,2),
                        'unb' => $sepUnb,
                        'tot_unb' => round($sepUnb / $sepTerpenuhi *100,2),
                        'shading' => $sepShading,
                        'tot_shading' => round($sepShading / $sepTerpenuhi *100,2),
                        'dof' => $sepDof,
                        'tot_dof' => round($sepDof / $sepTerpenuhi *100,2),
                        'dirty' => $sepDirty,
                        'tot_dirty' => round($sepDirty / $sepTerpenuhi *100,2),
                        'shiny' => $sepShiny,
                        'tot_shiny' => round($sepShiny / $sepTerpenuhi *100,2),
                        'sticker' => $sepSticker,
                        'tot_sticker' => round($sepSticker / $sepTerpenuhi *100,2),
                        'trimming' => $sepTrimming,
                        'tot_trimming' => round($sepTrimming / $sepTerpenuhi *100,2),
                        'ip' => $sepIP,
                        'tot_ip' => round($sepIP / $sepTerpenuhi *100,2),
                        'meas' => $sepMeas,
                        'tot_meas' => round($sepMeas / $sepTerpenuhi *100,2),
                        'other' => $sepOther,
                        'tot_other' => round($sepOther / $sepTerpenuhi *100,2),
                        'total_reject' => $sepReject,
                        'p_total_reject' => round($sepReject/$sepTerpenuhi*100,2),
                        'total_check' => $sepCheck,
                        'remark' => $value2->string1,
                        'file' => $value2->file,
                        'sep' => 'sep',
                        'id_line' => $value2->id_line
                    ];
                }
            }
        }
        $TotalSep2 = collect($dataSep)
            ->groupBy('tgl_pengerjaan')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        $TotalSep = collect($TotalSep2)
            ->groupBy('id_line')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        // biar remark nya kebawa semua 
        $testSep = [];
        $cobaSep = collect($dataSep)->where('remark', '!=', null)->groupBy('tgl_pengerjaan');
        foreach ($cobaSep as $key => $value) {
        $testSep[] = [
                'tgl_pengerjaan' => $key,
                'remark'=>  $value->implode('remark', ' | ')
            ];
        }
        $SepTerpenuhi = collect($TotalSep)->sum('terpenuhi');
        $SepFG = collect($TotalSep)->sum('fg');
        $SepBroken = collect($TotalSep)->sum('broken');
        $SepSkip = collect($TotalSep)->sum('skip');
        $SepPktw = collect($TotalSep)->sum('pktw');
        $SepCrooked = collect($TotalSep)->sum('crooked');
        $SepPleated = collect($TotalSep)->sum('pleated');
        $SepRos = collect($TotalSep)->sum('ros');
        $SepHtl = collect($TotalSep)->sum('htl');
        $SepButton = collect($TotalSep)->sum('button');
        $SepPrint = collect($TotalSep)->sum('print');
        $SepBs = collect($TotalSep)->sum('bs');
        $SepUnb = collect($TotalSep)->sum('unb');
        $SepShading = collect($TotalSep)->sum('shading');
        $SepDof = collect($TotalSep)->sum('dof');
        $SepDirty = collect($TotalSep)->sum('dirty');
        $SepShiny = collect($TotalSep)->sum('shiny');
        $SepSticker = collect($TotalSep)->sum('sticker');
        $SepTrimming = collect($TotalSep)->sum('trimming');
        $SepIP = collect($TotalSep)->sum('ip');
        $SepMeas = collect($TotalSep)->sum('meas');
        $SepOther = collect($TotalSep)->sum('other');
        $SepTotalCheck = collect($TotalSep)->sum('total_check');
        $SepTotalReject = collect($TotalSep)->sum('total_reject');
        $BFile = collect($dataSep)
                    ->groupBy('sep')
                    ->map(function ($item) {
                        return array_merge(...$item->toArray());
                    })->values()->toArray();
        if($BFile != null){
            $SepFile = $BFile[0];
        }else{
            $SepFile = null;
            $SepFile['file'] = null;
        }
        

        if($SepTerpenuhi != 0 || $SepFG != 0 || $SepBroken != 0 || $SepSkip != 0 || $SepPktw != 0 || $SepCrooked != 0
        || $SepPleated != 0 || $SepRos != 0 || $SepHtl != 0 || $SepButton != 0 || $SepPrint != 0 || $SepBs != 0
        || $SepUnb != 0 || $SepShading != 0 || $SepDof != 0 || $SepDirty != 0 || $SepShiny != 0 || $SepSticker != 0
        || $SepTrimming != 0 || $SepIP != 0 || $SepMeas != 0 || $SepOther != 0){
            $tot_fg = round($SepFG / $SepTerpenuhi *100,2);
            $tot_broken = round($SepBroken / $SepTerpenuhi *100,2);
            $tot_skip = round($SepSkip / $SepTerpenuhi *100,2);
            $tot_pktw = round($SepPktw / $SepTerpenuhi *100,2);
            $tot_crooked = round($SepCrooked / $SepTerpenuhi *100,2);
            $tot_pleated = round($SepPleated / $SepTerpenuhi *100,2);
            $tot_ros = round($SepRos / $SepTerpenuhi *100,2);
            $tot_htl = round($SepHtl / $SepTerpenuhi *100,2);
            $tot_button = round($SepButton / $SepTerpenuhi *100,2);
            $tot_print = round($SepPrint / $SepTerpenuhi *100,2);
            $tot_bs = round($SepBs / $SepTerpenuhi *100,2);
            $tot_unb = round($SepUnb / $SepTerpenuhi *100,2);
            $tot_shading = round($SepShading / $SepTerpenuhi *100,2);
            $tot_dof = round($SepDof / $SepTerpenuhi *100,2);
            $tot_dirty = round($SepDirty / $SepTerpenuhi *100,2);
            $tot_shiny = round($SepShiny / $SepTerpenuhi *100,2);
            $tot_sticker = round($SepSticker / $SepTerpenuhi *100,2);
            $tot_trimming = round($SepTrimming / $SepTerpenuhi *100,2);
            $tot_ip = round($SepIP / $SepTerpenuhi *100,2);
            $tot_meas = round($SepMeas / $SepTerpenuhi *100,2);
            $tot_other = round($SepOther / $SepTerpenuhi *100,2);
            $p_total_reject = round($SepTotalReject / $SepTerpenuhi *100,2);
        }else{
            $tot_fg = 0;
            $tot_broken = 0;
            $tot_skip = 0;
            $tot_pktw = 0;
            $tot_crooked = 0;
            $tot_pleated = 0;
            $tot_ros = 0;
            $tot_htl = 0;
            $tot_button = 0;
            $tot_print = 0;
            $tot_bs = 0;
            $tot_unb = 0;
            $tot_shading = 0;
            $tot_dof = 0;
            $tot_dirty = 0;
            $tot_shiny = 0;
            $tot_sticker = 0;
            $tot_trimming = 0;
            $tot_ip = 0;
            $tot_meas = 0;
            $tot_other = 0;
            $p_total_reject = 0;
        }
        
        $SepAll[] = [
            'target_terpenuhi' => $SepTerpenuhi,
            'fg' => $SepFG,
            'tot_fg' => $tot_fg,
            'broken' => $SepBroken,
            'tot_broken' => $tot_broken,
            'skip' => $SepSkip,
            'tot_skip' => $tot_skip,
            'pktw' => $SepPktw,
            'tot_pktw' => $tot_pktw,
            'crooked' => $SepCrooked,
            'tot_crooked' => $tot_crooked,
            'pleated' => $SepPleated,
            'tot_pleated' => $tot_pleated,
            'ros' => $SepRos,
            'tot_ros' => $tot_ros,
            'htl' => $SepHtl,
            'tot_htl' => $tot_htl,
            'button' => $SepButton,
            'tot_button' => $tot_button,
            'print' => $SepPrint,
            'tot_print' => $tot_print,
            'bs' => $SepBs,
            'tot_bs' => $tot_bs,
            'unb' => $SepUnb,
            'tot_unb' => $tot_unb,
            'shading' => $SepShading,
            'tot_shading' => $tot_shading,
            'dof' => $SepDof,
            'tot_dof' => $tot_dof,
            'dirty' => $SepDirty,
            'tot_dirty' => $tot_dirty,
            'shiny' => $SepShiny,
            'tot_shiny' => $tot_shiny,
            'sticker' => $SepSticker,
            'tot_sticker' => $tot_sticker,
            'trimming' => $SepTrimming,
            'tot_trimming' => $tot_trimming,
            'ip' => $SepIP,
            'tot_ip' => $tot_ip,
            'meas' => $SepMeas,
            'tot_meas' => $tot_meas,
            'other' => $SepOther,
            'tot_other' => $tot_other,
            'total_reject' => $SepTotalReject,
            'p_total_reject' => $p_total_reject,
            'total_check' => $SepTotalCheck,
            'file'=> $SepFile['file']
        ];
        $totalSeptember = $SepAll[0];
        $SepRemark = collect($dataSep)->where('remark', '!=', null)->implode('remark', ' | ');
        // end data september

        // data bulan oktober
        $detailOkt = LineDetail::where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get();
        $dataOkt = [];
        foreach ($data as $key => $value) {
            foreach ($detailOkt as $key2 => $value2) {
                if($value->id == $value2->id_line){
                    $oktTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('target_terpenuhi');
                    $oktCheck = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('total_check');
                    $oktReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('total_reject');
                    $oktFG = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('fg');
                    $oktBroken = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('broken');
                    $oktSkip = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('skip');
                    $oktPktw = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('pktw');
                    $oktCrooked = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('crooked');
                    $oktPleated = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('pleated');
                    $oktRos = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('ros');
                    $oktHtl = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('htl');
                    $oktButton = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('button');
                    $oktPrint = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('print');
                    $oktBs = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('bs');
                    $oktUnb = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('unb');
                    $oktShading = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('shading');
                    $oktDof = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('dof');
                    $oktDirty = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('dirty');
                    $oktShiny = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('shiny');
                    $oktSticker = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('sticker');
                    $oktTrimming = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('trimming');
                    $oktIP = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('ip');
                    $oktMeas = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('meas');
                    $oktOther = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('other');
                    $dataOkt[] = [
                        'id_line' => $value2->id_line,
                        'tgl_pengerjaan' => $value2->tgl_pengerjaan,
                        'terpenuhi' => $oktTerpenuhi,
                        'fg' => $oktFG,
                        'tot_fg' => round($oktFG / $oktTerpenuhi *100,2),
                        'broken' => $oktBroken,
                        'tot_broken' => round($oktBroken / $oktTerpenuhi *100,2),
                        'skip' => $oktSkip,
                        'tot_skip' => round($oktSkip / $oktTerpenuhi *100,2),
                        'pktw' => $oktPktw,
                        'tot_pktw' => round($oktPktw / $oktTerpenuhi *100,2),
                        'crooked' => $oktCrooked,
                        'tot_crooked' => round($oktCrooked / $oktTerpenuhi *100,2),
                        'pleated' => $oktPleated,
                        'tot_pleated' => round($oktPleated / $oktTerpenuhi *100,2),
                        'ros' => $oktRos,
                        'tot_ros' => round($oktRos / $oktTerpenuhi *100,2),
                        'htl' => $oktHtl,
                        'tot_htl' => round($oktHtl / $oktTerpenuhi *100,2),
                        'button' => $oktButton,
                        'tot_button' => round($oktButton / $oktTerpenuhi *100,2),
                        'print' => $oktPrint,
                        'tot_print' => round($oktPrint / $oktTerpenuhi *100,2),
                        'bs' => $oktBs,
                        'tot_bs' => round($oktBs / $oktTerpenuhi *100,2),
                        'unb' => $oktUnb,
                        'tot_unb' => round($oktUnb / $oktTerpenuhi *100,2),
                        'shading' => $oktShading,
                        'tot_shading' => round($oktShading / $oktTerpenuhi *100,2),
                        'dof' => $oktDof,
                        'tot_dof' => round($oktDof / $oktTerpenuhi *100,2),
                        'dirty' => $oktDirty,
                        'tot_dirty' => round($oktDirty / $oktTerpenuhi *100,2),
                        'shiny' => $oktShiny,
                        'tot_shiny' => round($oktShiny / $oktTerpenuhi *100,2),
                        'sticker' => $oktSticker,
                        'tot_sticker' => round($oktSticker / $oktTerpenuhi *100,2),
                        'trimming' => $oktTrimming,
                        'tot_trimming' => round($oktTrimming / $oktTerpenuhi *100,2),
                        'ip' => $oktIP,
                        'tot_ip' => round($oktIP / $oktTerpenuhi *100,2),
                        'meas' => $oktMeas,
                        'tot_meas' => round($oktMeas / $oktTerpenuhi *100,2),
                        'other' => $oktOther,
                        'tot_other' => round($oktOther / $oktTerpenuhi *100,2),
                        'total_reject' => $oktReject,
                        'p_total_reject' => round($oktReject/$oktTerpenuhi*100,2),
                        'total_check' => $oktCheck,
                        'remark' => $value2->string1,
                        'file' => $value2->file,
                        'sep' => 'sep',
                    ];
                }
            }
        }
        $TotalOkt2 = collect($dataOkt)
            ->groupBy('tgl_pengerjaan')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        $TotalOkt = collect($TotalOkt2)
        ->groupBy('id_line')
        ->map(function ($item) {
            return array_merge(...$item->toArray());
        })->values()->toArray();

        // biar remark nya kebawa semua 
        $testOkt = [];
        $cobaOkt = collect($dataOkt)->where('remark', '!=', null)->groupBy('tgl_pengerjaan');
        foreach ($cobaOkt as $key => $value) {
        $testOkt[] = [
                'tgl_pengerjaan' => $key,
                'remark'=>  $value->implode('remark', ' | ')
            ];
        }
        $OktTerpenuhi = collect($TotalOkt)->sum('terpenuhi');
        $OktFG = collect($TotalOkt)->sum('fg');
        $OktBroken = collect($TotalOkt)->sum('broken');
        $OktSkip = collect($TotalOkt)->sum('skip');
        $OktPktw = collect($TotalOkt)->sum('pktw');
        $OktCrooked = collect($TotalOkt)->sum('crooked');
        $OktPleated = collect($TotalOkt)->sum('pleated');
        $OktRos = collect($TotalOkt)->sum('ros');
        $OktHtl = collect($TotalOkt)->sum('htl');
        $OktButton = collect($TotalOkt)->sum('button');
        $OktPrint = collect($TotalOkt)->sum('print');
        $OktBs = collect($TotalOkt)->sum('bs');
        $OktUnb = collect($TotalOkt)->sum('unb');
        $OktShading = collect($TotalOkt)->sum('shading');
        $OktDof = collect($TotalOkt)->sum('dof');
        $OktDirty = collect($TotalOkt)->sum('dirty');
        $OktShiny = collect($TotalOkt)->sum('shiny');
        $OktSticker = collect($TotalOkt)->sum('sticker');
        $OktTrimming = collect($TotalOkt)->sum('trimming');
        $OktIP = collect($TotalOkt)->sum('ip');
        $OktMeas = collect($TotalOkt)->sum('meas');
        $OktOther = collect($TotalOkt)->sum('other');
        $OktTotalCheck = collect($TotalOkt)->sum('total_check');
        $OktTotalReject = collect($TotalOkt)->sum('total_reject');

        $CFile = collect($dataOkt)
                    ->where('file')
                    ->groupBy('sep')
                    ->map(function ($item) {
                        return array_merge(...$item->toArray());
                    })->values()->toArray();
        if($CFile != null){
            $OktFile = $CFile[0];
        }else{
            $OktFile = null;
            $OktFile['file'] = null;
        }

        if($OktTerpenuhi != 0 || $OktFG != 0 || $OktBroken != 0 || $OktSkip != 0 || $OktPktw != 0 || $OktCrooked != 0
        || $OktPleated != 0 || $OktRos != 0 || $OktHtl != 0 || $OktButton != 0 || $OktPrint != 0 || $OktBs != 0
        || $OktUnb != 0 || $OktShading != 0 || $OktDof != 0 || $OktDirty != 0 || $OktShiny != 0 || $OktSticker != 0
        || $OktTrimming != 0 || $OktIP != 0 || $OktMeas != 0 || $OktOther != 0){
            $tot_fg = round($OktFG / $OktTerpenuhi *100,2);
            $tot_broken = round($OktBroken / $OktTerpenuhi *100,2);
            $tot_skip = round($OktSkip / $OktTerpenuhi *100,2);
            $tot_pktw = round($OktPktw / $OktTerpenuhi *100,2);
            $tot_crooked = round($OktCrooked / $OktTerpenuhi *100,2);
            $tot_pleated = round($OktPleated / $OktTerpenuhi *100,2);
            $tot_ros = round($OktRos / $OktTerpenuhi *100,2);
            $tot_htl = round($OktHtl / $OktTerpenuhi *100,2);
            $tot_button = round($OktButton / $OktTerpenuhi *100,2);
            $tot_print = round($OktPrint / $OktTerpenuhi *100,2);
            $tot_bs = round($OktBs / $OktTerpenuhi *100,2);
            $tot_unb = round($OktUnb / $OktTerpenuhi *100,2);
            $tot_shading = round($OktShading / $OktTerpenuhi *100,2);
            $tot_dof = round($OktDof / $OktTerpenuhi *100,2);
            $tot_dirty = round($OktDirty / $OktTerpenuhi *100,2);
            $tot_shiny = round($OktShiny / $OktTerpenuhi *100,2);
            $tot_sticker = round($OktSticker / $OktTerpenuhi *100,2);
            $tot_trimming = round($OktTrimming / $OktTerpenuhi *100,2);
            $tot_ip = round($OktIP / $OktTerpenuhi *100,2);
            $tot_meas = round($OktMeas / $OktTerpenuhi *100,2);
            $tot_other = round($OktOther / $OktTerpenuhi *100,2);
            $p_total_reject = round($OktTotalReject / $OktTerpenuhi *100,2);
        }else{
            $tot_fg = 0;
            $tot_broken = 0;
            $tot_skip = 0;
            $tot_pktw = 0;
            $tot_crooked = 0;
            $tot_pleated = 0;
            $tot_ros = 0;
            $tot_htl = 0;
            $tot_button = 0;
            $tot_print = 0;
            $tot_bs = 0;
            $tot_unb = 0;
            $tot_shading = 0;
            $tot_dof = 0;
            $tot_dirty = 0;
            $tot_shiny = 0;
            $tot_sticker = 0;
            $tot_trimming = 0;
            $tot_ip = 0;
            $tot_meas = 0;
            $tot_other = 0;
            $p_total_reject = 0;
        }
        
        $OktAll[] = [
            'target_terpenuhi' => $OktTerpenuhi,
            'fg' => $OktFG,
            'tot_fg' => $tot_fg,
            'broken' => $OktBroken,
            'tot_broken' => $tot_broken,
            'skip' => $OktSkip,
            'tot_skip' => $tot_skip,
            'pktw' => $OktPktw,
            'tot_pktw' => $tot_pktw,
            'crooked' => $OktCrooked,
            'tot_crooked' => $tot_crooked,
            'pleated' => $OktPleated,
            'tot_pleated' => $tot_pleated,
            'ros' => $OktRos,
            'tot_ros' => $tot_ros,
            'htl' => $OktHtl,
            'tot_htl' => $tot_htl,
            'button' => $OktButton,
            'tot_button' => $tot_button,
            'print' => $OktPrint,
            'tot_print' => $tot_print,
            'bs' => $OktBs,
            'tot_bs' => $tot_bs,
            'unb' => $OktUnb,
            'tot_unb' => $tot_unb,
            'shading' => $OktShading,
            'tot_shading' => $tot_shading,
            'dof' => $OktDof,
            'tot_dof' => $tot_dof,
            'dirty' => $OktDirty,
            'tot_dirty' => $tot_dirty,
            'shiny' => $OktShiny,
            'tot_shiny' => $tot_shiny,
            'sticker' => $OktSticker,
            'tot_sticker' => $tot_sticker,
            'trimming' => $OktTrimming,
            'tot_trimming' => $tot_trimming,
            'ip' => $OktIP,
            'tot_ip' => $tot_ip,
            'meas' => $OktMeas,
            'tot_meas' => $tot_meas,
            'other' => $OktOther,
            'tot_other' => $tot_other,
            'total_reject' => $OktTotalReject,
            'p_total_reject' => $p_total_reject,
            'total_check' => $OktTotalCheck,
            'file' => $OktFile['file']
        ];
        $totalOktober = $OktAll[0];
        $OktRemark = collect($dataOkt)->where('remark', '!=', null)->implode('remark', ' | ');
        // end data bulan oktober

        // data bulan november 
        $detailNov = LineDetail::where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get();
        $dataNov = [];
        foreach ($data as $key => $value) {
            foreach ($detailNov as $key2 => $value2) {
                if($value->id == $value2->id_line){
                    $novTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('target_terpenuhi');
                    $novCheck = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('total_check');
                    $novReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('total_reject');
                    $novFG = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('fg');
                    $novBroken = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('broken');
                    $novSkip = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('skip');
                    $novPktw = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('pktw');
                    $novCrooked = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('crooked');
                    $novPleated = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('pleated');
                    $novRos = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('ros');
                    $novHtl = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('htl');
                    $novButton = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('button');
                    $novPrint = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('print');
                    $novBs = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('bs');
                    $novUnb = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('unb');
                    $novShading = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('shading');
                    $novDof = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('dof');
                    $novDirty = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('dirty');
                    $novShiny = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('shiny');
                    $novSticker = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('sticker');
                    $novTrimming = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('trimming');
                    $novIP = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('ip');
                    $novMeas = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('meas');
                    $novOther = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('other');
                    $dataNov[] = [
                        'tgl_pengerjaan' => $value2->tgl_pengerjaan,
                        'terpenuhi' => $novTerpenuhi,
                        'fg' => $novFG,
                        'tot_fg' => round($novFG / $novTerpenuhi *100,2),
                        'broken' => $novBroken,
                        'tot_broken' => round($novBroken / $novTerpenuhi *100,2),
                        'skip' => $novSkip,
                        'tot_skip' => round($novSkip / $novTerpenuhi *100,2),
                        'pktw' => $novPktw,
                        'tot_pktw' => round($novPktw / $novTerpenuhi *100,2),
                        'crooked' => $novCrooked,
                        'tot_crooked' => round($novCrooked / $novTerpenuhi *100,2),
                        'pleated' => $novPleated,
                        'tot_pleated' => round($novPleated / $novTerpenuhi *100,2),
                        'ros' => $novRos,
                        'tot_ros' => round($novRos / $novTerpenuhi *100,2),
                        'htl' => $novHtl,
                        'tot_htl' => round($novHtl / $novTerpenuhi *100,2),
                        'button' => $novButton,
                        'tot_button' => round($novButton / $novTerpenuhi *100,2),
                        'print' => $novPrint,
                        'tot_print' => round($novPrint / $novTerpenuhi *100,2),
                        'bs' => $novBs,
                        'tot_bs' => round($novBs / $novTerpenuhi *100,2),
                        'unb' => $novUnb,
                        'tot_unb' => round($novUnb / $novTerpenuhi *100,2),
                        'shading' => $novShading,
                        'tot_shading' => round($novShading / $novTerpenuhi *100,2),
                        'dof' => $novDof,
                        'tot_dof' => round($novDof / $novTerpenuhi *100,2),
                        'dirty' => $novDirty,
                        'tot_dirty' => round($novDirty / $novTerpenuhi *100,2),
                        'shiny' => $novShiny,
                        'tot_shiny' => round($novShiny / $novTerpenuhi *100,2),
                        'sticker' => $novSticker,
                        'tot_sticker' => round($novSticker / $novTerpenuhi *100,2),
                        'trimming' => $novTrimming,
                        'tot_trimming' => round($novTrimming / $novTerpenuhi *100,2),
                        'ip' => $novIP,
                        'tot_ip' => round($novIP / $novTerpenuhi *100,2),
                        'meas' => $novMeas,
                        'tot_meas' => round($novMeas / $novTerpenuhi *100,2),
                        'other' => $novOther,
                        'tot_other' => round($novOther / $novTerpenuhi *100,2),
                        'total_reject' => $novReject,
                        'p_total_reject' => round($novReject/$novTerpenuhi*100,2),
                        'total_check' => $novCheck,
                        'remark' => $value2->string1,
                        'file' => $value2->file,
                        'sep' => 'sep',
                        'id_line' => $value2->id_line
                    ];
                }
            }
        }
        $TotalNov2 = collect($dataNov)
            ->groupBy('tgl_pengerjaan')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        $TotalNov = collect($TotalNov2)
            ->groupBy('id_line')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        // biar remark nya kebawa semua 
        $testNov = [];
        $cobaNov = collect($dataNov)->where('remark', '!=', null)->groupBy('tgl_pengerjaan');
        foreach ($cobaNov as $key => $value) {
        $testNov[] = [
                'tgl_pengerjaan' => $key,
                'remark'=>  $value->implode('remark', ' | ')
            ];
        }
        $NovTerpenuhi = collect($TotalNov)->sum('terpenuhi');
        $NovFG = collect($TotalNov)->sum('fg');
        $NovBroken = collect($TotalNov)->sum('broken');
        $NovSkip = collect($TotalNov)->sum('skip');
        $NovPktw = collect($TotalNov)->sum('pktw');
        $NovCrooked = collect($TotalNov)->sum('crooked');
        $NovPleated = collect($TotalNov)->sum('pleated');
        $NovRos = collect($TotalNov)->sum('ros');
        $NovHtl = collect($TotalNov)->sum('htl');
        $NovButton = collect($TotalNov)->sum('button');
        $NovPrint = collect($TotalNov)->sum('print');
        $NovBs = collect($TotalNov)->sum('bs');
        $NovUnb = collect($TotalNov)->sum('unb');
        $NovShading = collect($TotalNov)->sum('shading');
        $NovDof = collect($TotalNov)->sum('dof');
        $NovDirty = collect($TotalNov)->sum('dirty');
        $NovShiny = collect($TotalNov)->sum('shiny');
        $NovSticker = collect($TotalNov)->sum('sticker');
        $NovTrimming = collect($TotalNov)->sum('trimming');
        $NovIP = collect($TotalNov)->sum('ip');
        $NovMeas = collect($TotalNov)->sum('meas');
        $NovOther = collect($TotalNov)->sum('other');
        $NovTotalCheck = collect($TotalNov)->sum('total_check');
        $NovTotalReject = collect($TotalNov)->sum('total_reject');
        $DFile = collect($dataNov)
                    ->groupBy('sep')
                    ->map(function ($item) {
                        return array_merge(...$item->toArray());
                    })->values()->toArray();
        if($DFile != null){
            $NovFile = $DFile[0];
        }else{
            $NovFile = null;
            $NovFile['file'] = null;
        }

        if($NovTerpenuhi != 0 || $NovFG != 0 || $NovBroken != 0 || $NovSkip != 0 || $NovPktw != 0 || $NovCrooked != 0
        || $NovPleated != 0 || $NovRos != 0 || $NovHtl != 0 || $NovButton != 0 || $NovPrint != 0 || $NovBs != 0
        || $NovUnb != 0 || $NovShading != 0 || $NovDof != 0 || $NovDirty != 0 || $NovShiny != 0 || $NovSticker != 0
        || $NovTrimming != 0 || $NovIP != 0 || $NovMeas != 0 || $NovOther != 0){
            $tot_fg = round($NovFG / $NovTerpenuhi *100,2);
            $tot_broken = round($NovBroken / $NovTerpenuhi *100,2);
            $tot_skip = round($NovSkip / $NovTerpenuhi *100,2);
            $tot_pktw = round($NovPktw / $NovTerpenuhi *100,2);
            $tot_crooked = round($NovCrooked / $NovTerpenuhi *100,2);
            $tot_pleated = round($NovPleated / $NovTerpenuhi *100,2);
            $tot_ros = round($NovRos / $NovTerpenuhi *100,2);
            $tot_htl = round($NovHtl / $NovTerpenuhi *100,2);
            $tot_button = round($NovButton / $NovTerpenuhi *100,2);
            $tot_print = round($NovPrint / $NovTerpenuhi *100,2);
            $tot_bs = round($NovBs / $NovTerpenuhi *100,2);
            $tot_unb = round($NovUnb / $NovTerpenuhi *100,2);
            $tot_shading = round($NovShading / $NovTerpenuhi *100,2);
            $tot_dof = round($NovDof / $NovTerpenuhi *100,2);
            $tot_dirty = round($NovDirty / $NovTerpenuhi *100,2);
            $tot_shiny = round($NovShiny / $NovTerpenuhi *100,2);
            $tot_sticker = round($NovSticker / $NovTerpenuhi *100,2);
            $tot_trimming = round($NovTrimming / $NovTerpenuhi *100,2);
            $tot_ip = round($NovIP / $NovTerpenuhi *100,2);
            $tot_meas = round($NovMeas / $NovTerpenuhi *100,2);
            $tot_other = round($NovOther / $NovTerpenuhi *100,2);
            $p_total_reject = round($NovTotalReject / $NovTerpenuhi *100,2);
        }else{
            $tot_fg = 0;
            $tot_broken = 0;
            $tot_skip = 0;
            $tot_pktw = 0;
            $tot_crooked = 0;
            $tot_pleated = 0;
            $tot_ros = 0;
            $tot_htl = 0;
            $tot_button = 0;
            $tot_print = 0;
            $tot_bs = 0;
            $tot_unb = 0;
            $tot_shading = 0;
            $tot_dof = 0;
            $tot_dirty = 0;
            $tot_shiny = 0;
            $tot_sticker = 0;
            $tot_trimming = 0;
            $tot_ip = 0;
            $tot_meas = 0;
            $tot_other = 0;
            $p_total_reject = 0;
        }
        
        $NovAll[] = [
            'target_terpenuhi' => $NovTerpenuhi,
            'fg' => $NovFG,
            'tot_fg' => $tot_fg,
            'broken' => $NovBroken,
            'tot_broken' => $tot_broken,
            'skip' => $NovSkip,
            'tot_skip' => $tot_skip,
            'pktw' => $NovPktw,
            'tot_pktw' => $tot_pktw,
            'crooked' => $NovCrooked,
            'tot_crooked' => $tot_crooked,
            'pleated' => $NovPleated,
            'tot_pleated' => $tot_pleated,
            'ros' => $NovRos,
            'tot_ros' => $tot_ros,
            'htl' => $NovHtl,
            'tot_htl' => $tot_htl,
            'button' => $NovButton,
            'tot_button' => $tot_button,
            'print' => $NovPrint,
            'tot_print' => $tot_print,
            'bs' => $NovBs,
            'tot_bs' => $tot_bs,
            'unb' => $NovUnb,
            'tot_unb' => $tot_unb,
            'shading' => $NovShading,
            'tot_shading' => $tot_shading,
            'dof' => $NovDof,
            'tot_dof' => $tot_dof,
            'dirty' => $NovDirty,
            'tot_dirty' => $tot_dirty,
            'shiny' => $NovShiny,
            'tot_shiny' => $tot_shiny,
            'sticker' => $NovSticker,
            'tot_sticker' => $tot_sticker,
            'trimming' => $NovTrimming,
            'tot_trimming' => $tot_trimming,
            'ip' => $NovIP,
            'tot_ip' => $tot_ip,
            'meas' => $NovMeas,
            'tot_meas' => $tot_meas,
            'other' => $NovOther,
            'tot_other' => $tot_other,
            'total_reject' => $NovTotalReject,
            'p_total_reject' => $p_total_reject,
            'total_check' => $NovTotalCheck,
            'file' => $NovFile['file']
        ];
        $totalNovember = $NovAll[0];
        $NovRemark = collect($dataNov)->where('remark', '!=', null)->implode('remark', ' | ');
        // end data bulan november 

        // data bulan desember
        $detailDes = LineDetail::where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get();
        $dataDes = [];
        foreach ($data as $key => $value) {
            foreach ($detailDes as $key2 => $value2) {
                if($value->id == $value2->id_line){
                    $desTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('target_terpenuhi');
                    $desCheck = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('total_check');
                    $desReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('total_reject');
                    $desFG = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('fg');
                    $desBroken = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('broken');
                    $desSkip = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('skip');
                    $desPktw = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('pktw');
                    $desCrooked = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('crooked');
                    $desPleated = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('pleated');
                    $desRos = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('ros');
                    $desHtl = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('htl');
                    $desButton = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('button');
                    $desPrint = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('print');
                    $desBs = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('bs');
                    $desUnb = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('unb');
                    $desShading = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('shading');
                    $desDof = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('dof');
                    $desDirty = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('dirty');
                    $desShiny = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('shiny');
                    $desSticker = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('sticker');
                    $desTrimming = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('trimming');
                    $desIP = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('ip');
                    $desMeas = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('meas');
                    $desOther = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('other');
                    $dataDes[] = [
                        'tgl_pengerjaan' => $value2->tgl_pengerjaan,
                        'terpenuhi' => $desTerpenuhi,
                        'fg' => $desFG,
                        'tot_fg' => round($desFG / $desTerpenuhi *100,2),
                        'broken' => $desBroken,
                        'tot_broken' => round($desBroken / $desTerpenuhi *100,2),
                        'skip' => $desSkip,
                        'tot_skip' => round($desSkip / $desTerpenuhi *100,2),
                        'pktw' => $desPktw,
                        'tot_pktw' => round($desPktw / $desTerpenuhi *100,2),
                        'crooked' => $desCrooked,
                        'tot_crooked' => round($desCrooked / $desTerpenuhi *100,2),
                        'pleated' => $desPleated,
                        'tot_pleated' => round($desPleated / $desTerpenuhi *100,2),
                        'ros' => $desRos,
                        'tot_ros' => round($desRos / $desTerpenuhi *100,2),
                        'htl' => $desHtl,
                        'tot_htl' => round($desHtl / $desTerpenuhi *100,2),
                        'button' => $desButton,
                        'tot_button' => round($desButton / $desTerpenuhi *100,2),
                        'print' => $desPrint,
                        'tot_print' => round($desPrint / $desTerpenuhi *100,2),
                        'bs' => $desBs,
                        'tot_bs' => round($desBs / $desTerpenuhi *100,2),
                        'unb' => $desUnb,
                        'tot_unb' => round($desUnb / $desTerpenuhi *100,2),
                        'shading' => $desShading,
                        'tot_shading' => round($desShading / $desTerpenuhi *100,2),
                        'dof' => $desDof,
                        'tot_dof' => round($desDof / $desTerpenuhi *100,2),
                        'dirty' => $desDirty,
                        'tot_dirty' => round($desDirty / $desTerpenuhi *100,2),
                        'shiny' => $desShiny,
                        'tot_shiny' => round($desShiny / $desTerpenuhi *100,2),
                        'sticker' => $desSticker,
                        'tot_sticker' => round($desSticker / $desTerpenuhi *100,2),
                        'trimming' => $desTrimming,
                        'tot_trimming' => round($desTrimming / $desTerpenuhi *100,2),
                        'ip' => $desIP,
                        'tot_ip' => round($desIP / $desTerpenuhi *100,2),
                        'meas' => $desMeas,
                        'tot_meas' => round($desMeas / $desTerpenuhi *100,2),
                        'other' => $desOther,
                        'tot_other' => round($desOther / $desTerpenuhi *100,2),
                        'total_reject' => $desReject,
                        'p_total_reject' => round($desReject/$desTerpenuhi*100,2),
                        'total_check' => $desCheck,
                        'remark' => $value2->string1,
                        'file' => $value2->file,
                        'sep' => 'sep',
                        'id_line' => $value2->id_line
                    ];
                }
            }
        }
        $TotalDes2 = collect($dataDes)
            ->groupBy('tgl_pengerjaan')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        $TotalDes = collect($TotalDes2)
            ->groupBy('id_line')
            ->map(function ($item) {
                return array_merge(...$item->toArray());
            })->values()->toArray();
        // biar remark nya kebawa semua 
        $testDes = [];
        $cobaDes = collect($dataDes)->where('remark', '!=', null)->groupBy('tgl_pengerjaan');
        foreach ($cobaDes as $key => $value) {
        $testDes[] = [
                'tgl_pengerjaan' => $key,
                'remark'=>  $value->implode('remark', ' | ')
            ];
        }
        $DesTerpenuhi = collect($TotalDes)->sum('terpenuhi');
        $DesFG = collect($TotalDes)->sum('fg');
        $DesBroken = collect($TotalDes)->sum('broken');
        $DesSkip = collect($TotalDes)->sum('skip');
        $DesPktw = collect($TotalDes)->sum('pktw');
        $DesCrooked = collect($TotalDes)->sum('crooked');
        $DesPleated = collect($TotalDes)->sum('pleated');
        $DesRos = collect($TotalDes)->sum('ros');
        $DesHtl = collect($TotalDes)->sum('htl');
        $DesButton = collect($TotalDes)->sum('button');
        $DesPrint = collect($TotalDes)->sum('print');
        $DesBs = collect($TotalDes)->sum('bs');
        $DesUnb = collect($TotalDes)->sum('unb');
        $DesShading = collect($TotalDes)->sum('shading');
        $DesDof = collect($TotalDes)->sum('dof');
        $DesDirty = collect($TotalDes)->sum('dirty');
        $DesShiny = collect($TotalDes)->sum('shiny');
        $DesSticker = collect($TotalDes)->sum('sticker');
        $DesTrimming = collect($TotalDes)->sum('trimming');
        $DesIP = collect($TotalDes)->sum('ip');
        $DesMeas = collect($TotalDes)->sum('meas');
        $DesOther = collect($TotalDes)->sum('other');
        $DesTotalCheck = collect($TotalDes)->sum('total_check');
        $DesTotalReject = collect($TotalDes)->sum('total_reject');
        $EFile = collect($dataDes)
        ->groupBy('sep')
        ->map(function ($item) {
            return array_merge(...$item->toArray());
        })->values()->toArray();
        if($EFile != null){
            $DesFile = $EFile[0];
        }else{
            $DesFile = null;
            $DesFile['file'] = null;
        }
        
        if($DesTerpenuhi != 0 || $DesFG != 0 || $DesBroken != 0 || $DesSkip != 0 || $DesPktw != 0 || $DesCrooked != 0
        || $DesPleated != 0 || $DesRos != 0 || $DesHtl != 0 || $DesButton != 0 || $DesPrint != 0 || $DesBs != 0
        || $DesUnb != 0 || $DesShading != 0 || $DesDof != 0 || $DesDirty != 0 || $DesShiny != 0 || $DesSticker != 0
        || $DesTrimming != 0 || $DesIP != 0 || $DesMeas != 0 || $DesOther != 0){
            $tot_fg = round($DesFG / $DesTerpenuhi *100,2);
            $tot_broken = round($DesBroken / $DesTerpenuhi *100,2);
            $tot_skip = round($DesSkip / $DesTerpenuhi *100,2);
            $tot_pktw = round($DesPktw / $DesTerpenuhi *100,2);
            $tot_crooked = round($DesCrooked / $DesTerpenuhi *100,2);
            $tot_pleated = round($DesPleated / $DesTerpenuhi *100,2);
            $tot_ros = round($DesRos / $DesTerpenuhi *100,2);
            $tot_htl = round($DesHtl / $DesTerpenuhi *100,2);
            $tot_button = round($DesButton / $DesTerpenuhi *100,2);
            $tot_print = round($DesPrint / $DesTerpenuhi *100,2);
            $tot_bs = round($DesBs / $DesTerpenuhi *100,2);
            $tot_unb = round($DesUnb / $DesTerpenuhi *100,2);
            $tot_shading = round($DesShading / $DesTerpenuhi *100,2);
            $tot_dof = round($DesDof / $DesTerpenuhi *100,2);
            $tot_dirty = round($DesDirty / $DesTerpenuhi *100,2);
            $tot_shiny = round($DesShiny / $DesTerpenuhi *100,2);
            $tot_sticker = round($DesSticker / $DesTerpenuhi *100,2);
            $tot_trimming = round($DesTrimming / $DesTerpenuhi *100,2);
            $tot_ip = round($DesIP / $DesTerpenuhi *100,2);
            $tot_meas = round($DesMeas / $DesTerpenuhi *100,2);
            $tot_other = round($DesOther / $DesTerpenuhi *100,2);
            $p_total_reject = round($DesTotalReject / $DesTerpenuhi *100,2);
        }else{
            $tot_fg = 0;
            $tot_broken = 0;
            $tot_skip = 0;
            $tot_pktw = 0;
            $tot_crooked = 0;
            $tot_pleated = 0;
            $tot_ros = 0;
            $tot_htl = 0;
            $tot_button = 0;
            $tot_print = 0;
            $tot_bs = 0;
            $tot_unb = 0;
            $tot_shading = 0;
            $tot_dof = 0;
            $tot_dirty = 0;
            $tot_shiny = 0;
            $tot_sticker = 0;
            $tot_trimming = 0;
            $tot_ip = 0;
            $tot_meas = 0;
            $tot_other = 0;
            $p_total_reject = 0;
        }
        
        $DesAll[] = [
            'target_terpenuhi' => $DesTerpenuhi,
            'fg' => $DesFG,
            'tot_fg' => $tot_fg,
            'broken' => $DesBroken,
            'tot_broken' => $tot_broken,
            'skip' => $DesSkip,
            'tot_skip' => $tot_skip,
            'pktw' => $DesPktw,
            'tot_pktw' => $tot_pktw,
            'crooked' => $DesCrooked,
            'tot_crooked' => $tot_crooked,
            'pleated' => $DesPleated,
            'tot_pleated' => $tot_pleated,
            'ros' => $DesRos,
            'tot_ros' => $tot_ros,
            'htl' => $DesHtl,
            'tot_htl' => $tot_htl,
            'button' => $DesButton,
            'tot_button' => $tot_button,
            'print' => $DesPrint,
            'tot_print' => $tot_print,
            'bs' => $DesBs,
            'tot_bs' => $tot_bs,
            'unb' => $DesUnb,
            'tot_unb' => $tot_unb,
            'shading' => $DesShading,
            'tot_shading' => $tot_shading,
            'dof' => $DesDof,
            'tot_dof' => $tot_dof,
            'dirty' => $DesDirty,
            'tot_dirty' => $tot_dirty,
            'shiny' => $DesShiny,
            'tot_shiny' => $tot_shiny,
            'sticker' => $DesSticker,
            'tot_sticker' => $tot_sticker,
            'trimming' => $DesTrimming,
            'tot_trimming' => $tot_trimming,
            'ip' => $DesIP,
            'tot_ip' => $tot_ip,
            'meas' => $DesMeas,
            'tot_meas' => $tot_meas,
            'other' => $DesOther,
            'tot_other' => $tot_other,
            'total_reject' => $DesTotalReject,
            'p_total_reject' => $p_total_reject,
            'total_check' => $DesTotalCheck,
            'file' => $DesFile['file']
        ];
        $totalDesember = $DesAll[0];
        $DesRemark = collect($dataDes)->where('remark', '!=', null)->implode('remark', ' | ');
        // end data bulan desember 

        // data total All Line
        $allTerpenuhi = $totalJanuari['target_terpenuhi'] + $totalFebruari['target_terpenuhi'] + $totalMaret['target_terpenuhi'] + $totalApril['target_terpenuhi'] +
                        $totalMei['target_terpenuhi'] + $totalJuni['target_terpenuhi'] + $totalJuli['target_terpenuhi'] + $totalAgustus['target_terpenuhi'] +
                        $totalSeptember['target_terpenuhi'] + $totalOktober['target_terpenuhi'] + $totalNovember['target_terpenuhi'] + $totalDesember['target_terpenuhi'];
        $allFG = $totalJanuari['fg'] + $totalFebruari['fg'] + $totalMaret['fg'] + $totalApril['fg'] +
                        $totalMei['fg'] + $totalJuni['fg'] + $totalJuli['fg'] + $totalAgustus['fg'] +
                        $totalSeptember['fg'] + $totalOktober['fg'] + $totalNovember['fg'] + $totalDesember['fg'];
        $allBroken = $totalJanuari['broken'] + $totalFebruari['broken'] + $totalMaret['broken'] + $totalApril['broken'] +
                        $totalMei['broken'] + $totalJuni['broken'] + $totalJuli['broken'] + $totalAgustus['broken'] +
                        $totalSeptember['broken'] + $totalOktober['broken'] + $totalNovember['broken'] + $totalDesember['broken'];
        $allSkip = $totalJanuari['skip'] + $totalFebruari['skip'] + $totalMaret['skip'] + $totalApril['skip'] +
                        $totalMei['skip'] + $totalJuni['skip'] + $totalJuli['skip'] + $totalAgustus['skip'] +
                        $totalSeptember['skip'] + $totalOktober['skip'] + $totalNovember['skip'] + $totalDesember['skip'];
        $allPktw = $totalJanuari['pktw'] + $totalFebruari['pktw'] + $totalMaret['pktw'] + $totalApril['pktw'] +
                        $totalMei['pktw'] + $totalJuni['pktw'] + $totalJuli['pktw'] + $totalAgustus['pktw'] +
                        $totalSeptember['pktw'] + $totalOktober['pktw'] + $totalNovember['pktw'] + $totalDesember['pktw'];
        $allCrooked = $totalJanuari['crooked'] + $totalFebruari['crooked'] + $totalMaret['crooked'] + $totalApril['crooked'] +
                        $totalMei['crooked'] + $totalJuni['crooked'] + $totalJuli['crooked'] + $totalAgustus['crooked'] +
                        $totalSeptember['crooked'] + $totalOktober['crooked'] + $totalNovember['crooked'] + $totalDesember['crooked'];
        $allPleated = $totalJanuari['pleated'] + $totalFebruari['pleated'] + $totalMaret['pleated'] + $totalApril['pleated'] +
                        $totalMei['pleated'] + $totalJuni['pleated'] + $totalJuli['pleated'] + $totalAgustus['pleated'] +
                        $totalSeptember['pleated'] + $totalOktober['pleated'] + $totalNovember['pleated'] + $totalDesember['pleated'];
        $allRos = $totalJanuari['ros'] + $totalFebruari['ros'] + $totalMaret['ros'] + $totalApril['ros'] +
                        $totalMei['ros'] + $totalJuni['ros'] + $totalJuli['ros'] + $totalAgustus['ros'] +
                        $totalSeptember['ros'] + $totalOktober['ros'] + $totalNovember['ros'] + $totalDesember['ros'];
        $allHtl = $totalJanuari['htl'] + $totalFebruari['htl'] + $totalMaret['htl'] + $totalApril['htl'] +
                        $totalMei['htl'] + $totalJuni['htl'] + $totalJuli['htl'] + $totalAgustus['htl'] +
                        $totalSeptember['htl'] + $totalOktober['htl'] + $totalNovember['htl'] + $totalDesember['htl'];
        $allButton = $totalJanuari['button'] + $totalFebruari['button'] + $totalMaret['button'] + $totalApril['button'] +
                        $totalMei['button'] + $totalJuni['button'] + $totalJuli['button'] + $totalAgustus['button'] +
                        $totalSeptember['button'] + $totalOktober['button'] + $totalNovember['button'] + $totalDesember['button'];
        $allPrint = $totalJanuari['print'] + $totalFebruari['print'] + $totalMaret['print'] + $totalApril['print'] +
                        $totalMei['print'] + $totalJuni['print'] + $totalJuli['print'] + $totalAgustus['print'] +
                        $totalSeptember['print'] + $totalOktober['print'] + $totalNovember['print'] + $totalDesember['print'];
        $allBs = $totalJanuari['bs'] + $totalFebruari['bs'] + $totalMaret['bs'] + $totalApril['bs'] +
                        $totalMei['bs'] + $totalJuni['bs'] + $totalJuli['bs'] + $totalAgustus['bs'] +
                        $totalSeptember['bs'] + $totalOktober['bs'] + $totalNovember['bs'] + $totalDesember['bs']; 
        $allUnb = $totalJanuari['unb'] + $totalFebruari['unb'] + $totalMaret['unb'] + $totalApril['unb'] +
                        $totalMei['unb'] + $totalJuni['unb'] + $totalJuli['unb'] + $totalAgustus['unb'] +
                        $totalSeptember['unb'] + $totalOktober['unb'] + $totalNovember['unb'] + $totalDesember['unb'];
        $allShading = $totalJanuari['shading'] + $totalFebruari['shading'] + $totalMaret['shading'] + $totalApril['shading'] +
                        $totalMei['shading'] + $totalJuni['shading'] + $totalJuli['shading'] + $totalAgustus['shading'] +
                        $totalSeptember['shading'] + $totalOktober['shading'] + $totalNovember['shading'] + $totalDesember['shading'];
        $allDof = $totalJanuari['dof'] + $totalFebruari['dof'] + $totalMaret['dof'] + $totalApril['dof'] +
                        $totalMei['dof'] + $totalJuni['dof'] + $totalJuli['dof'] + $totalAgustus['dof'] +
                        $totalSeptember['dof'] + $totalOktober['dof'] + $totalNovember['dof'] + $totalDesember['dof'];
        $allDirty = $totalJanuari['dirty'] + $totalFebruari['dirty'] + $totalMaret['dirty'] + $totalApril['dirty'] +
                        $totalMei['dirty'] + $totalJuni['dirty'] + $totalJuli['dirty'] + $totalAgustus['dirty'] +
                        $totalSeptember['dirty'] + $totalOktober['dirty'] + $totalNovember['dirty'] + $totalDesember['dirty'];
        $allShiny = $totalJanuari['shiny'] + $totalFebruari['shiny'] + $totalMaret['shiny'] + $totalApril['shiny'] +
                        $totalMei['shiny'] + $totalJuni['shiny'] + $totalJuli['shiny'] + $totalAgustus['shiny'] +
                        $totalSeptember['shiny'] + $totalOktober['shiny'] + $totalNovember['shiny'] + $totalDesember['shiny'];
        $allSticker = $totalJanuari['sticker'] + $totalFebruari['sticker'] + $totalMaret['sticker'] + $totalApril['sticker'] +
                        $totalMei['sticker'] + $totalJuni['sticker'] + $totalJuli['sticker'] + $totalAgustus['sticker'] +
                        $totalSeptember['sticker'] + $totalOktober['sticker'] + $totalNovember['sticker'] + $totalDesember['sticker'];
        $allTrimming = $totalJanuari['trimming'] + $totalFebruari['trimming'] + $totalMaret['trimming'] + $totalApril['trimming'] +
                        $totalMei['trimming'] + $totalJuni['trimming'] + $totalJuli['trimming'] + $totalAgustus['trimming'] +
                        $totalSeptember['trimming'] + $totalOktober['trimming'] + $totalNovember['trimming'] + $totalDesember['trimming'];
        $allIP = $totalJanuari['ip'] + $totalFebruari['ip'] + $totalMaret['ip'] + $totalApril['ip'] +
                        $totalMei['ip'] + $totalJuni['ip'] + $totalJuli['ip'] + $totalAgustus['ip'] +
                        $totalSeptember['ip'] + $totalOktober['ip'] + $totalNovember['ip'] + $totalDesember['ip'];
        $allMeas = $totalJanuari['meas'] + $totalFebruari['meas'] + $totalMaret['meas'] + $totalApril['meas'] +
                        $totalMei['meas'] + $totalJuni['meas'] + $totalJuli['meas'] + $totalAgustus['meas'] +
                        $totalSeptember['meas'] + $totalOktober['meas'] + $totalNovember['meas'] + $totalDesember['meas']; 
        $allOther = $totalJanuari['other'] + $totalFebruari['other'] + $totalMaret['other'] + $totalApril['other'] +
                        $totalMei['other'] + $totalJuni['other'] + $totalJuli['other'] + $totalAgustus['other'] +
                        $totalSeptember['other'] + $totalOktober['other'] + $totalNovember['other'] + $totalDesember['other'];
        $allTotalReject = $totalJanuari['total_reject'] + $totalFebruari['total_reject'] + $totalMaret['total_reject'] + $totalApril['total_reject'] +
                        $totalMei['total_reject'] + $totalJuni['total_reject'] + $totalJuli['total_reject'] + $totalAgustus['total_reject'] +
                        $totalSeptember['total_reject'] + $totalOktober['total_reject'] + $totalNovember['total_reject'] + $totalDesember['total_reject'];
        $allTotalCheck = $totalJanuari['total_check'] + $totalFebruari['total_check'] + $totalMaret['total_check'] + $totalApril['total_check'] +
                        $totalMei['total_check'] + $totalJuni['total_check'] + $totalJuli['total_check'] + $totalAgustus['total_check'] +
                        $totalSeptember['total_check'] + $totalOktober['total_check'] + $totalNovember['total_check'] + $totalDesember['total_check'];
        
        if($allTerpenuhi != 0 || $allFG != 0 || $allBroken != 0 || $allSkip != 0 || $allPktw != 0 || $allCrooked != 0
        || $allPleated != 0 || $allRos != 0 || $allHtl != 0 || $allButton != 0 || $allPrint != 0 || $allBs != 0
        || $allUnb != 0 || $allShading != 0 || $allDof != 0 || $allDirty != 0 || $allShiny != 0 || $allSticker != 0
        || $allTrimming != 0 || $allIP != 0 || $allMeas != 0 || $allOther != 0){
            $tot_fg = round($allFG / $allTerpenuhi *100,2);
            $tot_broken = round($allBroken / $allTerpenuhi *100,2);
            $tot_skip = round($allSkip / $allTerpenuhi *100,2);
            $tot_pktw = round($allPktw / $allTerpenuhi *100,2);
            $tot_crooked = round($allCrooked / $allTerpenuhi *100,2);
            $tot_pleated = round($allPleated / $allTerpenuhi *100,2);
            $tot_ros = round($allRos / $allTerpenuhi *100,2);
            $tot_htl = round($allHtl / $allTerpenuhi *100,2);
            $tot_button = round($allButton / $allTerpenuhi *100,2);
            $tot_print = round($allPrint / $allTerpenuhi *100,2);
            $tot_bs = round($allBs / $allTerpenuhi *100,2);
            $tot_unb = round($allUnb / $allTerpenuhi *100,2);
            $tot_shading = round($allShading / $allTerpenuhi *100,2);
            $tot_dof = round($allDof / $allTerpenuhi *100,2);
            $tot_dirty = round($allDirty / $allTerpenuhi *100,2);
            $tot_shiny = round($allShiny / $allTerpenuhi *100,2);
            $tot_sticker = round($allSticker / $allTerpenuhi *100,2);
            $tot_trimming = round($allTrimming / $allTerpenuhi *100,2);
            $tot_ip = round($allIP / $allTerpenuhi *100,2);
            $tot_meas = round($allMeas / $allTerpenuhi *100,2);
            $tot_other = round($allOther / $allTerpenuhi *100,2);
            $p_total_reject = round($allTotalReject / $allTerpenuhi *100,2);
        }else{
            $tot_fg = 0;
            $tot_broken = 0;
            $tot_skip = 0;
            $tot_pktw = 0;
            $tot_crooked = 0;
            $tot_pleated = 0;
            $tot_ros = 0;
            $tot_htl = 0;
            $tot_button = 0;
            $tot_print = 0;
            $tot_bs = 0;
            $tot_unb = 0;
            $tot_shading = 0;
            $tot_dof = 0;
            $tot_dirty = 0;
            $tot_shiny = 0;
            $tot_sticker = 0;
            $tot_trimming = 0;
            $tot_ip = 0;
            $tot_meas = 0;
            $tot_other = 0;
            $p_total_reject = 0;
        }
        
        
        $totalData = [
            'fg' => $allFG,
            'target_terpenuhi' => $allTerpenuhi,
            'fg' => $allFG,
            'tot_fg' => $tot_fg,
            'broken' => $allBroken,
            'tot_broken' => $tot_broken,
            'skip' => $allSkip,
            'tot_skip' => $tot_skip,
            'pktw' => $allPktw,
            'tot_pktw' => $tot_pktw,
            'crooked' => $allCrooked,
            'tot_crooked' => $tot_crooked,
            'pleated' => $allPleated,
            'tot_pleated' => $tot_pleated,
            'ros' => $allRos,
            'tot_ros' => $tot_ros,
            'htl' => $allHtl,
            'tot_htl' => $tot_htl,
            'button' => $allButton,
            'tot_button' => $tot_button,
            'print' => $allPrint,
            'tot_print' => $tot_print,
            'bs' => $allBs,
            'tot_bs' => $tot_bs,
            'unb' => $allUnb,
            'tot_unb' => $tot_unb,
            'shading' => $allShading,
            'tot_shading' => $tot_shading,
            'dof' => $allDof,
            'tot_dof' => $tot_dof,
            'dirty' => $allDirty,
            'tot_dirty' => $tot_dirty,
            'shiny' => $allShiny,
            'tot_shiny' => $tot_shiny,
            'sticker' => $allSticker,
            'tot_sticker' => $tot_sticker,
            'trimming' => $allTrimming,
            'tot_trimming' => $tot_trimming,
            'ip' => $allIP,
            'tot_ip' => $tot_ip,
            'meas' => $allMeas,
            'tot_meas' => $tot_meas,
            'other' => $allOther,
            'tot_other' => $tot_other,
            'total_reject' => $allTotalReject,
            'p_total_reject' => $p_total_reject,
            'total_check' => $allTotalCheck
        ];
        // end data total All Line
        
        $pdf = PDF::loadview('qc/rework/report/tahunan_pdf', compact('totalJanuari', 'JanRemark', 'totalFebruari', 'FebRemark', 'totalMaret', 'MarRemark',
        'totalApril', 'AprRemark', 'totalMei', 'MeiRemark', 'totalJuni', 'JunRemark', 'totalJuli', 'JulRemark', 
        'totalAgustus', 'AgsRemark', 'totalSeptember', 'SepRemark', 'totalOktober', 'OktRemark', 'totalNovember', 'NovRemark',
        'totalDesember', 'DesRemark', 'branch', 'branch_detail', 'tahun', 'totalData'))->setPaper('legal', 'landscape');
        return $pdf->stream();
    }
}
