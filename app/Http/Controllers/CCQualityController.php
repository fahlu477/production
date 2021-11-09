<?php

namespace App\Http\Controllers;

use App\Branch;
use App\LineDetail;
use App\MasterLine;
use Illuminate\Http\Request;

class CCQualityController extends Controller
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

    public function rework($id)
    {
        $tanggal = date('Y-m-d', strtotime(' -1 day'));

        $dataBranch = Branch::findorfail($id);
        $branch = $dataBranch->kode_branch;
        $branch_detail = $dataBranch->branchdetail;

        if(
            LineDetail::where('tgl_pengerjaan', $tanggal)->count()
        ) {
 
        $data =  MasterLine::where('branch', $branch)
                ->with('ltarget')
                ->where('branch_detail', $branch_detail)
                ->get();

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

        // untuk detail line 
        $detailLine = [];
        foreach ($data as $key => $value) {
            foreach ($value->ltarget as $key2 => $value2) {
                foreach ($value2->detail as $key3 => $value3) {
                    if ($value3->tgl_pengerjaan == $tanggal) {
                        $detailLine[] = [
                            'line' => $value->string1,
                            'no_wo' => $value2->no_wo,
                            'target_wo' => $value3->target_wo,
                            'terpenuhi' => $value3->target_terpenuhi,
                            'proses' => $value2->proses
                        ];
                    }
                }
            }
        }
        // dd($detailLine);
        // end detail line 

        // UNTUK DETAIL REJECT PER LINE
        $masterline = [];
        foreach ($data as $key => $value) {
            foreach ($value->ltarget as $key2 => $value2) {
                foreach ($value2->detail as $key3 => $value3) {
                    if($value3->tgl_pengerjaan == $tanggal) {
                        $jwo = LineDetail::where('tgl_pengerjaan', $tanggal)->where('id_line', $value->id)->count('no_wo');
                        $jterpenuhi = LineDetail::where('tgl_pengerjaan', $tanggal)->where('id_line', $value->id)->sum('target_terpenuhi');
                        $jreject = LineDetail::where('tgl_pengerjaan', $tanggal)->where('id_line', $value->id)->sum('total_reject');
                        if ($jterpenuhi == 0 || $jterpenuhi == null || $jreject == 0 || $jreject == null) {
                            $j_p_reject = 0;
                        }else{
                            $j_p_reject = round($jreject/$jterpenuhi*100,2);
                        }
                        $masterline[] = [
                            'id_line' => $value->id,
                            'line' => $value->string1,
                            'jumlah_wo' => $jwo,
                            'p_reject' => $j_p_reject,
                            'terpenuhi' => $jterpenuhi,
                            'jreject' => $jreject
                        ]; 
                    }
                }
            }
        }
        // dd($masterline);
        $mline = collect($masterline)
                ->groupBy('id_line')
                ->map(function ($item) {
                    return array_merge(...$item->toArray());
                })->values()->toArray();
        $jum_wo = collect($mline)->sum('jumlah_wo');
        // END


            return view('CommandCenter.rework', compact('tanggal', 'dataBranch', 'totalSemuaLine', 'detailLine', 'mline','jum_wo'));
        }else{
            throw new \Exception('Data Kosong !');
        }
    }

    public function lines($id)
    {
        $dataCek = MasterLine::findorfail($id);

        // untuk mencari dari branch mana line tersebut
        $xBranch = Branch::all();
        foreach ($xBranch as $key => $value) {
            if ($value->kode_branch == $dataCek->branch && $value->branchdetail == $dataCek->branch_detail) {
                $id_branch = $value->id;
            }
        }
        $dataBranch = Branch::findorfail($id_branch);
        $branch = $dataBranch->kode_branch;
        $branch_detail = $dataBranch->branchdetail;
        // end branch 

        $id_line = $id;
        $tanggal = date('Y-m-d', strtotime(' -1 day'));
        $data =  MasterLine::with('ltarget')
                ->where('branch', $branch)
                ->where('branch_detail', $branch_detail)
                ->get();

        if(
            LineDetail::where('tgl_pengerjaan', $tanggal)->where('id_line', $id)->count()
        ) {
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
                        if($terpenuhi == 0){
                            $p_reject = 0;
                        }else{
                            $p_reject = round($total_reject/$terpenuhi*100,2);
                        }
                        // Data untuk ditampilkan ke blade 
                        $dataTotal[] = [
                            'terpenuhi' => $terpenuhi,
                            'id_line' => $value->id,
                            'line' => $value->string1,
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
                $p_total_reject = 0;
            }else{
                $p_total_reject = round(collect($TotalResult)->sum('total_reject') / $semua_terpenuhi *100,2);
            }
            $px_total_reject = [
                'p_total_reject' => $p_total_reject,
            ];

            $terpenuhi = LineDetail::where('id_line', $id)->where('tgl_pengerjaan', $tanggal)->get()->sum('target_terpenuhi');
            $total_check = LineDetail::where('id_line', $id)->where('tgl_pengerjaan', $tanggal)->get()->sum('total_check');
            $total_reject = LineDetail::where('id_line', $id)->where('tgl_pengerjaan', $tanggal)->get()->sum('total_reject');
            $fg = LineDetail::where('id_line', $id)->where('tgl_pengerjaan', $tanggal)->get()->sum('fg');
            $broken = LineDetail::where('id_line', $id)->where('tgl_pengerjaan', $tanggal)->get()->sum('broken');
            $skip = LineDetail::where('id_line', $id)->where('tgl_pengerjaan', $tanggal)->get()->sum('skip');
            $pktw = LineDetail::where('id_line', $id)->where('tgl_pengerjaan', $tanggal)->get()->sum('pktw');
            $crooked = LineDetail::where('id_line', $id)->where('tgl_pengerjaan', $tanggal)->get()->sum('crooked');
            $pleated = LineDetail::where('id_line', $id)->where('tgl_pengerjaan', $tanggal)->get()->sum('pleated');
            $ros = LineDetail::where('id_line', $id)->where('tgl_pengerjaan', $tanggal)->get()->sum('ros');
            $htl = LineDetail::where('id_line', $id)->where('tgl_pengerjaan', $tanggal)->get()->sum('htl');
            $p_htl = LineDetail::where('id_line', $id)->where('tgl_pengerjaan', $tanggal)->get()->sum('p_htl');
            $button = LineDetail::where('id_line', $id)->where('tgl_pengerjaan', $tanggal)->get()->sum('button');
            $print = LineDetail::where('id_line', $id)->where('tgl_pengerjaan', $tanggal)->get()->sum('print');
            $bs = LineDetail::where('id_line', $id)->where('tgl_pengerjaan', $tanggal)->get()->sum('bs');
            $unb = LineDetail::where('id_line', $id)->where('tgl_pengerjaan', $tanggal)->get()->sum('unb');
            $shading = LineDetail::where('id_line', $id)->where('tgl_pengerjaan', $tanggal)->get()->sum('shading');
            $dof = LineDetail::where('id_line', $id)->where('tgl_pengerjaan', $tanggal)->get()->sum('dof');
            $dirty = LineDetail::where('id_line', $id)->where('tgl_pengerjaan', $tanggal)->get()->sum('dirty');
            $shiny = LineDetail::where('id_line', $id)->where('tgl_pengerjaan', $tanggal)->get()->sum('shiny');
            $sticker = LineDetail::where('id_line', $id)->where('tgl_pengerjaan', $tanggal)->get()->sum('sticker');
            $trimming = LineDetail::where('id_line', $id)->where('tgl_pengerjaan', $tanggal)->get()->sum('trimming');
            $ip = LineDetail::where('id_line', $id)->where('tgl_pengerjaan', $tanggal)->get()->sum('ip');
            $meas = LineDetail::where('id_line', $id)->where('tgl_pengerjaan', $tanggal)->get()->sum('meas');
            $other = LineDetail::where('id_line', $id)->where('tgl_pengerjaan', $tanggal)->get()->sum('other');
            
            if ($terpenuhi == 0 || $terpenuhi == null || $total_reject == 0 || $total_reject == null) {
                $p_total_reject = 0;
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
            }else{
                $p_total_reject = round($total_reject/$terpenuhi*100,2);
                $tot_fg =  round($fg/$terpenuhi*100,2);
                $tot_broken =  round($broken/$terpenuhi*100,2);;
                $tot_skip =  round($skip/$terpenuhi*100,2);
                $tot_pktw =  round($pktw/$terpenuhi*100,2);
                $tot_crooked =  round($crooked/$terpenuhi*100,2);
                $tot_pleated =  round($pleated/$terpenuhi*100,2);
                $tot_ros =  round($ros/$terpenuhi*100,2);
                $tot_htl = round($htl/$terpenuhi*100,2);
                $tot_button =  round($button/$terpenuhi*100,2);
                $tot_print =  round($print/$terpenuhi*100,2);
                $tot_bs =  round($bs/$terpenuhi*100,2);
                $tot_unb =  round($unb/$terpenuhi*100,2);
                $tot_shading =  round($shading/$terpenuhi*100,2);
                $tot_dof =  round($dof/$terpenuhi*100,2);
                $tot_dirty =  round($dirty/$terpenuhi*100,2);
                $tot_shiny =  round($shiny/$terpenuhi*100,2);
                $tot_sticker =  round($sticker/$terpenuhi*100,2);
                $tot_trimming =  round($trimming/$terpenuhi*100,2);
                $tot_ip =  round($ip/$terpenuhi*100,2);
                $tot_meas =  round($meas/$terpenuhi*100,2);
                $tot_other =  round($other/$terpenuhi*100,2);
            }
            
            $totalSemuaLine = [
                'fg' => $fg,
                'tot_fg' =>$tot_fg,
                'broken' => $broken,
                'tot_broken' =>$tot_broken,
                'skip' => $skip,
                'tot_skip' =>$tot_skip,
                'pktw' => $pktw,
                'tot_pktw' =>$tot_pktw,
                'crooked' => $crooked,
                'tot_crooked' =>$tot_crooked,
                'pleated' => $pleated,
                'tot_pleated' =>$tot_pleated,
                'ros' => $ros,
                'tot_ros' =>$tot_ros,
                'htl' => $htl,
                'tot_htl' =>$tot_htl,
                'button' => $button,
                'tot_button' =>$tot_button,
                'print' => $print,
                'tot_print' =>$tot_print,
                'bs' => $bs,
                'tot_bs' =>$tot_bs,
                'unb' => $unb,
                'tot_unb' =>$tot_unb,
                'shading' => $shading,
                'tot_shading' =>$tot_shading,
                'dof' => $dof,
                'tot_dof' =>$tot_dof,
                'dirty' => $dirty,
                'tot_dirty' =>$tot_dirty,
                'shiny' => $shiny,
                'tot_shiny' =>$tot_shiny,
                'sticker' => $sticker,
                'tot_sticker' =>$tot_sticker,
                'trimming' => $trimming,
                'tot_trimming' =>$tot_trimming,
                'ip' => $ip,
                'tot_ip' =>$tot_ip,
                'meas' => $meas,
                'tot_meas' =>$tot_meas,
                'other' => $other,
                'tot_other' =>$tot_other,
                'total_reject' => $total_reject,
                'p_total_reject' => $p_total_reject,
                'total_check' => $total_check
            ];

             // untuk detail line 
            $detailLine = [];
            foreach ($data as $key => $value) {
                foreach ($value->ltarget as $key2 => $value2) {
                    foreach ($value2->detail as $key3 => $value3) {
                        if ($value3->tgl_pengerjaan == $tanggal && $value3->id_line == $id ) {
                            $detailLine[] = [
                                'line' => $value->string1,
                                'no_wo' => $value2->no_wo,
                                'target_wo' => $value3->target_wo,
                                'terpenuhi' => $value3->target_terpenuhi,
                                'proses' => $value2->proses
                            ];
                        }
                    }
                }
            }
            // dd($detailLine);
            // end detail line 

            // UNTUK DETAIL REJECT PER LINE
            $masterline = [];
            foreach ($data as $key => $value) {
                foreach ($value->ltarget as $key2 => $value2) {
                    foreach ($value2->detail as $key3 => $value3) {
                        if($value3->tgl_pengerjaan == $tanggal) {
                            $jwo = LineDetail::where('tgl_pengerjaan', $tanggal)->where('id_line', $value->id)->count('no_wo');
                            $jterpenuhi = LineDetail::where('tgl_pengerjaan', $tanggal)->where('id_line', $value->id)->sum('target_terpenuhi');
                            $jreject = LineDetail::where('tgl_pengerjaan', $tanggal)->where('id_line', $value->id)->sum('total_reject');
                            if ($jterpenuhi == 0 || $jterpenuhi == null || $jreject == 0 || $jreject == null) {
                                $j_p_reject = 0;
                            }else{
                                $j_p_reject = round($jreject/$jterpenuhi*100,2);
                            }
                            $masterline[] = [
                                'id_line' => $value->id,
                                'line' => $value->string1,
                                'jumlah_wo' => $jwo,
                                'p_reject' => $j_p_reject,
                                'terpenuhi' => $jterpenuhi,
                                'jreject' => $jreject
                            ]; 
                        }
                    }
                }
            }
            // dd($masterline);
            $mline = collect($masterline)
                    ->groupBy('id_line')
                    ->map(function ($item) {
                        return array_merge(...$item->toArray());
                    })->values()->toArray();
            $jum_wo = collect($mline)->sum('jumlah_wo');
            // END
            return view('CommandCenter/lines', compact('tanggal', 'dataBranch', 'px_total_reject', 'totalSemuaLine', 'detailLine', 'mline','jum_wo', 'id_line'));
        }else{
            throw new \Exception('Data Kosong !');
        }
    }
}
