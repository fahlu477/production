<?php

namespace App\Http\Controllers;

use App\Branch;
use App\LineDetail;
use App\MasterLine;
use Illuminate\Http\Request;

class CommandCenterController extends Controller
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
    
    public function level2($id)
    {

        $id_branch = $id;
        $branch = Branch::all();
        $dataSemua = 75.12;
        $dataQualityControl = 0;
        $dataProduction = 30;
        $dataExpedition = 75;
        $dataMarketing = 75;
        $dataAccounting = 71;
        $dataPurchasing = 75;
        $dataWarehouse = 75;
        $dataHR = 30;
        $dataDocument = 46;
        $dataInternalAudit = 75;
        $dataIT = 71;
        $dataDepartemen1 = 30;
        $dataDepartemen2 = 75;
        $dataDepartemen3 = 75;
        $dataDepartemen4 = 75;
        
        return view('CommandCenter.level2', compact('branch','id_branch','dataSemua','dataQualityControl','dataProduction', 'dataExpedition',
        'dataMarketing','dataAccounting','dataPurchasing','dataWarehouse','dataHR',
        'dataDocument','dataInternalAudit','dataIT', 'dataDepartemen1','dataDepartemen2', 'dataDepartemen3', 'dataDepartemen4'));
    }

     public function qc(Request $request, $id)
     {
         // inisialisasi branch 
         // dd($id);
        $dataBranch = Branch::findorfail($id);
        $branch = $dataBranch->kode_branch;
        $branch_detail = $dataBranch->branchdetail;

         // end branch 
         // untuk tanggal hari ini 
         $tanggal = date('Y-m-d', strtotime(' -1 day'));
        //  dd($tanggal);
         // dd($tanggal);
 
         if(LineDetail::where('tgl_pengerjaan', $tanggal)->count()) {
             $dataRework =   $this->dataRework($tanggal, $branch, $branch_detail);
         }else{
             $dataRework = 0;
         }
            // untuk di command center 
        $dataRejectCutting = 0;
        $dataRejectGarment = 0;
        $dataFactoryAudit = 0;
        $dataFinalInspection = 0;
        $dataSampleInspection = 0;
        $dataKlaimBuyer = 0;
        $jumlah =  round($dataRework + $dataRejectCutting + $dataRejectGarment + $dataFactoryAudit + $dataSampleInspection + $dataKlaimBuyer,2);
        if ($jumlah == 0) {
            $dataSemua = 0;
        }else{
            $dataSemua = round($jumlah/7,2);
        }
 
         return view('CommandCenter.qc', compact('dataBranch','dataSemua', 'dataRework', 'dataRejectCutting', 'dataRejectGarment',
                                          'dataFactoryAudit', 'dataFinalInspection', 'dataSampleInspection', 'dataKlaimBuyer'));
     }
 
     public function dataRework($tanggal, $branch, $branch_detail)
     {
         // BUAT GRAFIK 
          $data =  MasterLine::where('branch', $branch)
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
                     $total_reject = LineDetail::where('id_line', $value->id)->where('tgl_pengerjaan', $tanggal)->get()->sum('total_reject');
                     // Data untuk ditampilkan ke blade 
                     $dataTotal[] = [
                         'id_line' => $value2->id_line,
                         'terpenuhi' => $terpenuhi,
                         'total_reject'=> $total_reject,
                     ];
                 }
             }
         }
         $TotalResult = collect($dataTotal)
                 ->groupBy('id_line')
                 ->map(function ($item) {
                     return array_merge(...$item->toArray());
                 })->values()->toArray();
 
         $clnTerpenuhi = collect($TotalResult)->sum('terpenuhi');
         $clnTotReject = collect($TotalResult)->sum('total_reject');
         if($clnTerpenuhi == 0 || $clnTotReject == 0 || $clnTerpenuhi == null || $clnTotReject == 0){
             $dataRework = 0;
         }else{
             $dataRework = round($clnTotReject/$clnTerpenuhi*100,2);
         }
         return $dataRework;
         // end data total
     }
}
