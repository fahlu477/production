<?php

namespace App\Http\Controllers\Line;

use PDF;
use Carbon\Carbon;
use App\MasterLine;
use App\LineDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportAllFasilitasController extends Controller
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

    public function tahunan()
    {
        return view('qc/rework/report/TahunanAll');
    }

    public function harian()
    {
        return view('qc/rework/report/HarianAll');
    }

    public function getTahunan(Request $request)
    {
        $tahun = $request->tahun;
        // dd($tahun);
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

        // untuk pabrik cileunyi
        $bCLN = 'CLN';
        $bdCLN = 'CLN';
        $dataCLN =  MasterLine::where('branch', $bCLN)
                ->where('branch_detail', $bdCLN)
                ->get(); 
        $detail = LineDetail::all();
        // untuk mendapat nilai tiap bulan di cileunyi 
        $ResumeCLN = [];
        foreach ($dataCLN as $key => $value) {
            foreach ($detail as $key2 => $value2) {
                if($value->id == $value2->id_line){
                    $janTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('target_terpenuhi');
                    $janReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('total_reject');
                    $febTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('target_terpenuhi');
                    $febReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('total_reject');
                    $marTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('target_terpenuhi');
                    $marReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('total_reject');
                    $aprTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('target_terpenuhi');
                    $aprReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('total_reject');
                    $meiTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('target_terpenuhi');
                    $meiReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('total_reject');
                    $junTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('target_terpenuhi');
                    $junReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('total_reject');
                    $julTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('target_terpenuhi');
                    $julReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('total_reject');
                    $agsTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('target_terpenuhi');
                    $agsReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('total_reject');
                    $sepTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('target_terpenuhi');
                    $sepReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('total_reject');
                    $oktTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('target_terpenuhi');
                    $oktReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('total_reject');
                    $novTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('target_terpenuhi');
                    $novReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('total_reject');
                    $desTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('target_terpenuhi');
                    $desReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('total_reject');
                    $ResumeCLN[] = [
                        'id_line' => $value2->id_line,
                        'janTerpenuhi' => $janTerpenuhi,
                        'janReject' => $janReject,
                        'febTerpenuhi' => $febTerpenuhi,
                        'febReject' => $febReject,
                        'marTerpenuhi' => $marTerpenuhi,
                        'marReject' => $marReject,
                        'aprTerpenuhi' => $aprTerpenuhi,
                        'aprReject' => $aprReject,
                        'meiTerpenuhi' => $meiTerpenuhi,
                        'meiReject' => $meiReject,
                        'junTerpenuhi' => $junTerpenuhi,
                        'junReject' => $junReject,
                        'julTerpenuhi' => $julTerpenuhi,
                        'julReject' => $julReject,
                        'agsTerpenuhi' => $agsTerpenuhi,
                        'agsReject' => $agsReject,
                        'sepTerpenuhi' => $sepTerpenuhi,
                        'sepReject' => $sepReject,
                        'oktTerpenuhi' => $oktTerpenuhi,
                        'oktReject' => $oktReject,
                        'novTerpenuhi' => $novTerpenuhi,
                        'novReject' => $novReject,
                        'desTerpenuhi' => $desTerpenuhi,
                        'desReject' => $desReject,
                        'file' => $value2->file
                    ];
                }
            }
        }
        // groupby berdasarkan id line 
        $totalCLN = collect($ResumeCLN)
                    ->groupBy('id_line')
                    ->map(function ($item) {
                        return array_merge(...$item->toArray());
                    })->values()->toArray();
        // untuk foto di lampiran
        $FotoCLN = collect($ResumeCLN)
                    ->where('file','!=', null)
                    ->groupBy('id_line')
                    ->map(function ($item) {
                        return array_merge(...$item->toArray());
                    })->values()->toArray();
        if($FotoCLN != null){
            $FinalFotoCLN = $FotoCLN[0];
        }else{
            $FinalFotoCLN = [
                'file' => null
            ];
        }

        // untuk mendapat data total tiap bulan dari pabrik cileunyi 
        $janCLNReject = collect($totalCLN)->sum('janReject');
        $janCLNTerpenuhi = collect($totalCLN)->sum('janTerpenuhi');
        $febCLNReject = collect($totalCLN)->sum('febReject');
        $febCLNTerpenuhi = collect($totalCLN)->sum('febTerpenuhi');
        $marCLNReject = collect($totalCLN)->sum('marReject');
        $marCLNTerpenuhi = collect($totalCLN)->sum('marTerpenuhi');
        $aprCLNReject = collect($totalCLN)->sum('aprReject');
        $aprCLNTerpenuhi = collect($totalCLN)->sum('aprTerpenuhi');
        $meiCLNReject = collect($totalCLN)->sum('meiReject');
        $meiCLNTerpenuhi = collect($totalCLN)->sum('meiTerpenuhi');
        $junCLNReject = collect($totalCLN)->sum('junReject');
        $junCLNTerpenuhi = collect($totalCLN)->sum('junTerpenuhi');
        $julCLNReject = collect($totalCLN)->sum('julReject');
        $julCLNTerpenuhi = collect($totalCLN)->sum('julTerpenuhi');
        $agsCLNReject = collect($totalCLN)->sum('agsReject');
        $agsCLNTerpenuhi = collect($totalCLN)->sum('agsTerpenuhi');
        $sepCLNReject = collect($totalCLN)->sum('sepReject');
        $sepCLNTerpenuhi = collect($totalCLN)->sum('sepTerpenuhi');
        $oktCLNReject = collect($totalCLN)->sum('oktReject');
        $oktCLNTerpenuhi = collect($totalCLN)->sum('oktTerpenuhi');
        $novCLNReject = collect($totalCLN)->sum('novReject');
        $novCLNTerpenuhi = collect($totalCLN)->sum('novTerpenuhi');
        $desCLNReject = collect($totalCLN)->sum('desReject');
        $desCLNTerpenuhi = collect($totalCLN)->sum('desTerpenuhi');
       
        // untuk mendapat nilai persentase 
        if ($janCLNTerpenuhi != 0){
            $janClnTotReject = round($janCLNReject/$janCLNTerpenuhi*100,2);
        }else{
            $janClnTotReject = 0;
        }
        if ($febCLNTerpenuhi != 0){
            $febClnTotReject = round($febCLNReject/$febCLNTerpenuhi*100,2);
        }else{
            $febClnTotReject = 0;
        }
        if ($marCLNTerpenuhi != 0){
            $marClnTotReject = round($marCLNReject/$marCLNTerpenuhi*100,2);
        }else{
            $marClnTotReject = 0;
        }
        if ($aprCLNTerpenuhi != 0){
            $aprClnTotReject = round($aprCLNReject/$aprCLNTerpenuhi*100,2);
        }else{
            $aprClnTotReject = 0;
        }
        if ($meiCLNTerpenuhi != 0){
            $meiClnTotReject = round($meiCLNReject/$meiCLNTerpenuhi*100,2);
        }else{
            $meiClnTotReject = 0;
        }
        if ($junCLNTerpenuhi != 0){
            $junClnTotReject = round($junCLNReject/$junCLNTerpenuhi*100,2);
        }else{
            $junClnTotReject = 0;
        }
        if ($julCLNTerpenuhi != 0){
            $julClnTotReject = round($julCLNReject/$julCLNTerpenuhi*100,2);
        }else{
            $julClnTotReject = 0;
        }
        if ($agsCLNTerpenuhi != 0){
            $agsClnTotReject = round($agsCLNReject/$agsCLNTerpenuhi*100,2);
        }else{
            $agsClnTotReject = 0;
        }
        if ($sepCLNTerpenuhi != 0){
            $sepClnTotReject = round($sepCLNReject/$sepCLNTerpenuhi*100,2);
        }else{
            $sepClnTotReject = 0;
        }
        if ($oktCLNTerpenuhi != 0){
            $oktClnTotReject = round($oktCLNReject/$oktCLNTerpenuhi*100,2);
        }else{
            $oktClnTotReject = 0;
        }
        if ($novCLNTerpenuhi != 0){
            $novClnTotReject = round($novCLNReject/$novCLNTerpenuhi*100,2);
        }else{
            $novClnTotReject = 0;
        }
        if ($desCLNTerpenuhi != 0){
            $desClnTotReject = round($desCLNReject/$desCLNTerpenuhi*100,2);
        }else{
            $desClnTotReject = 0;
        }
        
        // untuk data total 
        $totalCLNReject = ($janCLNReject + $febCLNReject + $marCLNReject + $aprCLNReject
                        + $meiCLNReject + $junCLNReject + $julCLNReject + $agsCLNReject
                        + $sepCLNReject + $oktCLNReject + $novCLNReject + $desCLNReject);

        $totalCLNTerpenuhi = ($janCLNTerpenuhi + $febCLNTerpenuhi + $marCLNTerpenuhi + $aprCLNTerpenuhi
                        + $meiCLNTerpenuhi + $junCLNTerpenuhi + $julCLNTerpenuhi + $agsCLNTerpenuhi
                        + $sepCLNTerpenuhi + $oktCLNTerpenuhi + $novCLNTerpenuhi + $desCLNTerpenuhi);
        
        if($totalCLNTerpenuhi != 0){
            $totalTOTCLN = round($totalCLNReject/$totalCLNTerpenuhi*100,2);
        }else{
            $totalTOTCLN = 0;
        }
        
        // final data untuk cileunyi 
        $FinalDataCLN = [
            'janReject' => $janCLNReject,
            'janCLNTOTReject' => $janClnTotReject,
            'febReject' => $febCLNReject,
            'febCLNTOTReject' => $febClnTotReject,
            'marReject' => $marCLNReject,
            'marCLNTOTReject' => $marClnTotReject,
            'aprReject' => $aprCLNReject,
            'aprCLNTOTReject' => $aprClnTotReject,
            'meiReject' => $meiCLNReject,
            'meiCLNTOTReject' => $meiClnTotReject,
            'junReject' => $junCLNReject,
            'junCLNTOTReject' => $junClnTotReject,
            'julReject' => $julCLNReject,
            'julCLNTOTReject' => $julClnTotReject,
            'agsReject' => $agsCLNReject,
            'agsCLNTOTReject' => $agsClnTotReject,
            'sepReject' => $sepCLNReject,
            'sepCLNTOTReject' => $sepClnTotReject,
            'oktReject' => $oktCLNReject,
            'oktCLNTOTReject' => $oktClnTotReject,
            'novReject' => $novCLNReject,
            'novCLNTOTReject' => $novClnTotReject,
            'desReject' => $desCLNReject,
            'desCLNTOTReject' => $desClnTotReject,
            'totalRejectCLN' => $totalCLNReject,
            'totalTOTCLN' => $totalTOTCLN,
        ];

        // untuk pabrik majalengka 1
        $bGM1 = 'MAJA';
        $bdGM1 = 'GM1';
        $dataGM1 =  MasterLine::where('branch', $bGM1)
                ->where('branch_detail', $bdGM1)
                ->get(); 
        $detail = LineDetail::all();
        // untuk mendapat nilai tiap bulan di majalengka 1 
        $ResumeGM1 = [];
        foreach ($dataGM1 as $key => $value) {
            foreach ($detail as $key2 => $value2) {
                if($value->id == $value2->id_line){
                    $janTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('target_terpenuhi');
                    $janReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('total_reject');
                    $febTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('target_terpenuhi');
                    $febReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('total_reject');
                    $marTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('target_terpenuhi');
                    $marReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('total_reject');
                    $aprTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('target_terpenuhi');
                    $aprReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('total_reject');
                    $meiTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('target_terpenuhi');
                    $meiReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('total_reject');
                    $junTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('target_terpenuhi');
                    $junReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('total_reject');
                    $julTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('target_terpenuhi');
                    $julReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('total_reject');
                    $agsTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('target_terpenuhi');
                    $agsReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('total_reject');
                    $sepTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('target_terpenuhi');
                    $sepReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('total_reject');
                    $oktTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('target_terpenuhi');
                    $oktReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('total_reject');
                    $novTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('target_terpenuhi');
                    $novReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('total_reject');
                    $desTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('target_terpenuhi');
                    $desReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('total_reject');
                    $ResumeGM1[] = [
                        'id_line' => $value2->id_line,
                        'janTerpenuhi' => $janTerpenuhi,
                        'janReject' => $janReject,
                        'febTerpenuhi' => $febTerpenuhi,
                        'febReject' => $febReject,
                        'marTerpenuhi' => $marTerpenuhi,
                        'marReject' => $marReject,
                        'aprTerpenuhi' => $aprTerpenuhi,
                        'aprReject' => $aprReject,
                        'meiTerpenuhi' => $meiTerpenuhi,
                        'meiReject' => $meiReject,
                        'junTerpenuhi' => $junTerpenuhi,
                        'junReject' => $junReject,
                        'julTerpenuhi' => $julTerpenuhi,
                        'julReject' => $julReject,
                        'agsTerpenuhi' => $agsTerpenuhi,
                        'agsReject' => $agsReject,
                        'sepTerpenuhi' => $sepTerpenuhi,
                        'sepReject' => $sepReject,
                        'oktTerpenuhi' => $oktTerpenuhi,
                        'oktReject' => $oktReject,
                        'novTerpenuhi' => $novTerpenuhi,
                        'novReject' => $novReject,
                        'desTerpenuhi' => $desTerpenuhi,
                        'desReject' => $desReject,
                        'file' => $value2->file
                    ];
                }
            }
        }
        // groupby berdasarkan id line 
        $totalGM1 = collect($ResumeGM1)
                    ->groupBy('id_line')
                    ->map(function ($item) {
                        return array_merge(...$item->toArray());
                    })->values()->toArray();
        // untuk foto di lampiran
        $FotoGM1 = collect($ResumeGM1)
                    ->where('file','!=', null)
                    ->groupBy('id_line')
                    ->map(function ($item) {
                        return array_merge(...$item->toArray());
                    })->values()->toArray();
        if($FotoGM1 != null){
            $FinalFotoGM1 = $FotoGM1[0];
        }else{
            $FinalFotoGM1 = [
                'file' => null
            ];
        }

        // untuk mendapat data total tiap bulan dari pabrik majalengka1
        $janGM1Reject = collect($totalGM1)->sum('janReject');
        $janGM1Terpenuhi = collect($totalGM1)->sum('janTerpenuhi');
        $febGM1Reject = collect($totalGM1)->sum('febReject');
        $febGM1Terpenuhi = collect($totalGM1)->sum('febTerpenuhi');
        $marGM1Reject = collect($totalGM1)->sum('marReject');
        $marGM1Terpenuhi = collect($totalGM1)->sum('marTerpenuhi');
        $aprGM1Reject = collect($totalGM1)->sum('aprReject');
        $aprGM1Terpenuhi = collect($totalGM1)->sum('aprTerpenuhi');
        $meiGM1Reject = collect($totalGM1)->sum('meiReject');
        $meiGM1Terpenuhi = collect($totalGM1)->sum('meiTerpenuhi');
        $junGM1Reject = collect($totalGM1)->sum('junReject');
        $junGM1Terpenuhi = collect($totalGM1)->sum('junTerpenuhi');
        $julGM1Reject = collect($totalGM1)->sum('julReject');
        $julGM1Terpenuhi = collect($totalGM1)->sum('julTerpenuhi');
        $agsGM1Reject = collect($totalGM1)->sum('agsReject');
        $agsGM1Terpenuhi = collect($totalGM1)->sum('agsTerpenuhi');
        $sepGM1Reject = collect($totalGM1)->sum('sepReject');
        $sepGM1Terpenuhi = collect($totalGM1)->sum('sepTerpenuhi');
        $oktGM1Reject = collect($totalGM1)->sum('oktReject');
        $oktGM1Terpenuhi = collect($totalGM1)->sum('oktTerpenuhi');
        $novGM1Reject = collect($totalGM1)->sum('novReject');
        $novGM1Terpenuhi = collect($totalGM1)->sum('novTerpenuhi');
        $desGM1Reject = collect($totalGM1)->sum('desReject');
        $desGM1Terpenuhi = collect($totalGM1)->sum('desTerpenuhi');
       
        // untuk mendapat nilai persentase 
        if ($janGM1Terpenuhi != 0){
            $janGM1TotReject = round($janGM1Reject/$janGM1Terpenuhi*100,2);
        }else{
            $janGM1TotReject = 0;
        }
        if ($febGM1Terpenuhi != 0){
            $febGM1TotReject = round($febGM1Reject/$febGM1Terpenuhi*100,2);
        }else{
            $febGM1TotReject = 0;
        }
        if ($marGM1Terpenuhi != 0){
            $marGM1TotReject = round($marGM1Reject/$marGM1Terpenuhi*100,2);
        }else{
            $marGM1TotReject = 0;
        }
        if ($aprGM1Terpenuhi != 0){
            $aprGM1TotReject = round($aprGM1Reject/$aprGM1Terpenuhi*100,2);
        }else{
            $aprGM1TotReject = 0;
        }
        if ($meiGM1Terpenuhi != 0){
            $meiGM1TotReject = round($meiGM1Reject/$meiGM1Terpenuhi*100,2);
        }else{
            $meiGM1TotReject = 0;
        }
        if ($junGM1Terpenuhi != 0){
            $junGM1TotReject = round($junGM1Reject/$junGM1Terpenuhi*100,2);
        }else{
            $junGM1TotReject = 0;
        }
        if ($julGM1Terpenuhi != 0){
            $julGM1TotReject = round($julGM1Reject/$julGM1Terpenuhi*100,2);
        }else{
            $julGM1TotReject = 0;
        }
        if ($agsGM1Terpenuhi != 0){
            $agsGM1TotReject = round($agsGM1Reject/$agsGM1Terpenuhi*100,2);
        }else{
            $agsGM1TotReject = 0;
        }
        if ($sepGM1Terpenuhi != 0){
            $sepGM1TotReject = round($sepGM1Reject/$sepGM1Terpenuhi*100,2);
        }else{
            $sepGM1TotReject = 0;
        }
        if ($oktGM1Terpenuhi != 0){
            $oktGM1TotReject = round($oktGM1Reject/$oktGM1Terpenuhi*100,2);
        }else{
            $oktGM1TotReject = 0;
        }
        if ($novGM1Terpenuhi != 0){
            $novGM1TotReject = round($novGM1Reject/$novGM1Terpenuhi*100,2);
        }else{
            $novGM1TotReject = 0;
        }
        if ($desGM1Terpenuhi != 0){
            $desGM1TotReject = round($desGM1Reject/$desGM1Terpenuhi*100,2);
        }else{
            $desGM1TotReject = 0;
        }
        
        // untuk data total 
        $totalGM1Reject = ($janGM1Reject + $febGM1Reject + $marGM1Reject + $aprGM1Reject
                        + $meiGM1Reject + $junGM1Reject + $julGM1Reject + $agsGM1Reject
                        + $sepGM1Reject + $oktGM1Reject + $novGM1Reject + $desGM1Reject);

        $totalGM1Terpenuhi = ($janGM1Terpenuhi + $febGM1Terpenuhi + $marGM1Terpenuhi + $aprGM1Terpenuhi
                        + $meiGM1Terpenuhi + $junGM1Terpenuhi + $julGM1Terpenuhi + $agsGM1Terpenuhi
                        + $sepGM1Terpenuhi + $oktGM1Terpenuhi + $novGM1Terpenuhi + $desGM1Terpenuhi);
        
        if($totalGM1Terpenuhi != 0){
            $totalTOTGM1 = round($totalGM1Reject/$totalGM1Terpenuhi*100,2);
        }else{
            $totalTOTGM1 = 0;
        }
        
        // final data untuk majalengka 1
        $FinalDataGM1 = [
            'janReject' => $janGM1Reject,
            'janGM1TOTReject' => $janGM1TotReject,
            'febReject' => $febGM1Reject,
            'febGM1TOTReject' => $febGM1TotReject,
            'marReject' => $marGM1Reject,
            'marGM1TOTReject' => $marGM1TotReject,
            'aprReject' => $aprGM1Reject,
            'aprGM1TOTReject' => $aprGM1TotReject,
            'meiReject' => $meiGM1Reject,
            'meiGM1TOTReject' => $meiGM1TotReject,
            'junReject' => $junGM1Reject,
            'junGM1TOTReject' => $junGM1TotReject,
            'julReject' => $julGM1Reject,
            'julGM1TOTReject' => $julGM1TotReject,
            'agsReject' => $agsGM1Reject,
            'agsGM1TOTReject' => $agsGM1TotReject,
            'sepReject' => $sepGM1Reject,
            'sepGM1TOTReject' => $sepGM1TotReject,
            'oktReject' => $oktGM1Reject,
            'oktGM1TOTReject' => $oktGM1TotReject,
            'novReject' => $novGM1Reject,
            'novGM1TOTReject' => $novGM1TotReject,
            'desReject' => $desGM1Reject,
            'desGM1TOTReject' => $desGM1TotReject,
            'totalRejectGM1' => $totalGM1Reject,
            'totalTOTGM1' => $totalTOTGM1,
        ];

        // untuk pabrik majalengka 2
        $bGM2 = 'MAJA';
        $bdGM2 = 'GM2';
        $dataGM2 =  MasterLine::where('branch', $bGM2)
                ->where('branch_detail', $bdGM2)
                ->get(); 
        $detail = LineDetail::all();
        // untuk mendapat nilai tiap bulan di majalengka 2
        $ResumeGM2 = [];
        foreach ($dataGM2 as $key => $value) {
            foreach ($detail as $key2 => $value2) {
                if($value->id == $value2->id_line){
                    $janTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('target_terpenuhi');
                    $janReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('total_reject');
                    $febTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('target_terpenuhi');
                    $febReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('total_reject');
                    $marTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('target_terpenuhi');
                    $marReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('total_reject');
                    $aprTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('target_terpenuhi');
                    $aprReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('total_reject');
                    $meiTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('target_terpenuhi');
                    $meiReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('total_reject');
                    $junTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('target_terpenuhi');
                    $junReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('total_reject');
                    $julTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('target_terpenuhi');
                    $julReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('total_reject');
                    $agsTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('target_terpenuhi');
                    $agsReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('total_reject');
                    $sepTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('target_terpenuhi');
                    $sepReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('total_reject');
                    $oktTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('target_terpenuhi');
                    $oktReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('total_reject');
                    $novTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('target_terpenuhi');
                    $novReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('total_reject');
                    $desTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('target_terpenuhi');
                    $desReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('total_reject');
                    $ResumeGM2[] = [
                        'id_line' => $value2->id_line,
                        'janTerpenuhi' => $janTerpenuhi,
                        'janReject' => $janReject,
                        'febTerpenuhi' => $febTerpenuhi,
                        'febReject' => $febReject,
                        'marTerpenuhi' => $marTerpenuhi,
                        'marReject' => $marReject,
                        'aprTerpenuhi' => $aprTerpenuhi,
                        'aprReject' => $aprReject,
                        'meiTerpenuhi' => $meiTerpenuhi,
                        'meiReject' => $meiReject,
                        'junTerpenuhi' => $junTerpenuhi,
                        'junReject' => $junReject,
                        'julTerpenuhi' => $julTerpenuhi,
                        'julReject' => $julReject,
                        'agsTerpenuhi' => $agsTerpenuhi,
                        'agsReject' => $agsReject,
                        'sepTerpenuhi' => $sepTerpenuhi,
                        'sepReject' => $sepReject,
                        'oktTerpenuhi' => $oktTerpenuhi,
                        'oktReject' => $oktReject,
                        'novTerpenuhi' => $novTerpenuhi,
                        'novReject' => $novReject,
                        'desTerpenuhi' => $desTerpenuhi,
                        'desReject' => $desReject,
                        'file' => $value2->file
                    ];
                }
            }
        }
        // groupby berdasarkan id line 
        $totalGM2 = collect($ResumeGM2)
                    ->groupBy('id_line')
                    ->map(function ($item) {
                        return array_merge(...$item->toArray());
                    })->values()->toArray();
        // untuk foto di lampiran
        $FotoGM2 = collect($ResumeGM2)
        ->where('file','!=', null)
        ->groupBy('id_line')
        ->map(function ($item) {
            return array_merge(...$item->toArray());
        })->values()->toArray();
        if($FotoGM2 != null){
            $FinalFotoGM2 = $FotoGM2[0];
        }else{
            $FinalFotoGM2 = [
                'file' => null
            ];
        }
        

        // untuk mendapat data total tiap bulan dari pabrik majalengka2
        $janGM2Reject = collect($totalGM2)->sum('janReject');
        $janGM2Terpenuhi = collect($totalGM2)->sum('janTerpenuhi');
        $febGM2Reject = collect($totalGM2)->sum('febReject');
        $febGM2Terpenuhi = collect($totalGM2)->sum('febTerpenuhi');
        $marGM2Reject = collect($totalGM2)->sum('marReject');
        $marGM2Terpenuhi = collect($totalGM2)->sum('marTerpenuhi');
        $aprGM2Reject = collect($totalGM2)->sum('aprReject');
        $aprGM2Terpenuhi = collect($totalGM2)->sum('aprTerpenuhi');
        $meiGM2Reject = collect($totalGM2)->sum('meiReject');
        $meiGM2Terpenuhi = collect($totalGM2)->sum('meiTerpenuhi');
        $junGM2Reject = collect($totalGM2)->sum('junReject');
        $junGM2Terpenuhi = collect($totalGM2)->sum('junTerpenuhi');
        $julGM2Reject = collect($totalGM2)->sum('julReject');
        $julGM2Terpenuhi = collect($totalGM2)->sum('julTerpenuhi');
        $agsGM2Reject = collect($totalGM2)->sum('agsReject');
        $agsGM2Terpenuhi = collect($totalGM2)->sum('agsTerpenuhi');
        $sepGM2Reject = collect($totalGM2)->sum('sepReject');
        $sepGM2Terpenuhi = collect($totalGM2)->sum('sepTerpenuhi');
        $oktGM2Reject = collect($totalGM2)->sum('oktReject');
        $oktGM2Terpenuhi = collect($totalGM2)->sum('oktTerpenuhi');
        $novGM2Reject = collect($totalGM2)->sum('novReject');
        $novGM2Terpenuhi = collect($totalGM2)->sum('novTerpenuhi');
        $desGM2Reject = collect($totalGM2)->sum('desReject');
        $desGM2Terpenuhi = collect($totalGM2)->sum('desTerpenuhi');
       
        // untuk mendapat nilai persentase 
        if ($janGM2Terpenuhi != 0){
            $janGM2TotReject = round($janGM2Reject/$janGM2Terpenuhi*100,2);
        }else{
            $janGM2TotReject = 0;
        }
        if ($febGM2Terpenuhi != 0){
            $febGM2TotReject = round($febGM2Reject/$febGM2Terpenuhi*100,2);
        }else{
            $febGM2TotReject = 0;
        }
        if ($marGM2Terpenuhi != 0){
            $marGM2TotReject = round($marGM2Reject/$marGM2Terpenuhi*100,2);
        }else{
            $marGM2TotReject = 0;
        }
        if ($aprGM2Terpenuhi != 0){
            $aprGM2TotReject = round($aprGM2Reject/$aprGM2Terpenuhi*100,2);
        }else{
            $aprGM2TotReject = 0;
        }
        if ($meiGM2Terpenuhi != 0){
            $meiGM2TotReject = round($meiGM2Reject/$meiGM2Terpenuhi*100,2);
        }else{
            $meiGM2TotReject = 0;
        }
        if ($junGM2Terpenuhi != 0){
            $junGM2TotReject = round($junGM2Reject/$junGM2Terpenuhi*100,2);
        }else{
            $junGM2TotReject = 0;
        }
        if ($julGM2Terpenuhi != 0){
            $julGM2TotReject = round($julGM2Reject/$julGM2Terpenuhi*100,2);
        }else{
            $julGM2TotReject = 0;
        }
        if ($agsGM2Terpenuhi != 0){
            $agsGM2TotReject = round($agsGM2Reject/$agsGM2Terpenuhi*100,2);
        }else{
            $agsGM2TotReject = 0;
        }
        if ($sepGM2Terpenuhi != 0){
            $sepGM2TotReject = round($sepGM2Reject/$sepGM2Terpenuhi*100,2);
        }else{
            $sepGM2TotReject = 0;
        }
        if ($oktGM2Terpenuhi != 0){
            $oktGM2TotReject = round($oktGM2Reject/$oktGM2Terpenuhi*100,2);
        }else{
            $oktGM2TotReject = 0;
        }
        if ($novGM2Terpenuhi != 0){
            $novGM2TotReject = round($novGM2Reject/$novGM2Terpenuhi*100,2);
        }else{
            $novGM2TotReject = 0;
        }
        if ($desGM2Terpenuhi != 0){
            $desGM2TotReject = round($desGM2Reject/$desGM2Terpenuhi*100,2);
        }else{
            $desGM2TotReject = 0;
        }
        
        // untuk data total 
        $totalGM2Reject = ($janGM2Reject + $febGM2Reject + $marGM2Reject + $aprGM2Reject
                        + $meiGM2Reject + $junGM2Reject + $julGM2Reject + $agsGM2Reject
                        + $sepGM2Reject + $oktGM2Reject + $novGM2Reject + $desGM2Reject);

        $totalGM2Terpenuhi = ($janGM2Terpenuhi + $febGM2Terpenuhi + $marGM2Terpenuhi + $aprGM2Terpenuhi
                        + $meiGM2Terpenuhi + $junGM2Terpenuhi + $julGM2Terpenuhi + $agsGM2Terpenuhi
                        + $sepGM2Terpenuhi + $oktGM2Terpenuhi + $novGM2Terpenuhi + $desGM2Terpenuhi);
        
        if($totalGM2Terpenuhi != 0){
            $totalTOTGM2 = round($totalGM2Reject/$totalGM2Terpenuhi*100,2);
        }else{
            $totalTOTGM2 = 0;
        }
        
        // final data untuk majalengka 2
        $FinalDataGM2 = [
            'janReject' => $janGM2Reject,
            'janGM2TOTReject' => $janGM2TotReject,
            'febReject' => $febGM2Reject,
            'febGM2TOTReject' => $febGM2TotReject,
            'marReject' => $marGM2Reject,
            'marGM2TOTReject' => $marGM2TotReject,
            'aprReject' => $aprGM2Reject,
            'aprGM2TOTReject' => $aprGM2TotReject,
            'meiReject' => $meiGM2Reject,
            'meiGM2TOTReject' => $meiGM2TotReject,
            'junReject' => $junGM2Reject,
            'junGM2TOTReject' => $junGM2TotReject,
            'julReject' => $julGM2Reject,
            'julGM2TOTReject' => $julGM2TotReject,
            'agsReject' => $agsGM2Reject,
            'agsGM2TOTReject' => $agsGM2TotReject,
            'sepReject' => $sepGM2Reject,
            'sepGM2TOTReject' => $sepGM2TotReject,
            'oktReject' => $oktGM2Reject,
            'oktGM2TOTReject' => $oktGM2TotReject,
            'novReject' => $novGM2Reject,
            'novGM2TOTReject' => $novGM2TotReject,
            'desReject' => $desGM2Reject,
            'desGM2TOTReject' => $desGM2TotReject,
            'totalRejectGM2' => $totalGM2Reject,
            'totalTOTGM2' => $totalTOTGM2,
        ];

        return view('qc/rework/report/rAllTahunan', compact('FinalFotoCLN', 'FinalFotoGM1', 'FinalFotoGM2', 'FinalDataCLN', 'FinalDataGM1', 'FinalDataGM2', 'tahun'));
        
    }

    public function AllTahunanPDF(Request $request)
    {
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

        // untuk pabrik cileunyi
        $bCLN = 'CLN';
        $bdCLN = 'CLN';
        $dataCLN =  MasterLine::where('branch', $bCLN)
                ->where('branch_detail', $bdCLN)
                ->get(); 
        $detail = LineDetail::all();
        // untuk mendapat nilai tiap bulan di cileunyi 
        $ResumeCLN = [];
        foreach ($dataCLN as $key => $value) {
            foreach ($detail as $key2 => $value2) {
                if($value->id == $value2->id_line){
                    $janTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('target_terpenuhi');
                    $janReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('total_reject');
                    $febTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('target_terpenuhi');
                    $febReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('total_reject');
                    $marTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('target_terpenuhi');
                    $marReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('total_reject');
                    $aprTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('target_terpenuhi');
                    $aprReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('total_reject');
                    $meiTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('target_terpenuhi');
                    $meiReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('total_reject');
                    $junTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('target_terpenuhi');
                    $junReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('total_reject');
                    $julTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('target_terpenuhi');
                    $julReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('total_reject');
                    $agsTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('target_terpenuhi');
                    $agsReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('total_reject');
                    $sepTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('target_terpenuhi');
                    $sepReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('total_reject');
                    $oktTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('target_terpenuhi');
                    $oktReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('total_reject');
                    $novTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('target_terpenuhi');
                    $novReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('total_reject');
                    $desTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('target_terpenuhi');
                    $desReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('total_reject');
                    $ResumeCLN[] = [
                        'id_line' => $value2->id_line,
                        'janTerpenuhi' => $janTerpenuhi,
                        'janReject' => $janReject,
                        'febTerpenuhi' => $febTerpenuhi,
                        'febReject' => $febReject,
                        'marTerpenuhi' => $marTerpenuhi,
                        'marReject' => $marReject,
                        'aprTerpenuhi' => $aprTerpenuhi,
                        'aprReject' => $aprReject,
                        'meiTerpenuhi' => $meiTerpenuhi,
                        'meiReject' => $meiReject,
                        'junTerpenuhi' => $junTerpenuhi,
                        'junReject' => $junReject,
                        'julTerpenuhi' => $julTerpenuhi,
                        'julReject' => $julReject,
                        'agsTerpenuhi' => $agsTerpenuhi,
                        'agsReject' => $agsReject,
                        'sepTerpenuhi' => $sepTerpenuhi,
                        'sepReject' => $sepReject,
                        'oktTerpenuhi' => $oktTerpenuhi,
                        'oktReject' => $oktReject,
                        'novTerpenuhi' => $novTerpenuhi,
                        'novReject' => $novReject,
                        'desTerpenuhi' => $desTerpenuhi,
                        'desReject' => $desReject,
                        'file' => $value2->file
                    ];
                }
            }
        }
        // groupby berdasarkan id line 
        $totalCLN = collect($ResumeCLN)
                    ->groupBy('id_line')
                    ->map(function ($item) {
                        return array_merge(...$item->toArray());
                    })->values()->toArray();
        // untuk foto di lampiran
        $FotoCLN = collect($ResumeCLN)
                    ->where('file','!=', null)
                    ->groupBy('id_line')
                    ->map(function ($item) {
                        return array_merge(...$item->toArray());
                    })->values()->toArray();
        if($FotoCLN != null){
            $FinalFotoCLN = $FotoCLN[0];
        }else{
            $FinalFotoCLN = [
                'file' => null
            ];
        }

        // untuk mendapat data total tiap bulan dari pabrik cileunyi 
        $janCLNReject = collect($totalCLN)->sum('janReject');
        $janCLNTerpenuhi = collect($totalCLN)->sum('janTerpenuhi');
        $febCLNReject = collect($totalCLN)->sum('febReject');
        $febCLNTerpenuhi = collect($totalCLN)->sum('febTerpenuhi');
        $marCLNReject = collect($totalCLN)->sum('marReject');
        $marCLNTerpenuhi = collect($totalCLN)->sum('marTerpenuhi');
        $aprCLNReject = collect($totalCLN)->sum('aprReject');
        $aprCLNTerpenuhi = collect($totalCLN)->sum('aprTerpenuhi');
        $meiCLNReject = collect($totalCLN)->sum('meiReject');
        $meiCLNTerpenuhi = collect($totalCLN)->sum('meiTerpenuhi');
        $junCLNReject = collect($totalCLN)->sum('junReject');
        $junCLNTerpenuhi = collect($totalCLN)->sum('junTerpenuhi');
        $julCLNReject = collect($totalCLN)->sum('julReject');
        $julCLNTerpenuhi = collect($totalCLN)->sum('julTerpenuhi');
        $agsCLNReject = collect($totalCLN)->sum('agsReject');
        $agsCLNTerpenuhi = collect($totalCLN)->sum('agsTerpenuhi');
        $sepCLNReject = collect($totalCLN)->sum('sepReject');
        $sepCLNTerpenuhi = collect($totalCLN)->sum('sepTerpenuhi');
        $oktCLNReject = collect($totalCLN)->sum('oktReject');
        $oktCLNTerpenuhi = collect($totalCLN)->sum('oktTerpenuhi');
        $novCLNReject = collect($totalCLN)->sum('novReject');
        $novCLNTerpenuhi = collect($totalCLN)->sum('novTerpenuhi');
        $desCLNReject = collect($totalCLN)->sum('desReject');
        $desCLNTerpenuhi = collect($totalCLN)->sum('desTerpenuhi');
       
        // untuk mendapat nilai persentase 
        if ($janCLNTerpenuhi != 0){
            $janClnTotReject = round($janCLNReject/$janCLNTerpenuhi*100,2);
        }else{
            $janClnTotReject = 0;
        }
        if ($febCLNTerpenuhi != 0){
            $febClnTotReject = round($febCLNReject/$febCLNTerpenuhi*100,2);
        }else{
            $febClnTotReject = 0;
        }
        if ($marCLNTerpenuhi != 0){
            $marClnTotReject = round($marCLNReject/$marCLNTerpenuhi*100,2);
        }else{
            $marClnTotReject = 0;
        }
        if ($aprCLNTerpenuhi != 0){
            $aprClnTotReject = round($aprCLNReject/$aprCLNTerpenuhi*100,2);
        }else{
            $aprClnTotReject = 0;
        }
        if ($meiCLNTerpenuhi != 0){
            $meiClnTotReject = round($meiCLNReject/$meiCLNTerpenuhi*100,2);
        }else{
            $meiClnTotReject = 0;
        }
        if ($junCLNTerpenuhi != 0){
            $junClnTotReject = round($junCLNReject/$junCLNTerpenuhi*100,2);
        }else{
            $junClnTotReject = 0;
        }
        if ($julCLNTerpenuhi != 0){
            $julClnTotReject = round($julCLNReject/$julCLNTerpenuhi*100,2);
        }else{
            $julClnTotReject = 0;
        }
        if ($agsCLNTerpenuhi != 0){
            $agsClnTotReject = round($agsCLNReject/$agsCLNTerpenuhi*100,2);
        }else{
            $agsClnTotReject = 0;
        }
        if ($sepCLNTerpenuhi != 0){
            $sepClnTotReject = round($sepCLNReject/$sepCLNTerpenuhi*100,2);
        }else{
            $sepClnTotReject = 0;
        }
        if ($oktCLNTerpenuhi != 0){
            $oktClnTotReject = round($oktCLNReject/$oktCLNTerpenuhi*100,2);
        }else{
            $oktClnTotReject = 0;
        }
        if ($novCLNTerpenuhi != 0){
            $novClnTotReject = round($novCLNReject/$novCLNTerpenuhi*100,2);
        }else{
            $novClnTotReject = 0;
        }
        if ($desCLNTerpenuhi != 0){
            $desClnTotReject = round($desCLNReject/$desCLNTerpenuhi*100,2);
        }else{
            $desClnTotReject = 0;
        }
        
        // untuk data total 
        $totalCLNReject = ($janCLNReject + $febCLNReject + $marCLNReject + $aprCLNReject
                        + $meiCLNReject + $junCLNReject + $julCLNReject + $agsCLNReject
                        + $sepCLNReject + $oktCLNReject + $novCLNReject + $desCLNReject);

        $totalCLNTerpenuhi = ($janCLNTerpenuhi + $febCLNTerpenuhi + $marCLNTerpenuhi + $aprCLNTerpenuhi
                        + $meiCLNTerpenuhi + $junCLNTerpenuhi + $julCLNTerpenuhi + $agsCLNTerpenuhi
                        + $sepCLNTerpenuhi + $oktCLNTerpenuhi + $novCLNTerpenuhi + $desCLNTerpenuhi);
        
        if($totalCLNTerpenuhi != 0){
            $totalTOTCLN = round($totalCLNReject/$totalCLNTerpenuhi*100,2);
        }else{
            $totalTOTCLN = 0;
        }
        
        // final data untuk cileunyi 
        $FinalDataCLN = [
            'janReject' => $janCLNReject,
            'janCLNTOTReject' => $janClnTotReject,
            'febReject' => $febCLNReject,
            'febCLNTOTReject' => $febClnTotReject,
            'marReject' => $marCLNReject,
            'marCLNTOTReject' => $marClnTotReject,
            'aprReject' => $aprCLNReject,
            'aprCLNTOTReject' => $aprClnTotReject,
            'meiReject' => $meiCLNReject,
            'meiCLNTOTReject' => $meiClnTotReject,
            'junReject' => $junCLNReject,
            'junCLNTOTReject' => $junClnTotReject,
            'julReject' => $julCLNReject,
            'julCLNTOTReject' => $julClnTotReject,
            'agsReject' => $agsCLNReject,
            'agsCLNTOTReject' => $agsClnTotReject,
            'sepReject' => $sepCLNReject,
            'sepCLNTOTReject' => $sepClnTotReject,
            'oktReject' => $oktCLNReject,
            'oktCLNTOTReject' => $oktClnTotReject,
            'novReject' => $novCLNReject,
            'novCLNTOTReject' => $novClnTotReject,
            'desReject' => $desCLNReject,
            'desCLNTOTReject' => $desClnTotReject,
            'totalRejectCLN' => $totalCLNReject,
            'totalTOTCLN' => $totalTOTCLN,
        ];

        // untuk pabrik majalengka 1
        $bGM1 = 'MAJA';
        $bdGM1 = 'GM1';
        $dataGM1 =  MasterLine::where('branch', $bGM1)
                ->where('branch_detail', $bdGM1)
                ->get(); 
        $detail = LineDetail::all();
        // untuk mendapat nilai tiap bulan di majalengka 1 
        $ResumeGM1 = [];
        foreach ($dataGM1 as $key => $value) {
            foreach ($detail as $key2 => $value2) {
                if($value->id == $value2->id_line){
                    $janTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('target_terpenuhi');
                    $janReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('total_reject');
                    $febTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('target_terpenuhi');
                    $febReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('total_reject');
                    $marTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('target_terpenuhi');
                    $marReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('total_reject');
                    $aprTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('target_terpenuhi');
                    $aprReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('total_reject');
                    $meiTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('target_terpenuhi');
                    $meiReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('total_reject');
                    $junTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('target_terpenuhi');
                    $junReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('total_reject');
                    $julTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('target_terpenuhi');
                    $julReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('total_reject');
                    $agsTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('target_terpenuhi');
                    $agsReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('total_reject');
                    $sepTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('target_terpenuhi');
                    $sepReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('total_reject');
                    $oktTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('target_terpenuhi');
                    $oktReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('total_reject');
                    $novTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('target_terpenuhi');
                    $novReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('total_reject');
                    $desTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('target_terpenuhi');
                    $desReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('total_reject');
                    $ResumeGM1[] = [
                        'id_line' => $value2->id_line,
                        'janTerpenuhi' => $janTerpenuhi,
                        'janReject' => $janReject,
                        'febTerpenuhi' => $febTerpenuhi,
                        'febReject' => $febReject,
                        'marTerpenuhi' => $marTerpenuhi,
                        'marReject' => $marReject,
                        'aprTerpenuhi' => $aprTerpenuhi,
                        'aprReject' => $aprReject,
                        'meiTerpenuhi' => $meiTerpenuhi,
                        'meiReject' => $meiReject,
                        'junTerpenuhi' => $junTerpenuhi,
                        'junReject' => $junReject,
                        'julTerpenuhi' => $julTerpenuhi,
                        'julReject' => $julReject,
                        'agsTerpenuhi' => $agsTerpenuhi,
                        'agsReject' => $agsReject,
                        'sepTerpenuhi' => $sepTerpenuhi,
                        'sepReject' => $sepReject,
                        'oktTerpenuhi' => $oktTerpenuhi,
                        'oktReject' => $oktReject,
                        'novTerpenuhi' => $novTerpenuhi,
                        'novReject' => $novReject,
                        'desTerpenuhi' => $desTerpenuhi,
                        'desReject' => $desReject,
                        'file' => $value2->file
                    ];
                }
            }
        }
        // groupby berdasarkan id line 
        $totalGM1 = collect($ResumeGM1)
                    ->groupBy('id_line')
                    ->map(function ($item) {
                        return array_merge(...$item->toArray());
                    })->values()->toArray();
        // untuk foto di lampiran
        $FotoGM1 = collect($ResumeGM1)
                    ->where('file','!=', null)
                    ->groupBy('id_line')
                    ->map(function ($item) {
                        return array_merge(...$item->toArray());
                    })->values()->toArray();
        if($FotoGM1 != null){
            $FinalFotoGM1 = $FotoGM1[0];
        }else{
            $FinalFotoGM1 = [
                'file' => null
            ];
        }

        // untuk mendapat data total tiap bulan dari pabrik majalengka1
        $janGM1Reject = collect($totalGM1)->sum('janReject');
        $janGM1Terpenuhi = collect($totalGM1)->sum('janTerpenuhi');
        $febGM1Reject = collect($totalGM1)->sum('febReject');
        $febGM1Terpenuhi = collect($totalGM1)->sum('febTerpenuhi');
        $marGM1Reject = collect($totalGM1)->sum('marReject');
        $marGM1Terpenuhi = collect($totalGM1)->sum('marTerpenuhi');
        $aprGM1Reject = collect($totalGM1)->sum('aprReject');
        $aprGM1Terpenuhi = collect($totalGM1)->sum('aprTerpenuhi');
        $meiGM1Reject = collect($totalGM1)->sum('meiReject');
        $meiGM1Terpenuhi = collect($totalGM1)->sum('meiTerpenuhi');
        $junGM1Reject = collect($totalGM1)->sum('junReject');
        $junGM1Terpenuhi = collect($totalGM1)->sum('junTerpenuhi');
        $julGM1Reject = collect($totalGM1)->sum('julReject');
        $julGM1Terpenuhi = collect($totalGM1)->sum('julTerpenuhi');
        $agsGM1Reject = collect($totalGM1)->sum('agsReject');
        $agsGM1Terpenuhi = collect($totalGM1)->sum('agsTerpenuhi');
        $sepGM1Reject = collect($totalGM1)->sum('sepReject');
        $sepGM1Terpenuhi = collect($totalGM1)->sum('sepTerpenuhi');
        $oktGM1Reject = collect($totalGM1)->sum('oktReject');
        $oktGM1Terpenuhi = collect($totalGM1)->sum('oktTerpenuhi');
        $novGM1Reject = collect($totalGM1)->sum('novReject');
        $novGM1Terpenuhi = collect($totalGM1)->sum('novTerpenuhi');
        $desGM1Reject = collect($totalGM1)->sum('desReject');
        $desGM1Terpenuhi = collect($totalGM1)->sum('desTerpenuhi');
       
        // untuk mendapat nilai persentase 
        if ($janGM1Terpenuhi != 0){
            $janGM1TotReject = round($janGM1Reject/$janGM1Terpenuhi*100,2);
        }else{
            $janGM1TotReject = 0;
        }
        if ($febGM1Terpenuhi != 0){
            $febGM1TotReject = round($febGM1Reject/$febGM1Terpenuhi*100,2);
        }else{
            $febGM1TotReject = 0;
        }
        if ($marGM1Terpenuhi != 0){
            $marGM1TotReject = round($marGM1Reject/$marGM1Terpenuhi*100,2);
        }else{
            $marGM1TotReject = 0;
        }
        if ($aprGM1Terpenuhi != 0){
            $aprGM1TotReject = round($aprGM1Reject/$aprGM1Terpenuhi*100,2);
        }else{
            $aprGM1TotReject = 0;
        }
        if ($meiGM1Terpenuhi != 0){
            $meiGM1TotReject = round($meiGM1Reject/$meiGM1Terpenuhi*100,2);
        }else{
            $meiGM1TotReject = 0;
        }
        if ($junGM1Terpenuhi != 0){
            $junGM1TotReject = round($junGM1Reject/$junGM1Terpenuhi*100,2);
        }else{
            $junGM1TotReject = 0;
        }
        if ($julGM1Terpenuhi != 0){
            $julGM1TotReject = round($julGM1Reject/$julGM1Terpenuhi*100,2);
        }else{
            $julGM1TotReject = 0;
        }
        if ($agsGM1Terpenuhi != 0){
            $agsGM1TotReject = round($agsGM1Reject/$agsGM1Terpenuhi*100,2);
        }else{
            $agsGM1TotReject = 0;
        }
        if ($sepGM1Terpenuhi != 0){
            $sepGM1TotReject = round($sepGM1Reject/$sepGM1Terpenuhi*100,2);
        }else{
            $sepGM1TotReject = 0;
        }
        if ($oktGM1Terpenuhi != 0){
            $oktGM1TotReject = round($oktGM1Reject/$oktGM1Terpenuhi*100,2);
        }else{
            $oktGM1TotReject = 0;
        }
        if ($novGM1Terpenuhi != 0){
            $novGM1TotReject = round($novGM1Reject/$novGM1Terpenuhi*100,2);
        }else{
            $novGM1TotReject = 0;
        }
        if ($desGM1Terpenuhi != 0){
            $desGM1TotReject = round($desGM1Reject/$desGM1Terpenuhi*100,2);
        }else{
            $desGM1TotReject = 0;
        }
        
        // untuk data total 
        $totalGM1Reject = ($janGM1Reject + $febGM1Reject + $marGM1Reject + $aprGM1Reject
                        + $meiGM1Reject + $junGM1Reject + $julGM1Reject + $agsGM1Reject
                        + $sepGM1Reject + $oktGM1Reject + $novGM1Reject + $desGM1Reject);

        $totalGM1Terpenuhi = ($janGM1Terpenuhi + $febGM1Terpenuhi + $marGM1Terpenuhi + $aprGM1Terpenuhi
                        + $meiGM1Terpenuhi + $junGM1Terpenuhi + $julGM1Terpenuhi + $agsGM1Terpenuhi
                        + $sepGM1Terpenuhi + $oktGM1Terpenuhi + $novGM1Terpenuhi + $desGM1Terpenuhi);
        
        if($totalGM1Terpenuhi != 0){
            $totalTOTGM1 = round($totalGM1Reject/$totalGM1Terpenuhi*100,2);
        }else{
            $totalTOTGM1 = 0;
        }
        
        // final data untuk majalengka 1
        $FinalDataGM1 = [
            'janReject' => $janGM1Reject,
            'janGM1TOTReject' => $janGM1TotReject,
            'febReject' => $febGM1Reject,
            'febGM1TOTReject' => $febGM1TotReject,
            'marReject' => $marGM1Reject,
            'marGM1TOTReject' => $marGM1TotReject,
            'aprReject' => $aprGM1Reject,
            'aprGM1TOTReject' => $aprGM1TotReject,
            'meiReject' => $meiGM1Reject,
            'meiGM1TOTReject' => $meiGM1TotReject,
            'junReject' => $junGM1Reject,
            'junGM1TOTReject' => $junGM1TotReject,
            'julReject' => $julGM1Reject,
            'julGM1TOTReject' => $julGM1TotReject,
            'agsReject' => $agsGM1Reject,
            'agsGM1TOTReject' => $agsGM1TotReject,
            'sepReject' => $sepGM1Reject,
            'sepGM1TOTReject' => $sepGM1TotReject,
            'oktReject' => $oktGM1Reject,
            'oktGM1TOTReject' => $oktGM1TotReject,
            'novReject' => $novGM1Reject,
            'novGM1TOTReject' => $novGM1TotReject,
            'desReject' => $desGM1Reject,
            'desGM1TOTReject' => $desGM1TotReject,
            'totalRejectGM1' => $totalGM1Reject,
            'totalTOTGM1' => $totalTOTGM1,
        ];

        // untuk pabrik majalengka 2
        $bGM2 = 'MAJA';
        $bdGM2 = 'GM2';
        $dataGM2 =  MasterLine::where('branch', $bGM2)
                ->where('branch_detail', $bdGM2)
                ->get(); 
        $detail = LineDetail::all();
        // untuk mendapat nilai tiap bulan di majalengka 2
        $ResumeGM2 = [];
        foreach ($dataGM2 as $key => $value) {
            foreach ($detail as $key2 => $value2) {
                if($value->id == $value2->id_line){
                    $janTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('target_terpenuhi');
                    $janReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $janAwal)->where('tgl_pengerjaan', '<=' , $janAkhir)->get()->sum('total_reject');
                    $febTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('target_terpenuhi');
                    $febReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $febAwal)->where('tgl_pengerjaan', '<=' , $febAkhir)->get()->sum('total_reject');
                    $marTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('target_terpenuhi');
                    $marReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $marAwal)->where('tgl_pengerjaan', '<=' , $marAkhir)->get()->sum('total_reject');
                    $aprTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('target_terpenuhi');
                    $aprReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $aprAwal)->where('tgl_pengerjaan', '<=' , $aprAkhir)->get()->sum('total_reject');
                    $meiTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('target_terpenuhi');
                    $meiReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $meiAwal)->where('tgl_pengerjaan', '<=' , $meiAkhir)->get()->sum('total_reject');
                    $junTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('target_terpenuhi');
                    $junReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $junAwal)->where('tgl_pengerjaan', '<=' , $junAkhir)->get()->sum('total_reject');
                    $julTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('target_terpenuhi');
                    $julReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $julAwal)->where('tgl_pengerjaan', '<=' , $julAkhir)->get()->sum('total_reject');
                    $agsTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('target_terpenuhi');
                    $agsReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $agsAwal)->where('tgl_pengerjaan', '<=' , $agsAkhir)->get()->sum('total_reject');
                    $sepTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('target_terpenuhi');
                    $sepReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $sepAwal)->where('tgl_pengerjaan', '<=' , $sepAkhir)->get()->sum('total_reject');
                    $oktTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('target_terpenuhi');
                    $oktReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $oktAwal)->where('tgl_pengerjaan', '<=' , $oktAkhir)->get()->sum('total_reject');
                    $novTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('target_terpenuhi');
                    $novReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $novAwal)->where('tgl_pengerjaan', '<=' , $novAkhir)->get()->sum('total_reject');
                    $desTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('target_terpenuhi');
                    $desReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', '>=' , $desAwal)->where('tgl_pengerjaan', '<=' , $desAkhir)->get()->sum('total_reject');
                    $ResumeGM2[] = [
                        'id_line' => $value2->id_line,
                        'janTerpenuhi' => $janTerpenuhi,
                        'janReject' => $janReject,
                        'febTerpenuhi' => $febTerpenuhi,
                        'febReject' => $febReject,
                        'marTerpenuhi' => $marTerpenuhi,
                        'marReject' => $marReject,
                        'aprTerpenuhi' => $aprTerpenuhi,
                        'aprReject' => $aprReject,
                        'meiTerpenuhi' => $meiTerpenuhi,
                        'meiReject' => $meiReject,
                        'junTerpenuhi' => $junTerpenuhi,
                        'junReject' => $junReject,
                        'julTerpenuhi' => $julTerpenuhi,
                        'julReject' => $julReject,
                        'agsTerpenuhi' => $agsTerpenuhi,
                        'agsReject' => $agsReject,
                        'sepTerpenuhi' => $sepTerpenuhi,
                        'sepReject' => $sepReject,
                        'oktTerpenuhi' => $oktTerpenuhi,
                        'oktReject' => $oktReject,
                        'novTerpenuhi' => $novTerpenuhi,
                        'novReject' => $novReject,
                        'desTerpenuhi' => $desTerpenuhi,
                        'desReject' => $desReject,
                        'file' => $value2->file
                    ];
                }
            }
        }
        // groupby berdasarkan id line 
        $totalGM2 = collect($ResumeGM2)
                    ->groupBy('id_line')
                    ->map(function ($item) {
                        return array_merge(...$item->toArray());
                    })->values()->toArray();
        // untuk foto di lampiran
        $FotoGM2 = collect($ResumeGM2)
                    ->where('file','!=', null)
                    ->groupBy('id_line')
                    ->map(function ($item) {
                        return array_merge(...$item->toArray());
                    })->values()->toArray();
        if($FotoGM2 != null){
            $FinalFotoGM2 = $FotoGM2[0];
        }else{
            $FinalFotoGM2 = [
                'file' => null
            ];
        }

        // untuk mendapat data total tiap bulan dari pabrik majalengka2
        $janGM2Reject = collect($totalGM2)->sum('janReject');
        $janGM2Terpenuhi = collect($totalGM2)->sum('janTerpenuhi');
        $febGM2Reject = collect($totalGM2)->sum('febReject');
        $febGM2Terpenuhi = collect($totalGM2)->sum('febTerpenuhi');
        $marGM2Reject = collect($totalGM2)->sum('marReject');
        $marGM2Terpenuhi = collect($totalGM2)->sum('marTerpenuhi');
        $aprGM2Reject = collect($totalGM2)->sum('aprReject');
        $aprGM2Terpenuhi = collect($totalGM2)->sum('aprTerpenuhi');
        $meiGM2Reject = collect($totalGM2)->sum('meiReject');
        $meiGM2Terpenuhi = collect($totalGM2)->sum('meiTerpenuhi');
        $junGM2Reject = collect($totalGM2)->sum('junReject');
        $junGM2Terpenuhi = collect($totalGM2)->sum('junTerpenuhi');
        $julGM2Reject = collect($totalGM2)->sum('julReject');
        $julGM2Terpenuhi = collect($totalGM2)->sum('julTerpenuhi');
        $agsGM2Reject = collect($totalGM2)->sum('agsReject');
        $agsGM2Terpenuhi = collect($totalGM2)->sum('agsTerpenuhi');
        $sepGM2Reject = collect($totalGM2)->sum('sepReject');
        $sepGM2Terpenuhi = collect($totalGM2)->sum('sepTerpenuhi');
        $oktGM2Reject = collect($totalGM2)->sum('oktReject');
        $oktGM2Terpenuhi = collect($totalGM2)->sum('oktTerpenuhi');
        $novGM2Reject = collect($totalGM2)->sum('novReject');
        $novGM2Terpenuhi = collect($totalGM2)->sum('novTerpenuhi');
        $desGM2Reject = collect($totalGM2)->sum('desReject');
        $desGM2Terpenuhi = collect($totalGM2)->sum('desTerpenuhi');
       
        // untuk mendapat nilai persentase 
        if ($janGM2Terpenuhi != 0){
            $janGM2TotReject = round($janGM2Reject/$janGM2Terpenuhi*100,2);
        }else{
            $janGM2TotReject = 0;
        }
        if ($febGM2Terpenuhi != 0){
            $febGM2TotReject = round($febGM2Reject/$febGM2Terpenuhi*100,2);
        }else{
            $febGM2TotReject = 0;
        }
        if ($marGM2Terpenuhi != 0){
            $marGM2TotReject = round($marGM2Reject/$marGM2Terpenuhi*100,2);
        }else{
            $marGM2TotReject = 0;
        }
        if ($aprGM2Terpenuhi != 0){
            $aprGM2TotReject = round($aprGM2Reject/$aprGM2Terpenuhi*100,2);
        }else{
            $aprGM2TotReject = 0;
        }
        if ($meiGM2Terpenuhi != 0){
            $meiGM2TotReject = round($meiGM2Reject/$meiGM2Terpenuhi*100,2);
        }else{
            $meiGM2TotReject = 0;
        }
        if ($junGM2Terpenuhi != 0){
            $junGM2TotReject = round($junGM2Reject/$junGM2Terpenuhi*100,2);
        }else{
            $junGM2TotReject = 0;
        }
        if ($julGM2Terpenuhi != 0){
            $julGM2TotReject = round($julGM2Reject/$julGM2Terpenuhi*100,2);
        }else{
            $julGM2TotReject = 0;
        }
        if ($agsGM2Terpenuhi != 0){
            $agsGM2TotReject = round($agsGM2Reject/$agsGM2Terpenuhi*100,2);
        }else{
            $agsGM2TotReject = 0;
        }
        if ($sepGM2Terpenuhi != 0){
            $sepGM2TotReject = round($sepGM2Reject/$sepGM2Terpenuhi*100,2);
        }else{
            $sepGM2TotReject = 0;
        }
        if ($oktGM2Terpenuhi != 0){
            $oktGM2TotReject = round($oktGM2Reject/$oktGM2Terpenuhi*100,2);
        }else{
            $oktGM2TotReject = 0;
        }
        if ($novGM2Terpenuhi != 0){
            $novGM2TotReject = round($novGM2Reject/$novGM2Terpenuhi*100,2);
        }else{
            $novGM2TotReject = 0;
        }
        if ($desGM2Terpenuhi != 0){
            $desGM2TotReject = round($desGM2Reject/$desGM2Terpenuhi*100,2);
        }else{
            $desGM2TotReject = 0;
        }
        
        // untuk data total 
        $totalGM2Reject = ($janGM2Reject + $febGM2Reject + $marGM2Reject + $aprGM2Reject
                        + $meiGM2Reject + $junGM2Reject + $julGM2Reject + $agsGM2Reject
                        + $sepGM2Reject + $oktGM2Reject + $novGM2Reject + $desGM2Reject);

        $totalGM2Terpenuhi = ($janGM2Terpenuhi + $febGM2Terpenuhi + $marGM2Terpenuhi + $aprGM2Terpenuhi
                        + $meiGM2Terpenuhi + $junGM2Terpenuhi + $julGM2Terpenuhi + $agsGM2Terpenuhi
                        + $sepGM2Terpenuhi + $oktGM2Terpenuhi + $novGM2Terpenuhi + $desGM2Terpenuhi);
        
        if($totalGM2Terpenuhi != 0){
            $totalTOTGM2 = round($totalGM2Reject/$totalGM2Terpenuhi*100,2);
        }else{
            $totalTOTGM2 = 0;
        }
        
        // final data untuk majalengka 2
        $FinalDataGM2 = [
            'janReject' => $janGM2Reject,
            'janGM2TOTReject' => $janGM2TotReject,
            'febReject' => $febGM2Reject,
            'febGM2TOTReject' => $febGM2TotReject,
            'marReject' => $marGM2Reject,
            'marGM2TOTReject' => $marGM2TotReject,
            'aprReject' => $aprGM2Reject,
            'aprGM2TOTReject' => $aprGM2TotReject,
            'meiReject' => $meiGM2Reject,
            'meiGM2TOTReject' => $meiGM2TotReject,
            'junReject' => $junGM2Reject,
            'junGM2TOTReject' => $junGM2TotReject,
            'julReject' => $julGM2Reject,
            'julGM2TOTReject' => $julGM2TotReject,
            'agsReject' => $agsGM2Reject,
            'agsGM2TOTReject' => $agsGM2TotReject,
            'sepReject' => $sepGM2Reject,
            'sepGM2TOTReject' => $sepGM2TotReject,
            'oktReject' => $oktGM2Reject,
            'oktGM2TOTReject' => $oktGM2TotReject,
            'novReject' => $novGM2Reject,
            'novGM2TOTReject' => $novGM2TotReject,
            'desReject' => $desGM2Reject,
            'desGM2TOTReject' => $desGM2TotReject,
            'totalRejectGM2' => $totalGM2Reject,
            'totalTOTGM2' => $totalTOTGM2,
        ];

        $pdf = PDF::loadview('qc/rework/report/Alltahunan_pdf', compact('FinalFotoCLN', 'FinalFotoGM1', 'FinalFotoGM2', 'FinalDataCLN', 'FinalDataGM1', 'FinalDataGM2', 'tahun'))->setPaper('legal', 'landscape');
        return $pdf->stream();
    }

    public function getHarian(Request $request)
    {
        $tanggal = $request->tanggal;
        $tanggal_depan = (new Carbon($request->tanggal))->format('d-m-Y');

        if(
            LineDetail::where('tgl_pengerjaan', $tanggal)->count()
        ) {
        // untuk cileunyi 
        $lineCLN =  MasterLine::where('branch', 'CLN')
                    ->where('branch_detail', 'CLN')
                    ->get();
        // untuk mengetahui jumlah line yang ada 
        $jumlahLineCileunyi =  MasterLine::where('branch', 'CLN')
        ->where('branch_detail', 'CLN')
        ->get()->count('no_wo');
        

        $dataCLN = [];
        foreach ($lineCLN as $key => $value) {
           foreach ($value->ltarget as $key => $value2) {
              foreach ($value2->detail as $key => $value3) {
                  if ($value3->tgl_pengerjaan == $tanggal) {
                        $CLNTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('target_terpenuhi');
                        $CLNReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan' , $tanggal)->get()->sum('total_reject');
                        if ($CLNTerpenuhi == 0) {
                            $CLN_P_Reject = 0;
                        }else{
                           $CLN_P_Reject = round($CLNReject/$CLNTerpenuhi*100,2); 
                        }
                        $dataCLN[] = [
                            'branch' => $value->branch,
                            'line' => $value->string1,
                            'tot_terpenuhi'=> $CLNTerpenuhi,
                            'tot_reject'=> $CLNReject,
                            'p_reject'=> $CLN_P_Reject,
                            'file' => $value3->file
                        ];
                    }
                }
            }
        }

        $finalCLN = collect($dataCLN)
                        ->groupBy('line')
                        ->map(function ($item) {
                            return array_merge(...$item->toArray());
                        })->values()->toArray();
        $fotoCLN = collect($dataCLN)
                        ->where('file', '!=', null)
                        ->groupBy('line')
                        ->map(function ($item) {
                            return array_merge(...$item->toArray());
                        })->values()->toArray();
        // end 

        // untuk majalengka 1
        $lineMAJA1 =  MasterLine::where('branch', 'MAJA')
                    ->where('branch_detail', 'GM1')
                    ->get();
        // untuk mengetahui jumlah line yang ada 
        $jumlahLineMAJA1 =  MasterLine::where('branch', 'MAJA')
        ->where('branch_detail', 'GM1')
        ->get()->count('no_wo');
        
        $dataMAJA1 = [];
        foreach ($lineMAJA1 as $key => $value) {
           foreach ($value->ltarget as $key => $value2) {
              foreach ($value2->detail as $key => $value3) {
                  if ($value3->tgl_pengerjaan == $tanggal) {
                        $MAJA1Terpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('target_terpenuhi');
                        $MAJA1Reject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan' , $tanggal)->get()->sum('total_reject');
                        if ($MAJA1Terpenuhi == 0) {
                           $MAJA1_P_Reject = 0;
                        }else{
                          $MAJA1_P_Reject = round($MAJA1Reject/$MAJA1Terpenuhi*100,2); 
                        }
                        $dataMAJA1[] = [
                            'branch' => $value->branch,
                            'line' => $value->string1,
                            'tot_terpenuhi'=> $MAJA1Terpenuhi,
                            'tot_reject'=> $MAJA1Reject,
                            'p_reject'=> $MAJA1_P_Reject,
                            'file' => $value3->file
                        ];
                    }
                }
            }
        }
        $finalMAJA1 = collect($dataMAJA1)
                        ->groupBy('line')
                        ->map(function ($item) {
                            return array_merge(...$item->toArray());
                        })->values()->toArray();
        $fotoMAJA1 = collect($dataMAJA1)
                        ->where('file', '!=', null)
                        ->groupBy('line')
                        ->map(function ($item) {
                            return array_merge(...$item->toArray());
                        })->values()->toArray();
        // end 

        // untuk majalengka 2
        $lineMAJA2 =  MasterLine::where('branch', 'MAJA')
                    ->where('branch_detail', 'GM2')
                    ->get();
        // untuk mengetahui jumlah line yang ada 
        $jumlahLineMAJA2 =  MasterLine::where('branch', 'MAJA')
        ->where('branch_detail', 'GM2')
        ->get()->count('no_wo');
        
        $dataMAJA2 = [];
        foreach ($lineMAJA2 as $key => $value) {
           foreach ($value->ltarget as $key => $value2) {
              foreach ($value2->detail as $key => $value3) {
                  if ($value3->tgl_pengerjaan == $tanggal) {
                        $MAJA2Terpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('target_terpenuhi');
                        $MAJA2Reject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan' , $tanggal)->get()->sum('total_reject');
                        if ($MAJA2Terpenuhi == 0) {
                            $MAJA2_P_Reject = 0;
                         }else{
                           $MAJA2_P_Reject = round($MAJA2Reject/$MAJA2Terpenuhi*100,2); 
                         }
                        $dataMAJA2[] = [
                            'branch' => $value->branch,
                            'line' => $value->string1,
                            'tot_terpenuhi'=> $MAJA2Terpenuhi,
                            'tot_reject'=> $MAJA2Reject,
                            'p_reject'=> $MAJA2_P_Reject,
                            'file' => $value3->file
                        ];
                    }
                }
            }
        }
        $finalMAJA2 = collect($dataMAJA2)
                        ->groupBy('line')
                        ->map(function ($item) {
                            return array_merge(...$item->toArray());
                        })->values()->toArray();
        $fotoMAJA2 = collect($dataMAJA2)
                        ->where('file', '!=', null)
                        ->groupBy('line')
                        ->map(function ($item) {
                            return array_merge(...$item->toArray());
                        })->values()->toArray();
        // end 
        // untuk data total 
        $totalAllTerpenuhi = collect($finalCLN)->sum('tot_terpenuhi') + collect($finalMAJA1)->sum('tot_terpenuhi') + + collect($finalMAJA2)->sum('tot_terpenuhi');
        $totalAllReject = collect($finalCLN)->sum('tot_reject') + collect($finalMAJA1)->sum('tot_reject') + + collect($finalMAJA2)->sum('tot_reject');
        $totalAll_P_Reject = round($totalAllReject/$totalAllTerpenuhi*100,2);

        return view('qc/rework/report/detailAllHarian', compact('fotoMAJA2', 'fotoMAJA1', 'fotoCLN', 'tanggal', 'totalAllTerpenuhi','totalAllReject','totalAll_P_Reject', 'jumlahLineMAJA2','finalMAJA2','finalMAJA1', 'jumlahLineMAJA1', 'jumlahLineCileunyi', 'finalCLN', 'tanggal_depan'));
        }else{
            throw new \Exception('Data Kosong !');
        }
    }
    public function AllHarianPDF(Request $request)
    {
        $tanggal = $request->tanggal;
        $tanggal_depan = (new Carbon($request->tanggal))->format('d-m-Y');

        // untuk cileunyi 
        $lineCLN =  MasterLine::where('branch', 'CLN')
                    ->where('branch_detail', 'CLN')
                    ->get();
        // untuk mengetahui jumlah line yang ada 
        $jumlahLineCileunyi =  MasterLine::where('branch', 'CLN')
        ->where('branch_detail', 'CLN')
        ->get()->count('no_wo');
        

        $dataCLN = [];
        foreach ($lineCLN as $key => $value) {
           foreach ($value->ltarget as $key => $value2) {
              foreach ($value2->detail as $key => $value3) {
                  if ($value3->tgl_pengerjaan == $tanggal) {
                        $CLNTerpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('target_terpenuhi');
                        $CLNReject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan' , $tanggal)->get()->sum('total_reject');
                        if ($CLNTerpenuhi == 0) {
                            $CLN_P_Reject = 0;
                        }else{
                           $CLN_P_Reject = round($CLNReject/$CLNTerpenuhi*100,2); 
                        }
                        $dataCLN[] = [
                            'branch' => $value->branch,
                            'line' => $value->string1,
                            'tot_terpenuhi'=> $CLNTerpenuhi,
                            'tot_reject'=> $CLNReject,
                            'p_reject'=> $CLN_P_Reject,
                            'file' => $value3->file
                        ];
                    }
                }
            }
        }

        $finalCLN = collect($dataCLN)
                        ->groupBy('line')
                        ->map(function ($item) {
                            return array_merge(...$item->toArray());
                        })->values()->toArray();
        $fotoCLN = collect($dataCLN)
                        ->where('file', '!=', null)
                        ->groupBy('line')
                        ->map(function ($item) {
                            return array_merge(...$item->toArray());
                        })->values()->toArray();
        // end 

        // untuk majalengka 1
        $lineMAJA1 =  MasterLine::where('branch', 'MAJA')
                    ->where('branch_detail', 'GM1')
                    ->get();
        // untuk mengetahui jumlah line yang ada 
        $jumlahLineMAJA1 =  MasterLine::where('branch', 'MAJA')
        ->where('branch_detail', 'GM1')
        ->get()->count('no_wo');
        
        $dataMAJA1 = [];
        foreach ($lineMAJA1 as $key => $value) {
           foreach ($value->ltarget as $key => $value2) {
              foreach ($value2->detail as $key => $value3) {
                  if ($value3->tgl_pengerjaan == $tanggal) {
                        $MAJA1Terpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('target_terpenuhi');
                        $MAJA1Reject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan' , $tanggal)->get()->sum('total_reject');
                        if ($MAJA1Terpenuhi == 0) {
                            $MAJA1_P_Reject = 0;
                        }else{
                           $MAJA1_P_Reject = round($MAJA1Reject/$MAJA1Terpenuhi*100,2); 
                        }
                        $dataMAJA1[] = [
                            'branch' => $value->branch,
                            'line' => $value->string1,
                            'tot_terpenuhi'=> $MAJA1Terpenuhi,
                            'tot_reject'=> $MAJA1Reject,
                            'p_reject'=> $MAJA1_P_Reject,
                            'file' => $value3->file
                        ];
                    }
                }
            }
        }
        $finalMAJA1 = collect($dataMAJA1)
                        ->groupBy('line')
                        ->map(function ($item) {
                            return array_merge(...$item->toArray());
                        })->values()->toArray();
        $fotoMAJA1 = collect($dataMAJA1)
                        ->where('file', '!=', null)
                        ->groupBy('line')
                        ->map(function ($item) {
                            return array_merge(...$item->toArray());
                        })->values()->toArray();
        // end 

        // untuk majalengka 2
        $lineMAJA2 =  MasterLine::where('branch', 'MAJA')
                    ->where('branch_detail', 'GM2')
                    ->get();
        // untuk mengetahui jumlah line yang ada 
        $jumlahLineMAJA2 =  MasterLine::where('branch', 'MAJA')
        ->where('branch_detail', 'GM2')
        ->get()->count('no_wo');
        
        $dataMAJA2 = [];
        foreach ($lineMAJA2 as $key => $value) {
           foreach ($value->ltarget as $key => $value2) {
              foreach ($value2->detail as $key => $value3) {
                  if ($value3->tgl_pengerjaan == $tanggal) {
                        $MAJA2Terpenuhi = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('target_terpenuhi');
                        $MAJA2Reject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan' , $tanggal)->get()->sum('total_reject');
                        if ($MAJA2Terpenuhi == 0) {
                            $MAJA2_P_Reject = 0;
                        }else{
                           $MAJA2_P_Reject = round($MAJA2Reject/$MAJA2Terpenuhi*100,2); 
                        }
                        $dataMAJA2[] = [
                            'branch' => $value->branch,
                            'line' => $value->string1,
                            'tot_terpenuhi'=> $MAJA2Terpenuhi,
                            'tot_reject'=> $MAJA2Reject,
                            'p_reject'=> $MAJA2_P_Reject,
                            'file' => $value3->file
                        ];
                    }
                }
            }
        }
        $finalMAJA2 = collect($dataMAJA2)
                        ->groupBy('line')
                        ->map(function ($item) {
                            return array_merge(...$item->toArray());
                        })->values()->toArray();
        $fotoMAJA2 = collect($dataMAJA2)
                        ->where('file', '!=', null)
                        ->groupBy('line')
                        ->map(function ($item) {
                            return array_merge(...$item->toArray());
                        })->values()->toArray();
        // end 
        // untuk data total 
        $totalAllTerpenuhi = collect($finalCLN)->sum('tot_terpenuhi') + collect($finalMAJA1)->sum('tot_terpenuhi') + + collect($finalMAJA2)->sum('tot_terpenuhi');
        $totalAllReject = collect($finalCLN)->sum('tot_reject') + collect($finalMAJA1)->sum('tot_reject') + + collect($finalMAJA2)->sum('tot_reject');
        $totalAll_P_Reject = round($totalAllReject/$totalAllTerpenuhi*100,2);

        $pdf = PDF::loadview('qc/rework/report/Allharian_pdf',  compact('fotoCLN', 'fotoMAJA1', 'fotoMAJA2','tanggal', 'totalAllTerpenuhi','totalAllReject','totalAll_P_Reject', 'jumlahLineMAJA2','finalMAJA2','finalMAJA1', 'jumlahLineMAJA1', 'jumlahLineCileunyi', 'finalCLN', 'tanggal_depan'))->setPaper('legal', 'landscape');
        return $pdf->stream();
    }

}
