<?php

namespace App\Http\Controllers\Line;

use DB;
use File;
use App\LineDetail;
use App\LineToTarget;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AutoController extends Controller
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
    
    public function fg(Request $request, $id)
    {
        //Untuk Return Back 
        $target_id = $request->target_id;

        //data yang akan di olah 
        $target_terpenuhi = LineDetail::where('id', $id)->get()->sum('target_terpenuhi');
        $total_check = LineDetail::where('id', $id)->get()->sum('total_check');
        $total_reject = LineDetail::where('id', $id)->get()->sum('total_reject');
        $fg = LineDetail::where('id', $id)->get()->sum('fg');
        $broken = LineDetail::where('id', $id)->get()->sum('broken');
        $skip = LineDetail::where('id', $id)->get()->sum('skip');
        $pktw = LineDetail::where('id', $id)->get()->sum('pktw');
        $crooked = LineDetail::where('id', $id)->get()->sum('crooked');
        $pleated = LineDetail::where('id', $id)->get()->sum('pleated');
        $ros = LineDetail::where('id', $id)->get()->sum('ros');
        $htl = LineDetail::where('id', $id)->get()->sum('htl');
        $button = LineDetail::where('id', $id)->get()->sum('button');
        $print = LineDetail::where('id', $id)->get()->sum('print');
        $bs = LineDetail::where('id', $id)->get()->sum('bs');
        $unb = LineDetail::where('id', $id)->get()->sum('unb');
        $shading = LineDetail::where('id', $id)->get()->sum('shading');
        $dof = LineDetail::where('id', $id)->get()->sum('dof');
        $dirty = LineDetail::where('id', $id)->get()->sum('dirty');
        $shiny = LineDetail::where('id', $id)->get()->sum('shiny');
        $sticker = LineDetail::where('id', $id)->get()->sum('sticker');
        $trimming = LineDetail::where('id', $id)->get()->sum('trimming');
        $ip = LineDetail::where('id', $id)->get()->sum('ip');
        $meas = LineDetail::where('id', $id)->get()->sum('meas');
        $other = LineDetail::where('id', $id)->get()->sum('other');

        // untuk olah data 
        $loop = 1;
        $dataFG = $fg + $loop;
        $pembagi = $target_terpenuhi + $loop;
        $reject = round(($total_reject) / ($target_terpenuhi + $loop) *100,2);

        // data untuk persen 
        if ($target_terpenuhi == 0) {
            $p_fg = 100;
            $p_broken = 0;
            $p_skip = 0;
            $p_pktw = 0;
            $p_crooked = 0;
            $p_pleated= 0;
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
        }else{
            $p_fg = round($dataFG / $pembagi * 100,2);
            $p_broken = round($broken / $pembagi * 100,2);
            $p_skip = round($skip / $pembagi * 100,2);
            $p_pktw = round($pktw / $pembagi * 100,2);
            $p_crooked = round($crooked / $pembagi * 100,2);
            $p_pleated = round($pleated / $pembagi * 100,2);
            $p_ros = round($ros / $pembagi * 100,2);
            $p_htl = round($htl / $pembagi * 100,2);
            $p_button = round($button / $pembagi * 100,2);
            $p_print = round($print / $pembagi * 100,2);
            $p_bs = round($bs / $pembagi * 100,2);
            $p_unb = round($unb / $pembagi * 100,2);
            $p_shading = round($shading / $pembagi * 100,2);
            $p_dof = round($dof / $pembagi * 100,2);
            $p_dirty = round($dirty / $pembagi * 100,2);
            $p_shiny = round($shiny / $pembagi * 100,2);
            $p_sticker = round($sticker / $pembagi * 100,2);
            $p_trimming = round($trimming / $pembagi * 100,2);
            $p_ip = round($ip / $pembagi * 100,2);
            $p_meas = round($meas / $pembagi * 100,2);
            $p_other = round($other / $pembagi * 100,2);
        }

        //Update data FG di database
        $update = [
            'fg' => $dataFG,
            'p_fg' => $p_fg,
            'p_broken' => $p_broken,
            'p_skip' => $p_skip,
            'p_pktw' => $p_pktw,
            'p_crooked' => $p_crooked,
            'p_pleated' => $p_pleated,
            'p_ros' => $p_ros,
            'p_htl' => $p_htl,
            'p_button' => $p_button,
            'p_print' => $p_print,
            'p_bs' => $p_bs,
            'p_unb' => $p_unb,
            'p_shading' => $p_shading,
            'p_dof' => $p_dof,
            'p_dirty' => $p_dirty,
            'p_shiny' => $p_shiny,
            'p_sticker' => $p_sticker,
            'p_trimming' => $p_trimming,
            'p_ip' => $p_ip,
            'p_meas' => $p_meas,
            'p_other' => $p_other,
            'p_reject' => $reject,
            'total_check' => $total_check + $loop,
            'target_terpenuhi' => $target_terpenuhi + $loop
        ];
        LineDetail::whereId($id)->update($update);
        // end update 

        $kerjakan = LineToTarget::with('detail')->findOrFail($target_id);

        return redirect()->back()->with('kerjakan');
    }

    public function ip(Request $request, $id)
    {
        //Untuk Return Back 
        $target_id = $request->target_id;

        //data yang akan di olah 
        $target_terpenuhi = LineDetail::where('id', $id)->get()->sum('target_terpenuhi');
        $total_check = LineDetail::where('id', $id)->get()->sum('total_check');
        $total_reject = LineDetail::where('id', $id)->get()->sum('total_reject');
        $fg = LineDetail::where('id', $id)->get()->sum('fg');
        $broken = LineDetail::where('id', $id)->get()->sum('broken');
        $skip = LineDetail::where('id', $id)->get()->sum('skip');
        $pktw = LineDetail::where('id', $id)->get()->sum('pktw');
        $crooked = LineDetail::where('id', $id)->get()->sum('crooked');
        $pleated = LineDetail::where('id', $id)->get()->sum('pleated');
        $ros = LineDetail::where('id', $id)->get()->sum('ros');
        $htl = LineDetail::where('id', $id)->get()->sum('htl');
        $button = LineDetail::where('id', $id)->get()->sum('button');
        $print = LineDetail::where('id', $id)->get()->sum('print');
        $bs = LineDetail::where('id', $id)->get()->sum('bs');
        $unb = LineDetail::where('id', $id)->get()->sum('unb');
        $shading = LineDetail::where('id', $id)->get()->sum('shading');
        $dof = LineDetail::where('id', $id)->get()->sum('dof');
        $dirty = LineDetail::where('id', $id)->get()->sum('dirty');
        $shiny = LineDetail::where('id', $id)->get()->sum('shiny');
        $sticker = LineDetail::where('id', $id)->get()->sum('sticker');
        $trimming = LineDetail::where('id', $id)->get()->sum('trimming');
        $ip = LineDetail::where('id', $id)->get()->sum('ip');
        $meas = LineDetail::where('id', $id)->get()->sum('meas');
        $other = LineDetail::where('id', $id)->get()->sum('other');

        // untuk olah data 
        $loop = 1;
        $dataIP = $ip + $loop;
        $pembagi = $target_terpenuhi + $loop;
        $reject = round(($total_reject + $loop) / ($target_terpenuhi + $loop) *100,2);

        // data untuk persen 
        if ($target_terpenuhi == 0) {
            $p_fg = 0;
            $p_broken = 0;
            $p_skip = 0;
            $p_pktw = 0;
            $p_crooked = 0;
            $p_pleated= 0;
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
            $p_ip = 100;
            $p_meas = 0;
            $p_other = 0;
        }else{
            $p_fg = round($fg / $pembagi * 100,2);
            $p_broken = round($broken / $pembagi * 100,2);
            $p_skip = round($skip / $pembagi * 100,2);
            $p_pktw = round($pktw / $pembagi * 100,2);
            $p_crooked = round($crooked / $pembagi * 100,2);
            $p_pleated = round($pleated / $pembagi * 100,2);
            $p_ros = round($ros / $pembagi * 100,2);
            $p_htl = round($htl / $pembagi * 100,2);
            $p_button = round($button / $pembagi * 100,2);
            $p_print = round($print / $pembagi * 100,2);
            $p_bs = round($bs / $pembagi * 100,2);
            $p_unb = round($unb / $pembagi * 100,2);
            $p_shading = round($shading / $pembagi * 100,2);
            $p_dof = round($dof / $pembagi * 100,2);
            $p_dirty = round($dirty / $pembagi * 100,2);
            $p_shiny = round($shiny / $pembagi * 100,2);
            $p_sticker = round($sticker / $pembagi * 100,2);
            $p_trimming = round($trimming / $pembagi * 100,2);
            $p_ip = round($dataIP / $pembagi * 100,2);
            $p_meas = round($meas / $pembagi * 100,2);
            $p_other = round($other / $pembagi * 100,2);
        }

        //Update data FG di database
        $update = [
            'ip' => $dataIP,
            'p_fg' => $p_fg,
            'p_broken' => $p_broken,
            'p_skip' => $p_skip,
            'p_pktw' => $p_pktw,
            'p_crooked' => $p_crooked,
            'p_pleated' => $p_pleated,
            'p_ros' => $p_ros,
            'p_htl' => $p_htl,
            'p_button' => $p_button,
            'p_print' => $p_print,
            'p_bs' => $p_bs,
            'p_unb' => $p_unb,
            'p_shading' => $p_shading,
            'p_dof' => $p_dof,
            'p_dirty' => $p_dirty,
            'p_shiny' => $p_shiny,
            'p_sticker' => $p_sticker,
            'p_trimming' => $p_trimming,
            'p_ip' => $p_ip,
            'p_meas' => $p_meas,
            'p_other' => $p_other,
            'p_reject' => $reject,
            'total_check' => $total_check + $loop,
            'total_reject' => $total_reject + $loop,
            'target_terpenuhi' => $target_terpenuhi + $loop
        ];
        LineDetail::whereId($id)->update($update);
        // end update 

        $kerjakan = LineToTarget::with('detail')->findOrFail($target_id);

        return redirect()->back()->with('kerjakan');
    }

    public function sticker(Request $request, $id)
    {
       //Untuk Return Back 
       $target_id = $request->target_id;

       //data yang akan di olah 
       $target_terpenuhi = LineDetail::where('id', $id)->get()->sum('target_terpenuhi');
       $total_check = LineDetail::where('id', $id)->get()->sum('total_check');
       $total_reject = LineDetail::where('id', $id)->get()->sum('total_reject');
       $fg = LineDetail::where('id', $id)->get()->sum('fg');
       $broken = LineDetail::where('id', $id)->get()->sum('broken');
       $skip = LineDetail::where('id', $id)->get()->sum('skip');
       $pktw = LineDetail::where('id', $id)->get()->sum('pktw');
       $crooked = LineDetail::where('id', $id)->get()->sum('crooked');
       $pleated = LineDetail::where('id', $id)->get()->sum('pleated');
       $ros = LineDetail::where('id', $id)->get()->sum('ros');
       $htl = LineDetail::where('id', $id)->get()->sum('htl');
       $button = LineDetail::where('id', $id)->get()->sum('button');
       $print = LineDetail::where('id', $id)->get()->sum('print');
       $bs = LineDetail::where('id', $id)->get()->sum('bs');
       $unb = LineDetail::where('id', $id)->get()->sum('unb');
       $shading = LineDetail::where('id', $id)->get()->sum('shading');
       $dof = LineDetail::where('id', $id)->get()->sum('dof');
       $dirty = LineDetail::where('id', $id)->get()->sum('dirty');
       $shiny = LineDetail::where('id', $id)->get()->sum('shiny');
       $sticker = LineDetail::where('id', $id)->get()->sum('sticker');
       $trimming = LineDetail::where('id', $id)->get()->sum('trimming');
       $ip = LineDetail::where('id', $id)->get()->sum('ip');
       $meas = LineDetail::where('id', $id)->get()->sum('meas');
       $other = LineDetail::where('id', $id)->get()->sum('other');

       // untuk olah data 
       $loop = 1;
       $dataSticker = $sticker + $loop;
       $pembagi = $target_terpenuhi + $loop;
       $reject = round(($total_reject + $loop) / ($target_terpenuhi + $loop) *100,2);

       // data untuk persen 
       if ($target_terpenuhi == 0) {
           $p_fg = 0;
           $p_broken = 0;
           $p_skip = 0;
           $p_pktw = 0;
           $p_crooked = 0;
           $p_pleated= 0;
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
           $p_sticker = 100;
           $p_trimming = 0;
           $p_ip = 0;
           $p_meas = 0;
           $p_other = 0;
       }else{
           $p_fg = round($fg / $pembagi * 100,2);
           $p_broken = round($broken / $pembagi * 100,2);
           $p_skip = round($skip / $pembagi * 100,2);
           $p_pktw = round($pktw / $pembagi * 100,2);
           $p_crooked = round($crooked / $pembagi * 100,2);
           $p_pleated = round($pleated / $pembagi * 100,2);
           $p_ros = round($ros / $pembagi * 100,2);
           $p_htl = round($htl / $pembagi * 100,2);
           $p_button = round($button / $pembagi * 100,2);
           $p_print = round($print / $pembagi * 100,2);
           $p_bs = round($bs / $pembagi * 100,2);
           $p_unb = round($unb / $pembagi * 100,2);
           $p_shading = round($shading / $pembagi * 100,2);
           $p_dof = round($dof / $pembagi * 100,2);
           $p_dirty = round($dirty / $pembagi * 100,2);
           $p_shiny = round($shiny / $pembagi * 100,2);
           $p_sticker = round($dataSticker / $pembagi * 100,2);
           $p_trimming = round($trimming / $pembagi * 100,2);
           $p_ip = round($ip / $pembagi * 100,2);
           $p_meas = round($meas / $pembagi * 100,2);
           $p_other = round($other / $pembagi * 100,2);
       }

       //Update data FG di database
       $update = [
           'sticker' => $dataSticker,
           'p_fg' => $p_fg,
           'p_broken' => $p_broken,
           'p_skip' => $p_skip,
           'p_pktw' => $p_pktw,
           'p_crooked' => $p_crooked,
           'p_pleated' => $p_pleated,
           'p_ros' => $p_ros,
           'p_htl' => $p_htl,
           'p_button' => $p_button,
           'p_print' => $p_print,
           'p_bs' => $p_bs,
           'p_unb' => $p_unb,
           'p_shading' => $p_shading,
           'p_dof' => $p_dof,
           'p_dirty' => $p_dirty,
           'p_shiny' => $p_shiny,
           'p_sticker' => $p_sticker,
           'p_trimming' => $p_trimming,
           'p_ip' => $p_ip,
           'p_meas' => $p_meas,
           'p_other' => $p_other,
           'p_reject' => $reject,
           'total_check' => $total_check + $loop,
           'total_reject' => $total_reject + $loop,
           'target_terpenuhi' => $target_terpenuhi + $loop
       ];
       LineDetail::whereId($id)->update($update);
       // end update 

       $kerjakan = LineToTarget::with('detail')->findOrFail($target_id);

       return redirect()->back()->with('kerjakan');
    }

    public function trimming(Request $request, $id)
    {
       //Untuk Return Back 
       $target_id = $request->target_id;

       //data yang akan di olah 
       $target_terpenuhi = LineDetail::where('id', $id)->get()->sum('target_terpenuhi');
       $total_check = LineDetail::where('id', $id)->get()->sum('total_check');
       $total_reject = LineDetail::where('id', $id)->get()->sum('total_reject');
       $fg = LineDetail::where('id', $id)->get()->sum('fg');
       $broken = LineDetail::where('id', $id)->get()->sum('broken');
       $skip = LineDetail::where('id', $id)->get()->sum('skip');
       $pktw = LineDetail::where('id', $id)->get()->sum('pktw');
       $crooked = LineDetail::where('id', $id)->get()->sum('crooked');
       $pleated = LineDetail::where('id', $id)->get()->sum('pleated');
       $ros = LineDetail::where('id', $id)->get()->sum('ros');
       $htl = LineDetail::where('id', $id)->get()->sum('htl');
       $button = LineDetail::where('id', $id)->get()->sum('button');
       $print = LineDetail::where('id', $id)->get()->sum('print');
       $bs = LineDetail::where('id', $id)->get()->sum('bs');
       $unb = LineDetail::where('id', $id)->get()->sum('unb');
       $shading = LineDetail::where('id', $id)->get()->sum('shading');
       $dof = LineDetail::where('id', $id)->get()->sum('dof');
       $dirty = LineDetail::where('id', $id)->get()->sum('dirty');
       $shiny = LineDetail::where('id', $id)->get()->sum('shiny');
       $sticker = LineDetail::where('id', $id)->get()->sum('sticker');
       $trimming = LineDetail::where('id', $id)->get()->sum('trimming');
       $ip = LineDetail::where('id', $id)->get()->sum('ip');
       $meas = LineDetail::where('id', $id)->get()->sum('meas');
       $other = LineDetail::where('id', $id)->get()->sum('other');

       // untuk olah data 
       $loop = 1;
       $dataTrimming = $trimming + $loop;
       $pembagi = $target_terpenuhi + $loop;
       $reject = round(($total_reject + $loop) / ($target_terpenuhi + $loop) *100,2);

       // data untuk persen 
       if ($target_terpenuhi == 0) {
           $p_fg = 0;
           $p_broken = 0;
           $p_skip = 0;
           $p_pktw = 0;
           $p_crooked = 0;
           $p_pleated= 0;
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
           $p_trimming = 100;
           $p_ip = 0;
           $p_meas = 0;
           $p_other = 0;
       }else{
           $p_fg = round($fg / $pembagi * 100,2);
           $p_broken = round($broken / $pembagi * 100,2);
           $p_skip = round($skip / $pembagi * 100,2);
           $p_pktw = round($pktw / $pembagi * 100,2);
           $p_crooked = round($crooked / $pembagi * 100,2);
           $p_pleated = round($pleated / $pembagi * 100,2);
           $p_ros = round($ros / $pembagi * 100,2);
           $p_htl = round($htl / $pembagi * 100,2);
           $p_button = round($button / $pembagi * 100,2);
           $p_print = round($print / $pembagi * 100,2);
           $p_bs = round($bs / $pembagi * 100,2);
           $p_unb = round($unb / $pembagi * 100,2);
           $p_shading = round($shading / $pembagi * 100,2);
           $p_dof = round($dof / $pembagi * 100,2);
           $p_dirty = round($dirty / $pembagi * 100,2);
           $p_shiny = round($shiny / $pembagi * 100,2);
           $p_sticker = round($sticker / $pembagi * 100,2);
           $p_trimming = round($dataTrimming / $pembagi * 100,2);
           $p_ip = round($ip / $pembagi * 100,2);
           $p_meas = round($meas / $pembagi * 100,2);
           $p_other = round($other / $pembagi * 100,2);
       }

       //Update data FG di database
       $update = [
           'trimming' => $dataTrimming,
           'p_fg' => $p_fg,
           'p_broken' => $p_broken,
           'p_skip' => $p_skip,
           'p_pktw' => $p_pktw,
           'p_crooked' => $p_crooked,
           'p_pleated' => $p_pleated,
           'p_ros' => $p_ros,
           'p_htl' => $p_htl,
           'p_button' => $p_button,
           'p_print' => $p_print,
           'p_bs' => $p_bs,
           'p_unb' => $p_unb,
           'p_shading' => $p_shading,
           'p_dof' => $p_dof,
           'p_dirty' => $p_dirty,
           'p_shiny' => $p_shiny,
           'p_sticker' => $p_sticker,
           'p_trimming' => $p_trimming,
           'p_ip' => $p_ip,
           'p_meas' => $p_meas,
           'p_other' => $p_other,
           'p_reject' => $reject,
           'total_check' => $total_check + $loop,
           'total_reject' => $total_reject + $loop,
           'target_terpenuhi' => $target_terpenuhi + $loop
       ];
       LineDetail::whereId($id)->update($update);
       // end update 

       $kerjakan = LineToTarget::with('detail')->findOrFail($target_id);

       return redirect()->back()->with('kerjakan');
    }

    public function other(Request $request, $id)
    {
        //Untuk Return Back 
       $target_id = $request->target_id;

       //data yang akan di olah 
       $target_terpenuhi = LineDetail::where('id', $id)->get()->sum('target_terpenuhi');
       $total_check = LineDetail::where('id', $id)->get()->sum('total_check');
       $total_reject = LineDetail::where('id', $id)->get()->sum('total_reject');
       $fg = LineDetail::where('id', $id)->get()->sum('fg');
       $broken = LineDetail::where('id', $id)->get()->sum('broken');
       $skip = LineDetail::where('id', $id)->get()->sum('skip');
       $pktw = LineDetail::where('id', $id)->get()->sum('pktw');
       $crooked = LineDetail::where('id', $id)->get()->sum('crooked');
       $pleated = LineDetail::where('id', $id)->get()->sum('pleated');
       $ros = LineDetail::where('id', $id)->get()->sum('ros');
       $htl = LineDetail::where('id', $id)->get()->sum('htl');
       $button = LineDetail::where('id', $id)->get()->sum('button');
       $print = LineDetail::where('id', $id)->get()->sum('print');
       $bs = LineDetail::where('id', $id)->get()->sum('bs');
       $unb = LineDetail::where('id', $id)->get()->sum('unb');
       $shading = LineDetail::where('id', $id)->get()->sum('shading');
       $dof = LineDetail::where('id', $id)->get()->sum('dof');
       $dirty = LineDetail::where('id', $id)->get()->sum('dirty');
       $shiny = LineDetail::where('id', $id)->get()->sum('shiny');
       $sticker = LineDetail::where('id', $id)->get()->sum('sticker');
       $trimming = LineDetail::where('id', $id)->get()->sum('trimming');
       $ip = LineDetail::where('id', $id)->get()->sum('ip');
       $meas = LineDetail::where('id', $id)->get()->sum('meas');
       $other = LineDetail::where('id', $id)->get()->sum('other');

       // untuk olah data 
       $loop = 1;
       $dataOther = $other + $loop;
       $pembagi = $target_terpenuhi + $loop;
       $reject = round(($total_reject + $loop) / ($target_terpenuhi + $loop) *100,2);

       // data untuk persen 
       if ($target_terpenuhi == 0) {
           $p_fg = 0;
           $p_broken = 0;
           $p_skip = 0;
           $p_pktw = 0;
           $p_crooked = 0;
           $p_pleated= 0;
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
           $p_other = 100;
       }else{
           $p_fg = round($fg / $pembagi * 100,2);
           $p_broken = round($broken / $pembagi * 100,2);
           $p_skip = round($skip / $pembagi * 100,2);
           $p_pktw = round($pktw / $pembagi * 100,2);
           $p_crooked = round($crooked / $pembagi * 100,2);
           $p_pleated = round($pleated / $pembagi * 100,2);
           $p_ros = round($ros / $pembagi * 100,2);
           $p_htl = round($htl / $pembagi * 100,2);
           $p_button = round($button / $pembagi * 100,2);
           $p_print = round($print / $pembagi * 100,2);
           $p_bs = round($bs / $pembagi * 100,2);
           $p_unb = round($unb / $pembagi * 100,2);
           $p_shading = round($shading / $pembagi * 100,2);
           $p_dof = round($dof / $pembagi * 100,2);
           $p_dirty = round($dirty / $pembagi * 100,2);
           $p_shiny = round($shiny / $pembagi * 100,2);
           $p_sticker = round($sticker / $pembagi * 100,2);
           $p_trimming = round($trimming / $pembagi * 100,2);
           $p_ip = round($ip / $pembagi * 100,2);
           $p_meas = round($meas / $pembagi * 100,2);
           $p_other = round($dataOther / $pembagi * 100,2);
       }

       //Update data FG di database
       $update = [
           'other' => $dataOther,
           'p_fg' => $p_fg,
           'p_broken' => $p_broken,
           'p_skip' => $p_skip,
           'p_pktw' => $p_pktw,
           'p_crooked' => $p_crooked,
           'p_pleated' => $p_pleated,
           'p_ros' => $p_ros,
           'p_htl' => $p_htl,
           'p_button' => $p_button,
           'p_print' => $p_print,
           'p_bs' => $p_bs,
           'p_unb' => $p_unb,
           'p_shading' => $p_shading,
           'p_dof' => $p_dof,
           'p_dirty' => $p_dirty,
           'p_shiny' => $p_shiny,
           'p_sticker' => $p_sticker,
           'p_trimming' => $p_trimming,
           'p_ip' => $p_ip,
           'p_meas' => $p_meas,
           'p_other' => $p_other,
           'p_reject' => $reject,
           'total_check' => $total_check + $loop,
           'total_reject' => $total_reject + $loop,
           'target_terpenuhi' => $target_terpenuhi + $loop
       ];
       LineDetail::whereId($id)->update($update);
       // end update 

       $kerjakan = LineToTarget::with('detail')->findOrFail($target_id);

       return redirect()->back()->with('kerjakan');
    }

    public function ros(Request $request, $id)
    {
         //Untuk Return Back 
       $target_id = $request->target_id;

       //data yang akan di olah 
       $target_terpenuhi = LineDetail::where('id', $id)->get()->sum('target_terpenuhi');
       $total_check = LineDetail::where('id', $id)->get()->sum('total_check');
       $total_reject = LineDetail::where('id', $id)->get()->sum('total_reject');
       $fg = LineDetail::where('id', $id)->get()->sum('fg');
       $broken = LineDetail::where('id', $id)->get()->sum('broken');
       $skip = LineDetail::where('id', $id)->get()->sum('skip');
       $pktw = LineDetail::where('id', $id)->get()->sum('pktw');
       $crooked = LineDetail::where('id', $id)->get()->sum('crooked');
       $pleated = LineDetail::where('id', $id)->get()->sum('pleated');
       $ros = LineDetail::where('id', $id)->get()->sum('ros');
       $htl = LineDetail::where('id', $id)->get()->sum('htl');
       $button = LineDetail::where('id', $id)->get()->sum('button');
       $print = LineDetail::where('id', $id)->get()->sum('print');
       $bs = LineDetail::where('id', $id)->get()->sum('bs');
       $unb = LineDetail::where('id', $id)->get()->sum('unb');
       $shading = LineDetail::where('id', $id)->get()->sum('shading');
       $dof = LineDetail::where('id', $id)->get()->sum('dof');
       $dirty = LineDetail::where('id', $id)->get()->sum('dirty');
       $shiny = LineDetail::where('id', $id)->get()->sum('shiny');
       $sticker = LineDetail::where('id', $id)->get()->sum('sticker');
       $trimming = LineDetail::where('id', $id)->get()->sum('trimming');
       $ip = LineDetail::where('id', $id)->get()->sum('ip');
       $meas = LineDetail::where('id', $id)->get()->sum('meas');
       $other = LineDetail::where('id', $id)->get()->sum('other');

       // untuk olah data 
       $loop = 1;
       $dataROS = $ros + $loop;
       $pembagi = $target_terpenuhi + $loop;
       $reject = round(($total_reject + $loop) / ($target_terpenuhi + $loop) *100,2);

       // data untuk persen 
       if ($target_terpenuhi == 0) {
           $p_fg = 0;
           $p_broken = 0;
           $p_skip = 0;
           $p_pktw = 0;
           $p_crooked = 0;
           $p_pleated= 0;
           $p_ros = 100;
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
       }else{
           $p_fg = round($fg / $pembagi * 100,2);
           $p_broken = round($broken / $pembagi * 100,2);
           $p_skip = round($skip / $pembagi * 100,2);
           $p_pktw = round($pktw / $pembagi * 100,2);
           $p_crooked = round($crooked / $pembagi * 100,2);
           $p_pleated = round($pleated / $pembagi * 100,2);
           $p_ros = round($dataROS / $pembagi * 100,2);
           $p_htl = round($htl / $pembagi * 100,2);
           $p_button = round($button / $pembagi * 100,2);
           $p_print = round($print / $pembagi * 100,2);
           $p_bs = round($bs / $pembagi * 100,2);
           $p_unb = round($unb / $pembagi * 100,2);
           $p_shading = round($shading / $pembagi * 100,2);
           $p_dof = round($dof / $pembagi * 100,2);
           $p_dirty = round($dirty / $pembagi * 100,2);
           $p_shiny = round($shiny / $pembagi * 100,2);
           $p_sticker = round($sticker / $pembagi * 100,2);
           $p_trimming = round($trimming / $pembagi * 100,2);
           $p_ip = round($ip / $pembagi * 100,2);
           $p_meas = round($meas / $pembagi * 100,2);
           $p_other = round($other / $pembagi * 100,2);
       }

       //Update data FG di database
       $update = [
           'ros' => $dataROS,
           'p_fg' => $p_fg,
           'p_broken' => $p_broken,
           'p_skip' => $p_skip,
           'p_pktw' => $p_pktw,
           'p_crooked' => $p_crooked,
           'p_pleated' => $p_pleated,
           'p_ros' => $p_ros,
           'p_htl' => $p_htl,
           'p_button' => $p_button,
           'p_print' => $p_print,
           'p_bs' => $p_bs,
           'p_unb' => $p_unb,
           'p_shading' => $p_shading,
           'p_dof' => $p_dof,
           'p_dirty' => $p_dirty,
           'p_shiny' => $p_shiny,
           'p_sticker' => $p_sticker,
           'p_trimming' => $p_trimming,
           'p_ip' => $p_ip,
           'p_meas' => $p_meas,
           'p_other' => $p_other,
           'p_reject' => $reject,
           'total_check' => $total_check + $loop,
           'total_reject' => $total_reject + $loop,
           'target_terpenuhi' => $target_terpenuhi + $loop
       ];
       LineDetail::whereId($id)->update($update);
       // end update 

       $kerjakan = LineToTarget::with('detail')->findOrFail($target_id);

       return redirect()->back()->with('kerjakan');
    }

    public function broken(Request $request, $id)
    {
         //Untuk Return Back 
       $target_id = $request->target_id;

       //data yang akan di olah 
       $target_terpenuhi = LineDetail::where('id', $id)->get()->sum('target_terpenuhi');
       $total_check = LineDetail::where('id', $id)->get()->sum('total_check');
       $total_reject = LineDetail::where('id', $id)->get()->sum('total_reject');
       $fg = LineDetail::where('id', $id)->get()->sum('fg');
       $broken = LineDetail::where('id', $id)->get()->sum('broken');
       $skip = LineDetail::where('id', $id)->get()->sum('skip');
       $pktw = LineDetail::where('id', $id)->get()->sum('pktw');
       $crooked = LineDetail::where('id', $id)->get()->sum('crooked');
       $pleated = LineDetail::where('id', $id)->get()->sum('pleated');
       $ros = LineDetail::where('id', $id)->get()->sum('ros');
       $htl = LineDetail::where('id', $id)->get()->sum('htl');
       $button = LineDetail::where('id', $id)->get()->sum('button');
       $print = LineDetail::where('id', $id)->get()->sum('print');
       $bs = LineDetail::where('id', $id)->get()->sum('bs');
       $unb = LineDetail::where('id', $id)->get()->sum('unb');
       $shading = LineDetail::where('id', $id)->get()->sum('shading');
       $dof = LineDetail::where('id', $id)->get()->sum('dof');
       $dirty = LineDetail::where('id', $id)->get()->sum('dirty');
       $shiny = LineDetail::where('id', $id)->get()->sum('shiny');
       $sticker = LineDetail::where('id', $id)->get()->sum('sticker');
       $trimming = LineDetail::where('id', $id)->get()->sum('trimming');
       $ip = LineDetail::where('id', $id)->get()->sum('ip');
       $meas = LineDetail::where('id', $id)->get()->sum('meas');
       $other = LineDetail::where('id', $id)->get()->sum('other');

       // untuk olah data 
       $loop = 1;
       $dataBroken = $broken + $loop;
       $pembagi = $target_terpenuhi + $loop;
       $reject = round(($total_reject + $loop) / ($target_terpenuhi + $loop) *100,2);

       // data untuk persen 
       if ($target_terpenuhi == 0) {
           $p_fg = 0;
           $p_broken = 100;
           $p_skip = 0;
           $p_pktw = 0;
           $p_crooked = 0;
           $p_pleated= 0;
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
       }else{
           $p_fg = round($fg / $pembagi * 100,2);
           $p_broken = round($dataBroken / $pembagi * 100,2);
           $p_skip = round($skip / $pembagi * 100,2);
           $p_pktw = round($pktw / $pembagi * 100,2);
           $p_crooked = round($crooked / $pembagi * 100,2);
           $p_pleated = round($pleated / $pembagi * 100,2);
           $p_ros = round($ros / $pembagi * 100,2);
           $p_htl = round($htl / $pembagi * 100,2);
           $p_button = round($button / $pembagi * 100,2);
           $p_print = round($print / $pembagi * 100,2);
           $p_bs = round($bs / $pembagi * 100,2);
           $p_unb = round($unb / $pembagi * 100,2);
           $p_shading = round($shading / $pembagi * 100,2);
           $p_dof = round($dof / $pembagi * 100,2);
           $p_dirty = round($dirty / $pembagi * 100,2);
           $p_shiny = round($shiny / $pembagi * 100,2);
           $p_sticker = round($sticker / $pembagi * 100,2);
           $p_trimming = round($trimming / $pembagi * 100,2);
           $p_ip = round($ip / $pembagi * 100,2);
           $p_meas = round($meas / $pembagi * 100,2);
           $p_other = round($other / $pembagi * 100,2);
       }

       //Update data FG di database
       $update = [
           'broken' => $dataBroken,
           'p_fg' => $p_fg,
           'p_broken' => $p_broken,
           'p_skip' => $p_skip,
           'p_pktw' => $p_pktw,
           'p_crooked' => $p_crooked,
           'p_pleated' => $p_pleated,
           'p_ros' => $p_ros,
           'p_htl' => $p_htl,
           'p_button' => $p_button,
           'p_print' => $p_print,
           'p_bs' => $p_bs,
           'p_unb' => $p_unb,
           'p_shading' => $p_shading,
           'p_dof' => $p_dof,
           'p_dirty' => $p_dirty,
           'p_shiny' => $p_shiny,
           'p_sticker' => $p_sticker,
           'p_trimming' => $p_trimming,
           'p_ip' => $p_ip,
           'p_meas' => $p_meas,
           'p_other' => $p_other,
           'p_reject' => $reject,
           'total_check' => $total_check + $loop,
           'total_reject' => $total_reject + $loop,
           'target_terpenuhi' => $target_terpenuhi + $loop
       ];
       LineDetail::whereId($id)->update($update);
       // end update 

       $kerjakan = LineToTarget::with('detail')->findOrFail($target_id);

       return redirect()->back()->with('kerjakan');
    }

    public function skip(Request $request, $id)
    {
        //Untuk Return Back 
        $target_id = $request->target_id;

        //data yang akan di olah 
        $target_terpenuhi = LineDetail::where('id', $id)->get()->sum('target_terpenuhi');
        $total_check = LineDetail::where('id', $id)->get()->sum('total_check');
        $total_reject = LineDetail::where('id', $id)->get()->sum('total_reject');
        $fg = LineDetail::where('id', $id)->get()->sum('fg');
        $broken = LineDetail::where('id', $id)->get()->sum('broken');
        $skip = LineDetail::where('id', $id)->get()->sum('skip');
        $pktw = LineDetail::where('id', $id)->get()->sum('pktw');
        $crooked = LineDetail::where('id', $id)->get()->sum('crooked');
        $pleated = LineDetail::where('id', $id)->get()->sum('pleated');
        $ros = LineDetail::where('id', $id)->get()->sum('ros');
        $htl = LineDetail::where('id', $id)->get()->sum('htl');
        $button = LineDetail::where('id', $id)->get()->sum('button');
        $print = LineDetail::where('id', $id)->get()->sum('print');
        $bs = LineDetail::where('id', $id)->get()->sum('bs');
        $unb = LineDetail::where('id', $id)->get()->sum('unb');
        $shading = LineDetail::where('id', $id)->get()->sum('shading');
        $dof = LineDetail::where('id', $id)->get()->sum('dof');
        $dirty = LineDetail::where('id', $id)->get()->sum('dirty');
        $shiny = LineDetail::where('id', $id)->get()->sum('shiny');
        $sticker = LineDetail::where('id', $id)->get()->sum('sticker');
        $trimming = LineDetail::where('id', $id)->get()->sum('trimming');
        $ip = LineDetail::where('id', $id)->get()->sum('ip');
        $meas = LineDetail::where('id', $id)->get()->sum('meas');
        $other = LineDetail::where('id', $id)->get()->sum('other');
 
        // untuk olah data 
        $loop = 1;
        $dataSkip = $skip + $loop;
        $pembagi = $target_terpenuhi + $loop;
        $reject = round(($total_reject + $loop) / ($target_terpenuhi + $loop) *100,2);
 
        // data untuk persen 
        if ($target_terpenuhi == 0) {
            $p_fg = 0;
            $p_broken = 0;
            $p_skip = 100;
            $p_pktw = 0;
            $p_crooked = 0;
            $p_pleated= 0;
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
        }else{
            $p_fg = round($fg / $pembagi * 100,2);
            $p_broken = round($broken / $pembagi * 100,2);
            $p_skip = round($dataSkip / $pembagi * 100,2);
            $p_pktw = round($pktw / $pembagi * 100,2);
            $p_crooked = round($crooked / $pembagi * 100,2);
            $p_pleated = round($pleated / $pembagi * 100,2);
            $p_ros = round($ros / $pembagi * 100,2);
            $p_htl = round($htl / $pembagi * 100,2);
            $p_button = round($button / $pembagi * 100,2);
            $p_print = round($print / $pembagi * 100,2);
            $p_bs = round($bs / $pembagi * 100,2);
            $p_unb = round($unb / $pembagi * 100,2);
            $p_shading = round($shading / $pembagi * 100,2);
            $p_dof = round($dof / $pembagi * 100,2);
            $p_dirty = round($dirty / $pembagi * 100,2);
            $p_shiny = round($shiny / $pembagi * 100,2);
            $p_sticker = round($sticker / $pembagi * 100,2);
            $p_trimming = round($trimming / $pembagi * 100,2);
            $p_ip = round($ip / $pembagi * 100,2);
            $p_meas = round($meas / $pembagi * 100,2);
            $p_other = round($other / $pembagi * 100,2);
        }
 
        //Update data FG di database
        $update = [
            'skip' => $dataSkip,
            'p_fg' => $p_fg,
            'p_broken' => $p_broken,
            'p_skip' => $p_skip,
            'p_pktw' => $p_pktw,
            'p_crooked' => $p_crooked,
            'p_pleated' => $p_pleated,
            'p_ros' => $p_ros,
            'p_htl' => $p_htl,
            'p_button' => $p_button,
            'p_print' => $p_print,
            'p_bs' => $p_bs,
            'p_unb' => $p_unb,
            'p_shading' => $p_shading,
            'p_dof' => $p_dof,
            'p_dirty' => $p_dirty,
            'p_shiny' => $p_shiny,
            'p_sticker' => $p_sticker,
            'p_trimming' => $p_trimming,
            'p_ip' => $p_ip,
            'p_meas' => $p_meas,
            'p_other' => $p_other,
            'p_reject' => $reject,
            'total_check' => $total_check + $loop,
            'total_reject' => $total_reject + $loop,
            'target_terpenuhi' => $target_terpenuhi + $loop
        ];
        LineDetail::whereId($id)->update($update);
        // end update 
 
        $kerjakan = LineToTarget::with('detail')->findOrFail($target_id);
 
        return redirect()->back()->with('kerjakan');
    }

    public function pktw(Request $request, $id)
    {
         //Untuk Return Back 
       $target_id = $request->target_id;

       //data yang akan di olah 
       $target_terpenuhi = LineDetail::where('id', $id)->get()->sum('target_terpenuhi');
       $total_check = LineDetail::where('id', $id)->get()->sum('total_check');
       $total_reject = LineDetail::where('id', $id)->get()->sum('total_reject');
       $fg = LineDetail::where('id', $id)->get()->sum('fg');
       $broken = LineDetail::where('id', $id)->get()->sum('broken');
       $skip = LineDetail::where('id', $id)->get()->sum('skip');
       $pktw = LineDetail::where('id', $id)->get()->sum('pktw');
       $crooked = LineDetail::where('id', $id)->get()->sum('crooked');
       $pleated = LineDetail::where('id', $id)->get()->sum('pleated');
       $ros = LineDetail::where('id', $id)->get()->sum('ros');
       $htl = LineDetail::where('id', $id)->get()->sum('htl');
       $button = LineDetail::where('id', $id)->get()->sum('button');
       $print = LineDetail::where('id', $id)->get()->sum('print');
       $bs = LineDetail::where('id', $id)->get()->sum('bs');
       $unb = LineDetail::where('id', $id)->get()->sum('unb');
       $shading = LineDetail::where('id', $id)->get()->sum('shading');
       $dof = LineDetail::where('id', $id)->get()->sum('dof');
       $dirty = LineDetail::where('id', $id)->get()->sum('dirty');
       $shiny = LineDetail::where('id', $id)->get()->sum('shiny');
       $sticker = LineDetail::where('id', $id)->get()->sum('sticker');
       $trimming = LineDetail::where('id', $id)->get()->sum('trimming');
       $ip = LineDetail::where('id', $id)->get()->sum('ip');
       $meas = LineDetail::where('id', $id)->get()->sum('meas');
       $other = LineDetail::where('id', $id)->get()->sum('other');

       // untuk olah data 
       $loop = 1;
       $dataPKTW = $pktw + $loop;
       $pembagi = $target_terpenuhi + $loop;
       $reject = round(($total_reject + $loop) / ($target_terpenuhi + $loop) *100,2);

       // data untuk persen 
       if ($target_terpenuhi == 0) {
           $p_fg = 0;
           $p_broken = 0;
           $p_skip = 0;
           $p_pktw = 100;
           $p_crooked = 0;
           $p_pleated= 0;
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
       }else{
           $p_fg = round($fg / $pembagi * 100,2);
           $p_broken = round($broken / $pembagi * 100,2);
           $p_skip = round($skip / $pembagi * 100,2);
           $p_pktw = round($dataPKTW / $pembagi * 100,2);
           $p_crooked = round($crooked / $pembagi * 100,2);
           $p_pleated = round($pleated / $pembagi * 100,2);
           $p_ros = round($ros / $pembagi * 100,2);
           $p_htl = round($htl / $pembagi * 100,2);
           $p_button = round($button / $pembagi * 100,2);
           $p_print = round($print / $pembagi * 100,2);
           $p_bs = round($bs / $pembagi * 100,2);
           $p_unb = round($unb / $pembagi * 100,2);
           $p_shading = round($shading / $pembagi * 100,2);
           $p_dof = round($dof / $pembagi * 100,2);
           $p_dirty = round($dirty / $pembagi * 100,2);
           $p_shiny = round($shiny / $pembagi * 100,2);
           $p_sticker = round($sticker / $pembagi * 100,2);
           $p_trimming = round($trimming / $pembagi * 100,2);
           $p_ip = round($ip / $pembagi * 100,2);
           $p_meas = round($meas / $pembagi * 100,2);
           $p_other = round($other / $pembagi * 100,2);
       }

       //Update data FG di database
       $update = [
           'pktw' => $dataPKTW,
           'p_fg' => $p_fg,
           'p_broken' => $p_broken,
           'p_skip' => $p_skip,
           'p_pktw' => $p_pktw,
           'p_crooked' => $p_crooked,
           'p_pleated' => $p_pleated,
           'p_ros' => $p_ros,
           'p_htl' => $p_htl,
           'p_button' => $p_button,
           'p_print' => $p_print,
           'p_bs' => $p_bs,
           'p_unb' => $p_unb,
           'p_shading' => $p_shading,
           'p_dof' => $p_dof,
           'p_dirty' => $p_dirty,
           'p_shiny' => $p_shiny,
           'p_sticker' => $p_sticker,
           'p_trimming' => $p_trimming,
           'p_ip' => $p_ip,
           'p_meas' => $p_meas,
           'p_other' => $p_other,
           'p_reject' => $reject,
           'total_check' => $total_check + $loop,
           'total_reject' => $total_reject + $loop,
           'target_terpenuhi' => $target_terpenuhi + $loop
       ];
       LineDetail::whereId($id)->update($update);
       // end update 

       $kerjakan = LineToTarget::with('detail')->findOrFail($target_id);

       return redirect()->back()->with('kerjakan');
    }

    public function crooked(Request $request, $id)
    {
         //Untuk Return Back 
       $target_id = $request->target_id;

       //data yang akan di olah 
       $target_terpenuhi = LineDetail::where('id', $id)->get()->sum('target_terpenuhi');
       $total_check = LineDetail::where('id', $id)->get()->sum('total_check');
       $total_reject = LineDetail::where('id', $id)->get()->sum('total_reject');
       $fg = LineDetail::where('id', $id)->get()->sum('fg');
       $broken = LineDetail::where('id', $id)->get()->sum('broken');
       $skip = LineDetail::where('id', $id)->get()->sum('skip');
       $pktw = LineDetail::where('id', $id)->get()->sum('pktw');
       $crooked = LineDetail::where('id', $id)->get()->sum('crooked');
       $pleated = LineDetail::where('id', $id)->get()->sum('pleated');
       $ros = LineDetail::where('id', $id)->get()->sum('ros');
       $htl = LineDetail::where('id', $id)->get()->sum('htl');
       $button = LineDetail::where('id', $id)->get()->sum('button');
       $print = LineDetail::where('id', $id)->get()->sum('print');
       $bs = LineDetail::where('id', $id)->get()->sum('bs');
       $unb = LineDetail::where('id', $id)->get()->sum('unb');
       $shading = LineDetail::where('id', $id)->get()->sum('shading');
       $dof = LineDetail::where('id', $id)->get()->sum('dof');
       $dirty = LineDetail::where('id', $id)->get()->sum('dirty');
       $shiny = LineDetail::where('id', $id)->get()->sum('shiny');
       $sticker = LineDetail::where('id', $id)->get()->sum('sticker');
       $trimming = LineDetail::where('id', $id)->get()->sum('trimming');
       $ip = LineDetail::where('id', $id)->get()->sum('ip');
       $meas = LineDetail::where('id', $id)->get()->sum('meas');
       $other = LineDetail::where('id', $id)->get()->sum('other');

       // untuk olah data 
       $loop = 1;
       $dataCrooked = $crooked + $loop;
       $pembagi = $target_terpenuhi + $loop;
       $reject = round(($total_reject + $loop) / ($target_terpenuhi + $loop) *100,2);

       // data untuk persen 
       if ($target_terpenuhi == 0) {
           $p_fg = 0;
           $p_broken = 0;
           $p_skip = 0;
           $p_pktw = 0;
           $p_crooked = 100;
           $p_pleated= 0;
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
       }else{
           $p_fg = round($fg / $pembagi * 100,2);
           $p_broken = round($broken / $pembagi * 100,2);
           $p_skip = round($skip / $pembagi * 100,2);
           $p_pktw = round($pktw / $pembagi * 100,2);
           $p_crooked = round($dataCrooked / $pembagi * 100,2);
           $p_pleated = round($pleated / $pembagi * 100,2);
           $p_ros = round($ros / $pembagi * 100,2);
           $p_htl = round($htl / $pembagi * 100,2);
           $p_button = round($button / $pembagi * 100,2);
           $p_print = round($print / $pembagi * 100,2);
           $p_bs = round($bs / $pembagi * 100,2);
           $p_unb = round($unb / $pembagi * 100,2);
           $p_shading = round($shading / $pembagi * 100,2);
           $p_dof = round($dof / $pembagi * 100,2);
           $p_dirty = round($dirty / $pembagi * 100,2);
           $p_shiny = round($shiny / $pembagi * 100,2);
           $p_sticker = round($sticker / $pembagi * 100,2);
           $p_trimming = round($trimming / $pembagi * 100,2);
           $p_ip = round($ip / $pembagi * 100,2);
           $p_meas = round($meas / $pembagi * 100,2);
           $p_other = round($other / $pembagi * 100,2);
       }

       //Update data FG di database
       $update = [
           'crooked' => $dataCrooked,
           'p_fg' => $p_fg,
           'p_broken' => $p_broken,
           'p_skip' => $p_skip,
           'p_pktw' => $p_pktw,
           'p_crooked' => $p_crooked,
           'p_pleated' => $p_pleated,
           'p_ros' => $p_ros,
           'p_htl' => $p_htl,
           'p_button' => $p_button,
           'p_print' => $p_print,
           'p_bs' => $p_bs,
           'p_unb' => $p_unb,
           'p_shading' => $p_shading,
           'p_dof' => $p_dof,
           'p_dirty' => $p_dirty,
           'p_shiny' => $p_shiny,
           'p_sticker' => $p_sticker,
           'p_trimming' => $p_trimming,
           'p_ip' => $p_ip,
           'p_meas' => $p_meas,
           'p_other' => $p_other,
           'p_reject' => $reject,
           'total_check' => $total_check + $loop,
           'total_reject' => $total_reject + $loop,
           'target_terpenuhi' => $target_terpenuhi + $loop
       ];
       LineDetail::whereId($id)->update($update);
       // end update 

       $kerjakan = LineToTarget::with('detail')->findOrFail($target_id);

       return redirect()->back()->with('kerjakan');
    }

    public function pleated(Request $request, $id)
    {
         //Untuk Return Back 
       $target_id = $request->target_id;

       //data yang akan di olah 
       $target_terpenuhi = LineDetail::where('id', $id)->get()->sum('target_terpenuhi');
       $total_check = LineDetail::where('id', $id)->get()->sum('total_check');
       $total_reject = LineDetail::where('id', $id)->get()->sum('total_reject');
       $fg = LineDetail::where('id', $id)->get()->sum('fg');
       $broken = LineDetail::where('id', $id)->get()->sum('broken');
       $skip = LineDetail::where('id', $id)->get()->sum('skip');
       $pktw = LineDetail::where('id', $id)->get()->sum('pktw');
       $crooked = LineDetail::where('id', $id)->get()->sum('crooked');
       $pleated = LineDetail::where('id', $id)->get()->sum('pleated');
       $ros = LineDetail::where('id', $id)->get()->sum('ros');
       $htl = LineDetail::where('id', $id)->get()->sum('htl');
       $button = LineDetail::where('id', $id)->get()->sum('button');
       $print = LineDetail::where('id', $id)->get()->sum('print');
       $bs = LineDetail::where('id', $id)->get()->sum('bs');
       $unb = LineDetail::where('id', $id)->get()->sum('unb');
       $shading = LineDetail::where('id', $id)->get()->sum('shading');
       $dof = LineDetail::where('id', $id)->get()->sum('dof');
       $dirty = LineDetail::where('id', $id)->get()->sum('dirty');
       $shiny = LineDetail::where('id', $id)->get()->sum('shiny');
       $sticker = LineDetail::where('id', $id)->get()->sum('sticker');
       $trimming = LineDetail::where('id', $id)->get()->sum('trimming');
       $ip = LineDetail::where('id', $id)->get()->sum('ip');
       $meas = LineDetail::where('id', $id)->get()->sum('meas');
       $other = LineDetail::where('id', $id)->get()->sum('other');

       // untuk olah data 
       $loop = 1;
       $dataPleated = $pleated + $loop;
       $pembagi = $target_terpenuhi + $loop;
       $reject = round(($total_reject + $loop) / ($target_terpenuhi + $loop) *100,2);

       // data untuk persen 
       if ($target_terpenuhi == 0) {
           $p_fg = 0;
           $p_broken = 0;
           $p_skip = 0;
           $p_pktw = 0;
           $p_crooked = 0;
           $p_pleated= 100;
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
       }else{
           $p_fg = round($fg / $pembagi * 100,2);
           $p_broken = round($broken / $pembagi * 100,2);
           $p_skip = round($skip / $pembagi * 100,2);
           $p_pktw = round($pktw / $pembagi * 100,2);
           $p_crooked = round($crooked / $pembagi * 100,2);
           $p_pleated = round($dataPleated / $pembagi * 100,2);
           $p_ros = round($ros / $pembagi * 100,2);
           $p_htl = round($htl / $pembagi * 100,2);
           $p_button = round($button / $pembagi * 100,2);
           $p_print = round($print / $pembagi * 100,2);
           $p_bs = round($bs / $pembagi * 100,2);
           $p_unb = round($unb / $pembagi * 100,2);
           $p_shading = round($shading / $pembagi * 100,2);
           $p_dof = round($dof / $pembagi * 100,2);
           $p_dirty = round($dirty / $pembagi * 100,2);
           $p_shiny = round($shiny / $pembagi * 100,2);
           $p_sticker = round($sticker / $pembagi * 100,2);
           $p_trimming = round($trimming / $pembagi * 100,2);
           $p_ip = round($ip / $pembagi * 100,2);
           $p_meas = round($meas / $pembagi * 100,2);
           $p_other = round($other / $pembagi * 100,2);
       }

       //Update data FG di database
       $update = [
           'pleated' => $dataPleated,
           'p_fg' => $p_fg,
           'p_broken' => $p_broken,
           'p_skip' => $p_skip,
           'p_pktw' => $p_pktw,
           'p_crooked' => $p_crooked,
           'p_pleated' => $p_pleated,
           'p_ros' => $p_ros,
           'p_htl' => $p_htl,
           'p_button' => $p_button,
           'p_print' => $p_print,
           'p_bs' => $p_bs,
           'p_unb' => $p_unb,
           'p_shading' => $p_shading,
           'p_dof' => $p_dof,
           'p_dirty' => $p_dirty,
           'p_shiny' => $p_shiny,
           'p_sticker' => $p_sticker,
           'p_trimming' => $p_trimming,
           'p_ip' => $p_ip,
           'p_meas' => $p_meas,
           'p_other' => $p_other,
           'p_reject' => $reject,
           'total_check' => $total_check + $loop,
           'total_reject' => $total_reject + $loop,
           'target_terpenuhi' => $target_terpenuhi + $loop
       ];
       LineDetail::whereId($id)->update($update);
       // end update 

       $kerjakan = LineToTarget::with('detail')->findOrFail($target_id);

       return redirect()->back()->with('kerjakan');
    }

    public function htl(Request $request, $id)
    {
         //Untuk Return Back 
       $target_id = $request->target_id;

       //data yang akan di olah 
       $target_terpenuhi = LineDetail::where('id', $id)->get()->sum('target_terpenuhi');
       $total_check = LineDetail::where('id', $id)->get()->sum('total_check');
       $total_reject = LineDetail::where('id', $id)->get()->sum('total_reject');
       $fg = LineDetail::where('id', $id)->get()->sum('fg');
       $broken = LineDetail::where('id', $id)->get()->sum('broken');
       $skip = LineDetail::where('id', $id)->get()->sum('skip');
       $pktw = LineDetail::where('id', $id)->get()->sum('pktw');
       $crooked = LineDetail::where('id', $id)->get()->sum('crooked');
       $pleated = LineDetail::where('id', $id)->get()->sum('pleated');
       $ros = LineDetail::where('id', $id)->get()->sum('ros');
       $htl = LineDetail::where('id', $id)->get()->sum('htl');
       $button = LineDetail::where('id', $id)->get()->sum('button');
       $print = LineDetail::where('id', $id)->get()->sum('print');
       $bs = LineDetail::where('id', $id)->get()->sum('bs');
       $unb = LineDetail::where('id', $id)->get()->sum('unb');
       $shading = LineDetail::where('id', $id)->get()->sum('shading');
       $dof = LineDetail::where('id', $id)->get()->sum('dof');
       $dirty = LineDetail::where('id', $id)->get()->sum('dirty');
       $shiny = LineDetail::where('id', $id)->get()->sum('shiny');
       $sticker = LineDetail::where('id', $id)->get()->sum('sticker');
       $trimming = LineDetail::where('id', $id)->get()->sum('trimming');
       $ip = LineDetail::where('id', $id)->get()->sum('ip');
       $meas = LineDetail::where('id', $id)->get()->sum('meas');
       $other = LineDetail::where('id', $id)->get()->sum('other');

       // untuk olah data 
       $loop = 1;
       $dataHTL = $htl + $loop;
       $pembagi = $target_terpenuhi + $loop;
       $reject = round(($total_reject + $loop) / ($target_terpenuhi + $loop) *100,2);

       // data untuk persen 
       if ($target_terpenuhi == 0) {
           $p_fg = 0;
           $p_broken = 0;
           $p_skip = 0;
           $p_pktw = 0;
           $p_crooked = 0;
           $p_pleated= 0;
           $p_ros = 0;
           $p_htl = 100;
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
       }else{
           $p_fg = round($fg / $pembagi * 100,2);
           $p_broken = round($broken / $pembagi * 100,2);
           $p_skip = round($skip / $pembagi * 100,2);
           $p_pktw = round($pktw / $pembagi * 100,2);
           $p_crooked = round($crooked / $pembagi * 100,2);
           $p_pleated = round($pleated / $pembagi * 100,2);
           $p_ros = round($ros / $pembagi * 100,2);
           $p_htl = round($dataHTL / $pembagi * 100,2);
           $p_button = round($button / $pembagi * 100,2);
           $p_print = round($print / $pembagi * 100,2);
           $p_bs = round($bs / $pembagi * 100,2);
           $p_unb = round($unb / $pembagi * 100,2);
           $p_shading = round($shading / $pembagi * 100,2);
           $p_dof = round($dof / $pembagi * 100,2);
           $p_dirty = round($dirty / $pembagi * 100,2);
           $p_shiny = round($shiny / $pembagi * 100,2);
           $p_sticker = round($sticker / $pembagi * 100,2);
           $p_trimming = round($trimming / $pembagi * 100,2);
           $p_ip = round($ip / $pembagi * 100,2);
           $p_meas = round($meas / $pembagi * 100,2);
           $p_other = round($other / $pembagi * 100,2);
       }

       //Update data FG di database
       $update = [
           'htl' => $dataHTL,
           'p_fg' => $p_fg,
           'p_broken' => $p_broken,
           'p_skip' => $p_skip,
           'p_pktw' => $p_pktw,
           'p_crooked' => $p_crooked,
           'p_pleated' => $p_pleated,
           'p_ros' => $p_ros,
           'p_htl' => $p_htl,
           'p_button' => $p_button,
           'p_print' => $p_print,
           'p_bs' => $p_bs,
           'p_unb' => $p_unb,
           'p_shading' => $p_shading,
           'p_dof' => $p_dof,
           'p_dirty' => $p_dirty,
           'p_shiny' => $p_shiny,
           'p_sticker' => $p_sticker,
           'p_trimming' => $p_trimming,
           'p_ip' => $p_ip,
           'p_meas' => $p_meas,
           'p_other' => $p_other,
           'p_reject' => $reject,
           'total_check' => $total_check + $loop,
           'total_reject' => $total_reject + $loop,
           'target_terpenuhi' => $target_terpenuhi + $loop
       ];
       LineDetail::whereId($id)->update($update);
       // end update 

       $kerjakan = LineToTarget::with('detail')->findOrFail($target_id);

       return redirect()->back()->with('kerjakan');
    }

    public function button(Request $request, $id)
    {
         //Untuk Return Back 
       $target_id = $request->target_id;

       //data yang akan di olah 
       $target_terpenuhi = LineDetail::where('id', $id)->get()->sum('target_terpenuhi');
       $total_check = LineDetail::where('id', $id)->get()->sum('total_check');
       $total_reject = LineDetail::where('id', $id)->get()->sum('total_reject');
       $fg = LineDetail::where('id', $id)->get()->sum('fg');
       $broken = LineDetail::where('id', $id)->get()->sum('broken');
       $skip = LineDetail::where('id', $id)->get()->sum('skip');
       $pktw = LineDetail::where('id', $id)->get()->sum('pktw');
       $crooked = LineDetail::where('id', $id)->get()->sum('crooked');
       $pleated = LineDetail::where('id', $id)->get()->sum('pleated');
       $ros = LineDetail::where('id', $id)->get()->sum('ros');
       $htl = LineDetail::where('id', $id)->get()->sum('htl');
       $button = LineDetail::where('id', $id)->get()->sum('button');
       $print = LineDetail::where('id', $id)->get()->sum('print');
       $bs = LineDetail::where('id', $id)->get()->sum('bs');
       $unb = LineDetail::where('id', $id)->get()->sum('unb');
       $shading = LineDetail::where('id', $id)->get()->sum('shading');
       $dof = LineDetail::where('id', $id)->get()->sum('dof');
       $dirty = LineDetail::where('id', $id)->get()->sum('dirty');
       $shiny = LineDetail::where('id', $id)->get()->sum('shiny');
       $sticker = LineDetail::where('id', $id)->get()->sum('sticker');
       $trimming = LineDetail::where('id', $id)->get()->sum('trimming');
       $ip = LineDetail::where('id', $id)->get()->sum('ip');
       $meas = LineDetail::where('id', $id)->get()->sum('meas');
       $other = LineDetail::where('id', $id)->get()->sum('other');

       // untuk olah data 
       $loop = 1;
       $dataButton = $button + $loop;
       $pembagi = $target_terpenuhi + $loop;
       $reject = round(($total_reject + $loop) / ($target_terpenuhi + $loop) *100,2);

       // data untuk persen 
       if ($target_terpenuhi == 0) {
           $p_fg = 0;
           $p_broken = 0;
           $p_skip = 0;
           $p_pktw = 0;
           $p_crooked = 0;
           $p_pleated= 0;
           $p_ros = 0;
           $p_htl = 0;
           $p_button = 100;
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
       }else{
           $p_fg = round($fg / $pembagi * 100,2);
           $p_broken = round($broken / $pembagi * 100,2);
           $p_skip = round($skip / $pembagi * 100,2);
           $p_pktw = round($pktw / $pembagi * 100,2);
           $p_crooked = round($crooked / $pembagi * 100,2);
           $p_pleated = round($pleated / $pembagi * 100,2);
           $p_ros = round($ros / $pembagi * 100,2);
           $p_htl = round($htl / $pembagi * 100,2);
           $p_button = round($dataButton / $pembagi * 100,2);
           $p_print = round($print / $pembagi * 100,2);
           $p_bs = round($bs / $pembagi * 100,2);
           $p_unb = round($unb / $pembagi * 100,2);
           $p_shading = round($shading / $pembagi * 100,2);
           $p_dof = round($dof / $pembagi * 100,2);
           $p_dirty = round($dirty / $pembagi * 100,2);
           $p_shiny = round($shiny / $pembagi * 100,2);
           $p_sticker = round($sticker / $pembagi * 100,2);
           $p_trimming = round($trimming / $pembagi * 100,2);
           $p_ip = round($ip / $pembagi * 100,2);
           $p_meas = round($meas / $pembagi * 100,2);
           $p_other = round($other / $pembagi * 100,2);
       }

       //Update data FG di database
       $update = [
           'button' => $dataButton,
           'p_fg' => $p_fg,
           'p_broken' => $p_broken,
           'p_skip' => $p_skip,
           'p_pktw' => $p_pktw,
           'p_crooked' => $p_crooked,
           'p_pleated' => $p_pleated,
           'p_ros' => $p_ros,
           'p_htl' => $p_htl,
           'p_button' => $p_button,
           'p_print' => $p_print,
           'p_bs' => $p_bs,
           'p_unb' => $p_unb,
           'p_shading' => $p_shading,
           'p_dof' => $p_dof,
           'p_dirty' => $p_dirty,
           'p_shiny' => $p_shiny,
           'p_sticker' => $p_sticker,
           'p_trimming' => $p_trimming,
           'p_ip' => $p_ip,
           'p_meas' => $p_meas,
           'p_other' => $p_other,
           'p_reject' => $reject,
           'total_check' => $total_check + $loop,
           'total_reject' => $total_reject + $loop,
           'target_terpenuhi' => $target_terpenuhi + $loop
       ];
       LineDetail::whereId($id)->update($update);
       // end update 

       $kerjakan = LineToTarget::with('detail')->findOrFail($target_id);

       return redirect()->back()->with('kerjakan');
    }

    public function print(Request $request, $id)
    {
         //Untuk Return Back 
       $target_id = $request->target_id;

       //data yang akan di olah 
       $target_terpenuhi = LineDetail::where('id', $id)->get()->sum('target_terpenuhi');
       $total_check = LineDetail::where('id', $id)->get()->sum('total_check');
       $total_reject = LineDetail::where('id', $id)->get()->sum('total_reject');
       $fg = LineDetail::where('id', $id)->get()->sum('fg');
       $broken = LineDetail::where('id', $id)->get()->sum('broken');
       $skip = LineDetail::where('id', $id)->get()->sum('skip');
       $pktw = LineDetail::where('id', $id)->get()->sum('pktw');
       $crooked = LineDetail::where('id', $id)->get()->sum('crooked');
       $pleated = LineDetail::where('id', $id)->get()->sum('pleated');
       $ros = LineDetail::where('id', $id)->get()->sum('ros');
       $htl = LineDetail::where('id', $id)->get()->sum('htl');
       $button = LineDetail::where('id', $id)->get()->sum('button');
       $print = LineDetail::where('id', $id)->get()->sum('print');
       $bs = LineDetail::where('id', $id)->get()->sum('bs');
       $unb = LineDetail::where('id', $id)->get()->sum('unb');
       $shading = LineDetail::where('id', $id)->get()->sum('shading');
       $dof = LineDetail::where('id', $id)->get()->sum('dof');
       $dirty = LineDetail::where('id', $id)->get()->sum('dirty');
       $shiny = LineDetail::where('id', $id)->get()->sum('shiny');
       $sticker = LineDetail::where('id', $id)->get()->sum('sticker');
       $trimming = LineDetail::where('id', $id)->get()->sum('trimming');
       $ip = LineDetail::where('id', $id)->get()->sum('ip');
       $meas = LineDetail::where('id', $id)->get()->sum('meas');
       $other = LineDetail::where('id', $id)->get()->sum('other');

       // untuk olah data 
       $loop = 1;
       $dataPrint = $print + $loop;
       $pembagi = $target_terpenuhi + $loop;
       $reject = round(($total_reject + $loop) / ($target_terpenuhi + $loop) *100,2);

       // data untuk persen 
       if ($target_terpenuhi == 0) {
           $p_fg = 0;
           $p_broken = 0;
           $p_skip = 0;
           $p_pktw = 0;
           $p_crooked = 0;
           $p_pleated= 0;
           $p_ros = 0;
           $p_htl = 0;
           $p_button = 0;
           $p_print = 100;
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
       }else{
           $p_fg = round($fg / $pembagi * 100,2);
           $p_broken = round($broken / $pembagi * 100,2);
           $p_skip = round($skip / $pembagi * 100,2);
           $p_pktw = round($pktw / $pembagi * 100,2);
           $p_crooked = round($crooked / $pembagi * 100,2);
           $p_pleated = round($pleated / $pembagi * 100,2);
           $p_ros = round($ros / $pembagi * 100,2);
           $p_htl = round($htl / $pembagi * 100,2);
           $p_button = round($button / $pembagi * 100,2);
           $p_print = round($dataPrint / $pembagi * 100,2);
           $p_bs = round($bs / $pembagi * 100,2);
           $p_unb = round($unb / $pembagi * 100,2);
           $p_shading = round($shading / $pembagi * 100,2);
           $p_dof = round($dof / $pembagi * 100,2);
           $p_dirty = round($dirty / $pembagi * 100,2);
           $p_shiny = round($shiny / $pembagi * 100,2);
           $p_sticker = round($sticker / $pembagi * 100,2);
           $p_trimming = round($trimming / $pembagi * 100,2);
           $p_ip = round($ip / $pembagi * 100,2);
           $p_meas = round($meas / $pembagi * 100,2);
           $p_other = round($other / $pembagi * 100,2);
       }

       //Update data FG di database
       $update = [
           'print' => $dataPrint,
           'p_fg' => $p_fg,
           'p_broken' => $p_broken,
           'p_skip' => $p_skip,
           'p_pktw' => $p_pktw,
           'p_crooked' => $p_crooked,
           'p_pleated' => $p_pleated,
           'p_ros' => $p_ros,
           'p_htl' => $p_htl,
           'p_button' => $p_button,
           'p_print' => $p_print,
           'p_bs' => $p_bs,
           'p_unb' => $p_unb,
           'p_shading' => $p_shading,
           'p_dof' => $p_dof,
           'p_dirty' => $p_dirty,
           'p_shiny' => $p_shiny,
           'p_sticker' => $p_sticker,
           'p_trimming' => $p_trimming,
           'p_ip' => $p_ip,
           'p_meas' => $p_meas,
           'p_other' => $p_other,
           'p_reject' => $reject,
           'total_check' => $total_check + $loop,
           'total_reject' => $total_reject + $loop,
           'target_terpenuhi' => $target_terpenuhi + $loop
       ];
       LineDetail::whereId($id)->update($update);
       // end update 

       $kerjakan = LineToTarget::with('detail')->findOrFail($target_id);

       return redirect()->back()->with('kerjakan');
    }

    public function shading(Request $request, $id)
    {
         //Untuk Return Back 
       $target_id = $request->target_id;

       //data yang akan di olah 
       $target_terpenuhi = LineDetail::where('id', $id)->get()->sum('target_terpenuhi');
       $total_check = LineDetail::where('id', $id)->get()->sum('total_check');
       $total_reject = LineDetail::where('id', $id)->get()->sum('total_reject');
       $fg = LineDetail::where('id', $id)->get()->sum('fg');
       $broken = LineDetail::where('id', $id)->get()->sum('broken');
       $skip = LineDetail::where('id', $id)->get()->sum('skip');
       $pktw = LineDetail::where('id', $id)->get()->sum('pktw');
       $crooked = LineDetail::where('id', $id)->get()->sum('crooked');
       $pleated = LineDetail::where('id', $id)->get()->sum('pleated');
       $ros = LineDetail::where('id', $id)->get()->sum('ros');
       $htl = LineDetail::where('id', $id)->get()->sum('htl');
       $button = LineDetail::where('id', $id)->get()->sum('button');
       $print = LineDetail::where('id', $id)->get()->sum('print');
       $bs = LineDetail::where('id', $id)->get()->sum('bs');
       $unb = LineDetail::where('id', $id)->get()->sum('unb');
       $shading = LineDetail::where('id', $id)->get()->sum('shading');
       $dof = LineDetail::where('id', $id)->get()->sum('dof');
       $dirty = LineDetail::where('id', $id)->get()->sum('dirty');
       $shiny = LineDetail::where('id', $id)->get()->sum('shiny');
       $sticker = LineDetail::where('id', $id)->get()->sum('sticker');
       $trimming = LineDetail::where('id', $id)->get()->sum('trimming');
       $ip = LineDetail::where('id', $id)->get()->sum('ip');
       $meas = LineDetail::where('id', $id)->get()->sum('meas');
       $other = LineDetail::where('id', $id)->get()->sum('other');

       // untuk olah data 
       $loop = 1;
       $dataShading = $shading + $loop;
       $pembagi = $target_terpenuhi + $loop;
       $reject = round(($total_reject + $loop) / ($target_terpenuhi + $loop) *100,2);

       // data untuk persen 
       if ($target_terpenuhi == 0) {
           $p_fg = 0;
           $p_broken = 0;
           $p_skip = 0;
           $p_pktw = 0;
           $p_crooked = 0;
           $p_pleated= 0;
           $p_ros = 0;
           $p_htl = 0;
           $p_button = 0;
           $p_print = 0;
           $p_bs = 0;
           $p_unb = 0;
           $p_shading = 100;
           $p_dof = 0;
           $p_dirty = 0;
           $p_shiny = 0;
           $p_sticker = 0;
           $p_trimming = 0;
           $p_ip = 0;
           $p_meas = 0;
           $p_other = 0;
       }else{
           $p_fg = round($fg / $pembagi * 100,2);
           $p_broken = round($broken / $pembagi * 100,2);
           $p_skip = round($skip / $pembagi * 100,2);
           $p_pktw = round($pktw / $pembagi * 100,2);
           $p_crooked = round($crooked / $pembagi * 100,2);
           $p_pleated = round($pleated / $pembagi * 100,2);
           $p_ros = round($ros / $pembagi * 100,2);
           $p_htl = round($htl / $pembagi * 100,2);
           $p_button = round($button / $pembagi * 100,2);
           $p_print = round($print / $pembagi * 100,2);
           $p_bs = round($bs / $pembagi * 100,2);
           $p_unb = round($unb / $pembagi * 100,2);
           $p_shading = round($dataShading / $pembagi * 100,2);
           $p_dof = round($dof / $pembagi * 100,2);
           $p_dirty = round($dirty / $pembagi * 100,2);
           $p_shiny = round($shiny / $pembagi * 100,2);
           $p_sticker = round($sticker / $pembagi * 100,2);
           $p_trimming = round($trimming / $pembagi * 100,2);
           $p_ip = round($ip / $pembagi * 100,2);
           $p_meas = round($meas / $pembagi * 100,2);
           $p_other = round($other / $pembagi * 100,2);
       }

       //Update data FG di database
       $update = [
           'shading' => $dataShading,
           'p_fg' => $p_fg,
           'p_broken' => $p_broken,
           'p_skip' => $p_skip,
           'p_pktw' => $p_pktw,
           'p_crooked' => $p_crooked,
           'p_pleated' => $p_pleated,
           'p_ros' => $p_ros,
           'p_htl' => $p_htl,
           'p_button' => $p_button,
           'p_print' => $p_print,
           'p_bs' => $p_bs,
           'p_unb' => $p_unb,
           'p_shading' => $p_shading,
           'p_dof' => $p_dof,
           'p_dirty' => $p_dirty,
           'p_shiny' => $p_shiny,
           'p_sticker' => $p_sticker,
           'p_trimming' => $p_trimming,
           'p_ip' => $p_ip,
           'p_meas' => $p_meas,
           'p_other' => $p_other,
           'p_reject' => $reject,
           'total_check' => $total_check + $loop,
           'total_reject' => $total_reject + $loop,
           'target_terpenuhi' => $target_terpenuhi + $loop
       ];
       LineDetail::whereId($id)->update($update);
       // end update 

       $kerjakan = LineToTarget::with('detail')->findOrFail($target_id);

       return redirect()->back()->with('kerjakan');
    }

    public function dof(Request $request, $id)
    {
         //Untuk Return Back 
       $target_id = $request->target_id;

       //data yang akan di olah 
       $target_terpenuhi = LineDetail::where('id', $id)->get()->sum('target_terpenuhi');
       $total_check = LineDetail::where('id', $id)->get()->sum('total_check');
       $total_reject = LineDetail::where('id', $id)->get()->sum('total_reject');
       $fg = LineDetail::where('id', $id)->get()->sum('fg');
       $broken = LineDetail::where('id', $id)->get()->sum('broken');
       $skip = LineDetail::where('id', $id)->get()->sum('skip');
       $pktw = LineDetail::where('id', $id)->get()->sum('pktw');
       $crooked = LineDetail::where('id', $id)->get()->sum('crooked');
       $pleated = LineDetail::where('id', $id)->get()->sum('pleated');
       $ros = LineDetail::where('id', $id)->get()->sum('ros');
       $htl = LineDetail::where('id', $id)->get()->sum('htl');
       $button = LineDetail::where('id', $id)->get()->sum('button');
       $print = LineDetail::where('id', $id)->get()->sum('print');
       $bs = LineDetail::where('id', $id)->get()->sum('bs');
       $unb = LineDetail::where('id', $id)->get()->sum('unb');
       $shading = LineDetail::where('id', $id)->get()->sum('shading');
       $dof = LineDetail::where('id', $id)->get()->sum('dof');
       $dirty = LineDetail::where('id', $id)->get()->sum('dirty');
       $shiny = LineDetail::where('id', $id)->get()->sum('shiny');
       $sticker = LineDetail::where('id', $id)->get()->sum('sticker');
       $trimming = LineDetail::where('id', $id)->get()->sum('trimming');
       $ip = LineDetail::where('id', $id)->get()->sum('ip');
       $meas = LineDetail::where('id', $id)->get()->sum('meas');
       $other = LineDetail::where('id', $id)->get()->sum('other');

       // untuk olah data 
       $loop = 1;
       $dataDOF = $dof + $loop;
       $pembagi = $target_terpenuhi + $loop;
       $reject = round(($total_reject + $loop) / ($target_terpenuhi + $loop) *100,2);

       // data untuk persen 
       if ($target_terpenuhi == 0) {
           $p_fg = 0;
           $p_broken = 0;
           $p_skip = 0;
           $p_pktw = 0;
           $p_crooked = 0;
           $p_pleated= 0;
           $p_ros = 0;
           $p_htl = 0;
           $p_button = 0;
           $p_print = 0;
           $p_bs = 0;
           $p_unb = 0;
           $p_shading = 0;
           $p_dof = 100;
           $p_dirty = 0;
           $p_shiny = 0;
           $p_sticker = 0;
           $p_trimming = 0;
           $p_ip = 0;
           $p_meas = 0;
           $p_other = 0;
       }else{
           $p_fg = round($fg / $pembagi * 100,2);
           $p_broken = round($broken / $pembagi * 100,2);
           $p_skip = round($skip / $pembagi * 100,2);
           $p_pktw = round($pktw / $pembagi * 100,2);
           $p_crooked = round($crooked / $pembagi * 100,2);
           $p_pleated = round($pleated / $pembagi * 100,2);
           $p_ros = round($ros / $pembagi * 100,2);
           $p_htl = round($htl / $pembagi * 100,2);
           $p_button = round($button / $pembagi * 100,2);
           $p_print = round($print / $pembagi * 100,2);
           $p_bs = round($bs / $pembagi * 100,2);
           $p_unb = round($unb / $pembagi * 100,2);
           $p_shading = round($shading / $pembagi * 100,2);
           $p_dof = round($dataDOF / $pembagi * 100,2);
           $p_dirty = round($dirty / $pembagi * 100,2);
           $p_shiny = round($shiny / $pembagi * 100,2);
           $p_sticker = round($sticker / $pembagi * 100,2);
           $p_trimming = round($trimming / $pembagi * 100,2);
           $p_ip = round($ip / $pembagi * 100,2);
           $p_meas = round($meas / $pembagi * 100,2);
           $p_other = round($other / $pembagi * 100,2);
       }

       //Update data FG di database
       $update = [
           'dof' => $dataDOF,
           'p_fg' => $p_fg,
           'p_broken' => $p_broken,
           'p_skip' => $p_skip,
           'p_pktw' => $p_pktw,
           'p_crooked' => $p_crooked,
           'p_pleated' => $p_pleated,
           'p_ros' => $p_ros,
           'p_htl' => $p_htl,
           'p_button' => $p_button,
           'p_print' => $p_print,
           'p_bs' => $p_bs,
           'p_unb' => $p_unb,
           'p_shading' => $p_shading,
           'p_dof' => $p_dof,
           'p_dirty' => $p_dirty,
           'p_shiny' => $p_shiny,
           'p_sticker' => $p_sticker,
           'p_trimming' => $p_trimming,
           'p_ip' => $p_ip,
           'p_meas' => $p_meas,
           'p_other' => $p_other,
           'p_reject' => $reject,
           'total_check' => $total_check + $loop,
           'total_reject' => $total_reject + $loop,
           'target_terpenuhi' => $target_terpenuhi + $loop
       ];
       LineDetail::whereId($id)->update($update);
       // end update 

       $kerjakan = LineToTarget::with('detail')->findOrFail($target_id);

       return redirect()->back()->with('kerjakan');
    }

    public function dirty(Request $request, $id)
    {
         //Untuk Return Back 
       $target_id = $request->target_id;

       //data yang akan di olah 
       $target_terpenuhi = LineDetail::where('id', $id)->get()->sum('target_terpenuhi');
       $total_check = LineDetail::where('id', $id)->get()->sum('total_check');
       $total_reject = LineDetail::where('id', $id)->get()->sum('total_reject');
       $fg = LineDetail::where('id', $id)->get()->sum('fg');
       $broken = LineDetail::where('id', $id)->get()->sum('broken');
       $skip = LineDetail::where('id', $id)->get()->sum('skip');
       $pktw = LineDetail::where('id', $id)->get()->sum('pktw');
       $crooked = LineDetail::where('id', $id)->get()->sum('crooked');
       $pleated = LineDetail::where('id', $id)->get()->sum('pleated');
       $ros = LineDetail::where('id', $id)->get()->sum('ros');
       $htl = LineDetail::where('id', $id)->get()->sum('htl');
       $button = LineDetail::where('id', $id)->get()->sum('button');
       $print = LineDetail::where('id', $id)->get()->sum('print');
       $bs = LineDetail::where('id', $id)->get()->sum('bs');
       $unb = LineDetail::where('id', $id)->get()->sum('unb');
       $shading = LineDetail::where('id', $id)->get()->sum('shading');
       $dof = LineDetail::where('id', $id)->get()->sum('dof');
       $dirty = LineDetail::where('id', $id)->get()->sum('dirty');
       $shiny = LineDetail::where('id', $id)->get()->sum('shiny');
       $sticker = LineDetail::where('id', $id)->get()->sum('sticker');
       $trimming = LineDetail::where('id', $id)->get()->sum('trimming');
       $ip = LineDetail::where('id', $id)->get()->sum('ip');
       $meas = LineDetail::where('id', $id)->get()->sum('meas');
       $other = LineDetail::where('id', $id)->get()->sum('other');

       // untuk olah data 
       $loop = 1;
       $dataDirty = $dirty + $loop;
       $pembagi = $target_terpenuhi + $loop;
       $reject = round(($total_reject + $loop) / ($target_terpenuhi + $loop) *100,2);

       // data untuk persen 
       if ($target_terpenuhi == 0) {
           $p_fg = 0;
           $p_broken = 0;
           $p_skip = 0;
           $p_pktw = 0;
           $p_crooked = 0;
           $p_pleated= 0;
           $p_ros = 0;
           $p_htl = 0;
           $p_button = 0;
           $p_print = 0;
           $p_bs = 0;
           $p_unb = 0;
           $p_shading = 0;
           $p_dof = 0;
           $p_dirty = 100;
           $p_shiny = 0;
           $p_sticker = 0;
           $p_trimming = 0;
           $p_ip = 0;
           $p_meas = 0;
           $p_other = 0;
       }else{
           $p_fg = round($fg / $pembagi * 100,2);
           $p_broken = round($broken / $pembagi * 100,2);
           $p_skip = round($skip / $pembagi * 100,2);
           $p_pktw = round($pktw / $pembagi * 100,2);
           $p_crooked = round($crooked / $pembagi * 100,2);
           $p_pleated = round($pleated / $pembagi * 100,2);
           $p_ros = round($ros / $pembagi * 100,2);
           $p_htl = round($htl / $pembagi * 100,2);
           $p_button = round($button / $pembagi * 100,2);
           $p_print = round($print / $pembagi * 100,2);
           $p_bs = round($bs / $pembagi * 100,2);
           $p_unb = round($unb / $pembagi * 100,2);
           $p_shading = round($shading / $pembagi * 100,2);
           $p_dof = round($dof / $pembagi * 100,2);
           $p_dirty = round($dataDirty / $pembagi * 100,2);
           $p_shiny = round($shiny / $pembagi * 100,2);
           $p_sticker = round($sticker / $pembagi * 100,2);
           $p_trimming = round($trimming / $pembagi * 100,2);
           $p_ip = round($ip / $pembagi * 100,2);
           $p_meas = round($meas / $pembagi * 100,2);
           $p_other = round($other / $pembagi * 100,2);
       }

       //Update data FG di database
       $update = [
           'dirty' => $dataDirty,
           'p_fg' => $p_fg,
           'p_broken' => $p_broken,
           'p_skip' => $p_skip,
           'p_pktw' => $p_pktw,
           'p_crooked' => $p_crooked,
           'p_pleated' => $p_pleated,
           'p_ros' => $p_ros,
           'p_htl' => $p_htl,
           'p_button' => $p_button,
           'p_print' => $p_print,
           'p_bs' => $p_bs,
           'p_unb' => $p_unb,
           'p_shading' => $p_shading,
           'p_dof' => $p_dof,
           'p_dirty' => $p_dirty,
           'p_shiny' => $p_shiny,
           'p_sticker' => $p_sticker,
           'p_trimming' => $p_trimming,
           'p_ip' => $p_ip,
           'p_meas' => $p_meas,
           'p_other' => $p_other,
           'p_reject' => $reject,
           'total_check' => $total_check + $loop,
           'total_reject' => $total_reject + $loop,
           'target_terpenuhi' => $target_terpenuhi + $loop
       ];
       LineDetail::whereId($id)->update($update);
       // end update 

       $kerjakan = LineToTarget::with('detail')->findOrFail($target_id);

       return redirect()->back()->with('kerjakan');
    }

    public function shiny(Request $request, $id)
    {
         //Untuk Return Back 
       $target_id = $request->target_id;

       //data yang akan di olah 
       $target_terpenuhi = LineDetail::where('id', $id)->get()->sum('target_terpenuhi');
       $total_check = LineDetail::where('id', $id)->get()->sum('total_check');
       $total_reject = LineDetail::where('id', $id)->get()->sum('total_reject');
       $fg = LineDetail::where('id', $id)->get()->sum('fg');
       $broken = LineDetail::where('id', $id)->get()->sum('broken');
       $skip = LineDetail::where('id', $id)->get()->sum('skip');
       $pktw = LineDetail::where('id', $id)->get()->sum('pktw');
       $crooked = LineDetail::where('id', $id)->get()->sum('crooked');
       $pleated = LineDetail::where('id', $id)->get()->sum('pleated');
       $ros = LineDetail::where('id', $id)->get()->sum('ros');
       $htl = LineDetail::where('id', $id)->get()->sum('htl');
       $button = LineDetail::where('id', $id)->get()->sum('button');
       $print = LineDetail::where('id', $id)->get()->sum('print');
       $bs = LineDetail::where('id', $id)->get()->sum('bs');
       $unb = LineDetail::where('id', $id)->get()->sum('unb');
       $shading = LineDetail::where('id', $id)->get()->sum('shading');
       $dof = LineDetail::where('id', $id)->get()->sum('dof');
       $dirty = LineDetail::where('id', $id)->get()->sum('dirty');
       $shiny = LineDetail::where('id', $id)->get()->sum('shiny');
       $sticker = LineDetail::where('id', $id)->get()->sum('sticker');
       $trimming = LineDetail::where('id', $id)->get()->sum('trimming');
       $ip = LineDetail::where('id', $id)->get()->sum('ip');
       $meas = LineDetail::where('id', $id)->get()->sum('meas');
       $other = LineDetail::where('id', $id)->get()->sum('other');

       // untuk olah data 
       $loop = 1;
       $dataShiny = $shiny + $loop;
       $pembagi = $target_terpenuhi + $loop;
       $reject = round(($total_reject + $loop) / ($target_terpenuhi + $loop) *100,2);

       // data untuk persen 
       if ($target_terpenuhi == 0) {
           $p_fg = 0;
           $p_broken = 0;
           $p_skip = 0;
           $p_pktw = 0;
           $p_crooked = 0;
           $p_pleated= 0;
           $p_ros = 0;
           $p_htl = 0;
           $p_button = 0;
           $p_print = 0;
           $p_bs = 0;
           $p_unb = 0;
           $p_shading = 0;
           $p_dof = 0;
           $p_dirty = 0;
           $p_shiny = 100;
           $p_sticker = 0;
           $p_trimming = 0;
           $p_ip = 0;
           $p_meas = 0;
           $p_other = 0;
       }else{
           $p_fg = round($fg / $pembagi * 100,2);
           $p_broken = round($broken / $pembagi * 100,2);
           $p_skip = round($skip / $pembagi * 100,2);
           $p_pktw = round($pktw / $pembagi * 100,2);
           $p_crooked = round($crooked / $pembagi * 100,2);
           $p_pleated = round($pleated / $pembagi * 100,2);
           $p_ros = round($ros / $pembagi * 100,2);
           $p_htl = round($htl / $pembagi * 100,2);
           $p_button = round($button / $pembagi * 100,2);
           $p_print = round($print / $pembagi * 100,2);
           $p_bs = round($bs / $pembagi * 100,2);
           $p_unb = round($unb / $pembagi * 100,2);
           $p_shading = round($shading / $pembagi * 100,2);
           $p_dof = round($dof / $pembagi * 100,2);
           $p_dirty = round($dirty / $pembagi * 100,2);
           $p_shiny = round($dataShiny / $pembagi * 100,2);
           $p_sticker = round($sticker / $pembagi * 100,2);
           $p_trimming = round($trimming / $pembagi * 100,2);
           $p_ip = round($ip / $pembagi * 100,2);
           $p_meas = round($meas / $pembagi * 100,2);
           $p_other = round($other / $pembagi * 100,2);
       }

       //Update data FG di database
       $update = [
           'shiny' => $dataShiny,
           'p_fg' => $p_fg,
           'p_broken' => $p_broken,
           'p_skip' => $p_skip,
           'p_pktw' => $p_pktw,
           'p_crooked' => $p_crooked,
           'p_pleated' => $p_pleated,
           'p_ros' => $p_ros,
           'p_htl' => $p_htl,
           'p_button' => $p_button,
           'p_print' => $p_print,
           'p_bs' => $p_bs,
           'p_unb' => $p_unb,
           'p_shading' => $p_shading,
           'p_dof' => $p_dof,
           'p_dirty' => $p_dirty,
           'p_shiny' => $p_shiny,
           'p_sticker' => $p_sticker,
           'p_trimming' => $p_trimming,
           'p_ip' => $p_ip,
           'p_meas' => $p_meas,
           'p_other' => $p_other,
           'p_reject' => $reject,
           'total_check' => $total_check + $loop,
           'total_reject' => $total_reject + $loop,
           'target_terpenuhi' => $target_terpenuhi + $loop
       ];
       LineDetail::whereId($id)->update($update);
       // end update 

       $kerjakan = LineToTarget::with('detail')->findOrFail($target_id);

       return redirect()->back()->with('kerjakan');
    }

    public function bs(Request $request, $id)
    {
         //Untuk Return Back 
       $target_id = $request->target_id;

       //data yang akan di olah 
       $target_terpenuhi = LineDetail::where('id', $id)->get()->sum('target_terpenuhi');
       $total_check = LineDetail::where('id', $id)->get()->sum('total_check');
       $total_reject = LineDetail::where('id', $id)->get()->sum('total_reject');
       $fg = LineDetail::where('id', $id)->get()->sum('fg');
       $broken = LineDetail::where('id', $id)->get()->sum('broken');
       $skip = LineDetail::where('id', $id)->get()->sum('skip');
       $pktw = LineDetail::where('id', $id)->get()->sum('pktw');
       $crooked = LineDetail::where('id', $id)->get()->sum('crooked');
       $pleated = LineDetail::where('id', $id)->get()->sum('pleated');
       $ros = LineDetail::where('id', $id)->get()->sum('ros');
       $htl = LineDetail::where('id', $id)->get()->sum('htl');
       $button = LineDetail::where('id', $id)->get()->sum('button');
       $print = LineDetail::where('id', $id)->get()->sum('print');
       $bs = LineDetail::where('id', $id)->get()->sum('bs');
       $unb = LineDetail::where('id', $id)->get()->sum('unb');
       $shading = LineDetail::where('id', $id)->get()->sum('shading');
       $dof = LineDetail::where('id', $id)->get()->sum('dof');
       $dirty = LineDetail::where('id', $id)->get()->sum('dirty');
       $shiny = LineDetail::where('id', $id)->get()->sum('shiny');
       $sticker = LineDetail::where('id', $id)->get()->sum('sticker');
       $trimming = LineDetail::where('id', $id)->get()->sum('trimming');
       $ip = LineDetail::where('id', $id)->get()->sum('ip');
       $meas = LineDetail::where('id', $id)->get()->sum('meas');
       $other = LineDetail::where('id', $id)->get()->sum('other');

       // untuk olah data 
       $loop = 1;
       $dataBS = $bs + $loop;
       $pembagi = $target_terpenuhi + $loop;
       $reject = round(($total_reject + $loop) / ($target_terpenuhi + $loop) *100,2);

       // data untuk persen 
       if ($target_terpenuhi == 0) {
           $p_fg = 0;
           $p_broken = 0;
           $p_skip = 0;
           $p_pktw = 0;
           $p_crooked = 0;
           $p_pleated= 0;
           $p_ros = 0;
           $p_htl = 0;
           $p_button = 0;
           $p_print = 0;
           $p_bs = 100;
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
       }else{
           $p_fg = round($fg / $pembagi * 100,2);
           $p_broken = round($broken / $pembagi * 100,2);
           $p_skip = round($skip / $pembagi * 100,2);
           $p_pktw = round($pktw / $pembagi * 100,2);
           $p_crooked = round($crooked / $pembagi * 100,2);
           $p_pleated = round($pleated / $pembagi * 100,2);
           $p_ros = round($ros / $pembagi * 100,2);
           $p_htl = round($htl / $pembagi * 100,2);
           $p_button = round($button / $pembagi * 100,2);
           $p_print = round($print / $pembagi * 100,2);
           $p_bs = round($dataBS / $pembagi * 100,2);
           $p_unb = round($unb / $pembagi * 100,2);
           $p_shading = round($shading / $pembagi * 100,2);
           $p_dof = round($dof / $pembagi * 100,2);
           $p_dirty = round($dirty / $pembagi * 100,2);
           $p_shiny = round($shiny / $pembagi * 100,2);
           $p_sticker = round($sticker / $pembagi * 100,2);
           $p_trimming = round($trimming / $pembagi * 100,2);
           $p_ip = round($ip / $pembagi * 100,2);
           $p_meas = round($meas / $pembagi * 100,2);
           $p_other = round($other / $pembagi * 100,2);
       }

       //Update data FG di database
       $update = [
           'bs' => $dataBS,
           'p_fg' => $p_fg,
           'p_broken' => $p_broken,
           'p_skip' => $p_skip,
           'p_pktw' => $p_pktw,
           'p_crooked' => $p_crooked,
           'p_pleated' => $p_pleated,
           'p_ros' => $p_ros,
           'p_htl' => $p_htl,
           'p_button' => $p_button,
           'p_print' => $p_print,
           'p_bs' => $p_bs,
           'p_unb' => $p_unb,
           'p_shading' => $p_shading,
           'p_dof' => $p_dof,
           'p_dirty' => $p_dirty,
           'p_shiny' => $p_shiny,
           'p_sticker' => $p_sticker,
           'p_trimming' => $p_trimming,
           'p_ip' => $p_ip,
           'p_meas' => $p_meas,
           'p_other' => $p_other,
           'p_reject' => $reject,
           'total_check' => $total_check + $loop,
           'total_reject' => $total_reject + $loop,
           'target_terpenuhi' => $target_terpenuhi + $loop
       ];
       LineDetail::whereId($id)->update($update);
       // end update 

       $kerjakan = LineToTarget::with('detail')->findOrFail($target_id);

       return redirect()->back()->with('kerjakan');
    }

    public function unb(Request $request, $id)
    {
         //Untuk Return Back 
       $target_id = $request->target_id;

       //data yang akan di olah 
       $target_terpenuhi = LineDetail::where('id', $id)->get()->sum('target_terpenuhi');
       $total_check = LineDetail::where('id', $id)->get()->sum('total_check');
       $total_reject = LineDetail::where('id', $id)->get()->sum('total_reject');
       $fg = LineDetail::where('id', $id)->get()->sum('fg');
       $broken = LineDetail::where('id', $id)->get()->sum('broken');
       $skip = LineDetail::where('id', $id)->get()->sum('skip');
       $pktw = LineDetail::where('id', $id)->get()->sum('pktw');
       $crooked = LineDetail::where('id', $id)->get()->sum('crooked');
       $pleated = LineDetail::where('id', $id)->get()->sum('pleated');
       $ros = LineDetail::where('id', $id)->get()->sum('ros');
       $htl = LineDetail::where('id', $id)->get()->sum('htl');
       $button = LineDetail::where('id', $id)->get()->sum('button');
       $print = LineDetail::where('id', $id)->get()->sum('print');
       $bs = LineDetail::where('id', $id)->get()->sum('bs');
       $unb = LineDetail::where('id', $id)->get()->sum('unb');
       $shading = LineDetail::where('id', $id)->get()->sum('shading');
       $dof = LineDetail::where('id', $id)->get()->sum('dof');
       $dirty = LineDetail::where('id', $id)->get()->sum('dirty');
       $shiny = LineDetail::where('id', $id)->get()->sum('shiny');
       $sticker = LineDetail::where('id', $id)->get()->sum('sticker');
       $trimming = LineDetail::where('id', $id)->get()->sum('trimming');
       $ip = LineDetail::where('id', $id)->get()->sum('ip');
       $meas = LineDetail::where('id', $id)->get()->sum('meas');
       $other = LineDetail::where('id', $id)->get()->sum('other');

       // untuk olah data 
       $loop = 1;
       $dataUNB = $unb + $loop;
       $pembagi = $target_terpenuhi + $loop;
       $reject = round(($total_reject + $loop) / ($target_terpenuhi + $loop) *100,2);

       // data untuk persen 
       if ($target_terpenuhi == 0) {
           $p_fg = 0;
           $p_broken = 0;
           $p_skip = 0;
           $p_pktw = 0;
           $p_crooked = 0;
           $p_pleated= 0;
           $p_ros = 0;
           $p_htl = 0;
           $p_button = 0;
           $p_print = 0;
           $p_bs = 0;
           $p_unb = 100;
           $p_shading = 0;
           $p_dof = 0;
           $p_dirty = 0;
           $p_shiny = 0;
           $p_sticker = 0;
           $p_trimming = 0;
           $p_ip = 0;
           $p_meas = 0;
           $p_other = 0;
       }else{
           $p_fg = round($fg / $pembagi * 100,2);
           $p_broken = round($broken / $pembagi * 100,2);
           $p_skip = round($skip / $pembagi * 100,2);
           $p_pktw = round($pktw / $pembagi * 100,2);
           $p_crooked = round($crooked / $pembagi * 100,2);
           $p_pleated = round($pleated / $pembagi * 100,2);
           $p_ros = round($ros / $pembagi * 100,2);
           $p_htl = round($htl / $pembagi * 100,2);
           $p_button = round($button / $pembagi * 100,2);
           $p_print = round($print / $pembagi * 100,2);
           $p_bs = round($bs / $pembagi * 100,2);
           $p_unb = round($dataUNB / $pembagi * 100,2);
           $p_shading = round($shading / $pembagi * 100,2);
           $p_dof = round($dof / $pembagi * 100,2);
           $p_dirty = round($dirty / $pembagi * 100,2);
           $p_shiny = round($shiny / $pembagi * 100,2);
           $p_sticker = round($sticker / $pembagi * 100,2);
           $p_trimming = round($trimming / $pembagi * 100,2);
           $p_ip = round($ip / $pembagi * 100,2);
           $p_meas = round($meas / $pembagi * 100,2);
           $p_other = round($other / $pembagi * 100,2);
       }

       //Update data FG di database
       $update = [
           'unb' => $dataUNB,
           'p_fg' => $p_fg,
           'p_broken' => $p_broken,
           'p_skip' => $p_skip,
           'p_pktw' => $p_pktw,
           'p_crooked' => $p_crooked,
           'p_pleated' => $p_pleated,
           'p_ros' => $p_ros,
           'p_htl' => $p_htl,
           'p_button' => $p_button,
           'p_print' => $p_print,
           'p_bs' => $p_bs,
           'p_unb' => $p_unb,
           'p_shading' => $p_shading,
           'p_dof' => $p_dof,
           'p_dirty' => $p_dirty,
           'p_shiny' => $p_shiny,
           'p_sticker' => $p_sticker,
           'p_trimming' => $p_trimming,
           'p_ip' => $p_ip,
           'p_meas' => $p_meas,
           'p_other' => $p_other,
           'p_reject' => $reject,
           'total_check' => $total_check + $loop,
           'total_reject' => $total_reject + $loop,
           'target_terpenuhi' => $target_terpenuhi + $loop
       ];
       LineDetail::whereId($id)->update($update);
       // end update 

       $kerjakan = LineToTarget::with('detail')->findOrFail($target_id);

       return redirect()->back()->with('kerjakan');
    }

    public function meas(Request $request, $id)
    {
         //Untuk Return Back 
       $target_id = $request->target_id;

       //data yang akan di olah 
       $target_terpenuhi = LineDetail::where('id', $id)->get()->sum('target_terpenuhi');
       $total_check = LineDetail::where('id', $id)->get()->sum('total_check');
       $total_reject = LineDetail::where('id', $id)->get()->sum('total_reject');
       $fg = LineDetail::where('id', $id)->get()->sum('fg');
       $broken = LineDetail::where('id', $id)->get()->sum('broken');
       $skip = LineDetail::where('id', $id)->get()->sum('skip');
       $pktw = LineDetail::where('id', $id)->get()->sum('pktw');
       $crooked = LineDetail::where('id', $id)->get()->sum('crooked');
       $pleated = LineDetail::where('id', $id)->get()->sum('pleated');
       $ros = LineDetail::where('id', $id)->get()->sum('ros');
       $htl = LineDetail::where('id', $id)->get()->sum('htl');
       $button = LineDetail::where('id', $id)->get()->sum('button');
       $print = LineDetail::where('id', $id)->get()->sum('print');
       $bs = LineDetail::where('id', $id)->get()->sum('bs');
       $unb = LineDetail::where('id', $id)->get()->sum('unb');
       $shading = LineDetail::where('id', $id)->get()->sum('shading');
       $dof = LineDetail::where('id', $id)->get()->sum('dof');
       $dirty = LineDetail::where('id', $id)->get()->sum('dirty');
       $shiny = LineDetail::where('id', $id)->get()->sum('shiny');
       $sticker = LineDetail::where('id', $id)->get()->sum('sticker');
       $trimming = LineDetail::where('id', $id)->get()->sum('trimming');
       $ip = LineDetail::where('id', $id)->get()->sum('ip');
       $meas = LineDetail::where('id', $id)->get()->sum('meas');
       $other = LineDetail::where('id', $id)->get()->sum('other');

       // untuk olah data 
       $loop = 1;
       $dataMeas = $meas + $loop;
       $pembagi = $target_terpenuhi + $loop;
       $reject = round(($total_reject + $loop) / ($target_terpenuhi + $loop) *100,2);

       // data untuk persen 
       if ($target_terpenuhi == 0) {
           $p_fg = 0;
           $p_broken = 0;
           $p_skip = 0;
           $p_pktw = 0;
           $p_crooked = 0;
           $p_pleated= 0;
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
           $p_meas = 100;
           $p_other = 0;
       }else{
           $p_fg = round($fg / $pembagi * 100,2);
           $p_broken = round($broken / $pembagi * 100,2);
           $p_skip = round($skip / $pembagi * 100,2);
           $p_pktw = round($pktw / $pembagi * 100,2);
           $p_crooked = round($crooked / $pembagi * 100,2);
           $p_pleated = round($pleated / $pembagi * 100,2);
           $p_ros = round($ros / $pembagi * 100,2);
           $p_htl = round($htl / $pembagi * 100,2);
           $p_button = round($button / $pembagi * 100,2);
           $p_print = round($print / $pembagi * 100,2);
           $p_bs = round($bs / $pembagi * 100,2);
           $p_unb = round($unb / $pembagi * 100,2);
           $p_shading = round($shading / $pembagi * 100,2);
           $p_dof = round($dof / $pembagi * 100,2);
           $p_dirty = round($dirty / $pembagi * 100,2);
           $p_shiny = round($shiny / $pembagi * 100,2);
           $p_sticker = round($sticker / $pembagi * 100,2);
           $p_trimming = round($trimming / $pembagi * 100,2);
           $p_ip = round($ip / $pembagi * 100,2);
           $p_meas = round($dataMeas / $pembagi * 100,2);
           $p_other = round($other / $pembagi * 100,2);
       }

       //Update data FG di database
       $update = [
           'meas' => $dataMeas,
           'p_fg' => $p_fg,
           'p_broken' => $p_broken,
           'p_skip' => $p_skip,
           'p_pktw' => $p_pktw,
           'p_crooked' => $p_crooked,
           'p_pleated' => $p_pleated,
           'p_ros' => $p_ros,
           'p_htl' => $p_htl,
           'p_button' => $p_button,
           'p_print' => $p_print,
           'p_bs' => $p_bs,
           'p_unb' => $p_unb,
           'p_shading' => $p_shading,
           'p_dof' => $p_dof,
           'p_dirty' => $p_dirty,
           'p_shiny' => $p_shiny,
           'p_sticker' => $p_sticker,
           'p_trimming' => $p_trimming,
           'p_ip' => $p_ip,
           'p_meas' => $p_meas,
           'p_other' => $p_other,
           'p_reject' => $reject,
           'total_check' => $total_check + $loop,
           'total_reject' => $total_reject + $loop,
           'target_terpenuhi' => $target_terpenuhi + $loop
       ];
       LineDetail::whereId($id)->update($update);
       // end update 

       $kerjakan = LineToTarget::with('detail')->findOrFail($target_id);

       return redirect()->back()->with('kerjakan');
    }
    
    public function hapus(Request $request, $id)
    {
        // hapus file
        $detail = LineDetail::where('id',$id)->first();
        File::delete('rework/qc/images/'.$detail->file);

        $updateFile = [
            'file' => null
        ];

        LineDetail::whereId($id)->update($updateFile);

        return redirect()->back()->with('kerjakan');
    }

    public function file(Request $request, $id)
    {
        $this->validate($request, [
			'file' => 'required|file|image|mimes:jpeg,png,jpg|max:5120',
		]);

        // menyimpan data file yang diupload ke variabel $file
		$file = $request->file('file');

		$nama_file = time()."_".$file->getClientOriginalName();
       

        // isi dengan nama folder tempat kemana file diupload
		$tujuan_upload = 'rework/qc/images';
        
		$file->move($tujuan_upload,$nama_file);
        $update = [
            'file' => $nama_file,
        ];

        LineDetail::whereId($id)->update($update);

        // dd($request);
        $target_id = $request->target_id;
        $kerjakan = LineToTarget::with('detail')->findOrFail($target_id);

        return redirect()->back()->with('kerjakan');
    }

    public function selesai(Request $request)
    {
        $target_id = $request->target_id;
        
        // Update proses id 
        $updateProses= [
            'proses' => 2
        ];
        LineToTarget::whereId($target_id)->update($updateProses);
        // end 

        $kerjakan = LineToTarget::with('detail')->findOrFail($target_id);

        return view('qc/rework/qc/selesai', compact('kerjakan'));
    }

    public function remark(Request $request, $id)
    {
        $target_id = $request->target_id;
        
        //Update data remark di tabel rework detail
        $updateRemark = [
            'string1' => $request->string1
        ];

        LineDetail::whereId($id)->update($updateRemark);
        // end

        $kerjakan = LineToTarget::with('detail')->findOrFail($target_id);

        return redirect()->back()->with('kerjakan');
    }

}
