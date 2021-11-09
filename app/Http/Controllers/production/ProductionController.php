<?php

namespace App\Http\Controllers\production;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;
use App\Branch;
use App\Stower;
use DataTables;
use Auth;

class ProductionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //tampilan halamaan Report Tower Signal
    public function produk()
    {
        return view('production/index');
    }

    //show data andon
    public function andon()
    {
         $dataBranch = Branch::all();
        // dd ($data);

        return view('production.andon', compact('dataBranch'));
    }
    // report andon
    public function reporttower(Request $request)
    {
        $stowers = Stower::all();
        // dd ($stowers);
        // $stowers['date'] = Carbon::createFromFormat('m/d/Y', $request->date)->format('Y-m-d');
        // $getCreatedAtAttribute = getCreatedAtAttribute::create($stowers);
        $stowerGroupedByDate = $stowers->groupBy('tanggal')->values();

                $rataRataResponTime = [];
                $rataRataDeliEndTime = [];
                $totWaktuDeliveryTime = [];
                $jumlahTargetPerHari = [];
                $jumlahLosTime = [];
                $jumlahRemarkPerHari = [];
                $avgAllDataPerLineAndDate = [];
                $sumAllDataPerLineAndDate = [];

        foreach ($stowerGroupedByDate as $stowersByDate) {

            $stowerGroupedByNameAndDate = $stowersByDate->sortBy('namaline')->groupBy('namaline')->values();
            // dump($stowerGroupedByNameAndDate);
                $avgResAndReq = [];
                $avgDeliEndAndProses = [];
                $totWaktuDeliAndReq = [];
                $qtyReqDay = [];
                $qtyActDay = [];
                $totLosTime =[];
                $dataAllLineGroupedbyDate = [];
                $sumdataAllLineGroupedbyDate = [];

            foreach ($stowerGroupedByNameAndDate as $stowersByDateAndLine) {

                $differenceResponAndRequest = [];
                $differenceDeliveryAndProses = [];
                $differenceDeliveryAndRequest = [];
                $qtyReqDayGroupedByDateAndName = [];
                $differenceDeliveryAndLosTime = [];
                $qtyActDayGroupedByDateAndName = [];
                

                foreach ($stowersByDateAndLine as $stower) {

                    //Losstime
                    // if ($stower->lostim !== "" && $stower->lostim !== null) {
                    //     $losTime = explode(':', $stower->los);
                    //     $losJam = ((int) $losTime[0]) * 3600;
                    //     $losMenit = ((int) $losTime[1]) * 60;
                    //     $losDetik = ((int) $losTime[2]);
                    //     $losTimeSeconds = $losJam + $losMenit + $losDetik;
                    // } else {
                    //     $losTimeSeconds = 0;
                    // }
                     // Remark 
                      if(gettype((int)$stower->Remark) === "integer" &&  $stower->Remark !== null && (int)$stower->Remark > 0){
                        $qtyActDayGroupedByDateAndName[] = (int)$stower->Remark;
                    } else {
                        // dump((int)$stower->Remark);
                        $qtyActDayGroupedByDateAndName[] = (int)$stower->Remark;
                    }
                
                    if(gettype((int)$stower->lostim) === "integer" && (int)$stower->lostim > 0){
                        $lossTime = (int)$stower->lostim;
                    } else {
                        $lossTime = 0; 
                    }
                    // dd($lossTime);
                    // Delivery End
                    if ($stower->deliend !== "" && $stower->deliend !== null) {
                        $deliendTime = explode(':', $stower->deliend);
                        $deliendJam = ((int) $deliendTime[0]) * 3600;
                        $deliendMenit = ((int) $deliendTime[1]) * 60;
                        $deliendDetik = ((int) $deliendTime[2]);
                        $deliEndTimeSeconds = $deliendJam + $deliendMenit + $deliendDetik;
                    } else {
                        $deliEndTimeSeconds = 0;
                    }

                    // proses end
                     if ($stower->prosesend !== "" && $stower->prosesend !== null) {
                        $prosesendTime = explode(':', $stower->prosesend);
                        $prosesendJam = ((int) $prosesendTime[0]) * 3600;
                        $prosesendMenit = ((int) $prosesendTime[1]) * 60;
                        $prosesendDetik = ((int) $prosesendTime[2]);
                        $prosesEndTimeSeconds = $prosesendJam + $prosesendMenit + $prosesendDetik;
                    } else {
                        $prosesEndTimeSeconds = 0;
                    }

                    // Target perday
                    if(gettype((int)$stower->target_perday) === "integer" && (int)$stower->target_perday > 0){
                        $qtyReqDayGroupedByDateAndName[] = (int)$stower->target_perday;
                    } else {
                        // dump((int)$stower->target_perday);
                        $qtyReqDayGroupedByDateAndName[] = 0;
                    }
                    
                    // Response Time
                    if ($stower->resline !== "" && $stower->resline !== null) {
                        $resTime = explode(':', $stower->resline);
                        $resJam = ((int) $resTime[0]) * 3600;
                        $resMenit = ((int) $resTime[1]) * 60;
                        $resDetik = ((int) $resTime[2]);
                        $responTimeSeconds = $resJam + $resMenit + $resDetik;
                    } else {
                        $responTimeSeconds = 0;
                    }
                    
                    // Resquest Time
                    if ($stower->reqlin !== "" && $stower->reqlin !== null) {
                        $reqTime = explode(':', $stower->reqlin);
                        $reqJam = ((int) $reqTime[0]) * 3600;
                        $reqMenit = ((int) $reqTime[1]) * 60;
                        $reqDetik = ((int) $reqTime[2]);
                        $requestTimeSeconds = $reqJam + $reqMenit + $reqDetik;
                    } else {
                        $requestTimeSeconds = 0;
                    }
                    
                    //Hasil selisih dikonversi kembali ke bentuk waktu (Menit)
                    $differenceResponAndRequest[] = ($responTimeSeconds - $requestTimeSeconds) / 60;
                    $differenceDeliveryAndRequest[] = ($deliEndTimeSeconds - $requestTimeSeconds) / 60;
                    $differenceDeliveryAndProses[] = ($deliEndTimeSeconds - $prosesEndTimeSeconds)/60;
                    $differenceDeliveryAndLosTime[] = ($lossTime);
                }
                // dump($deliEndTimeSeconds);
                // dump($lossTime);
                // dump('-----------------------');

                $avgResAndReq[] = collect($differenceResponAndRequest)->sum() / sizeof($differenceResponAndRequest);
                $avgDeliEndAndProses[] = collect($differenceDeliveryAndProses)->sum() / sizeof($differenceDeliveryAndProses);
                $totWaktuDeliAndReq[] = collect($differenceDeliveryAndRequest)->sum();
                $qtyReqDay[] = collect($qtyReqDayGroupedByDateAndName)->sum(); 
                $qtyActDay[] = collect($qtyActDayGroupedByDateAndName)->sum();
                $totLosTime[] = collect($differenceDeliveryAndLosTime)->sum() / sizeof($differenceDeliveryAndLosTime);

                // dump($qtyReqDay);

                // Total Request pada Line keberapa
                $dataAllLine['totalRequest'] = $stowersByDateAndLine->count();
                $dataAllLine['avgResponTime'] = collect($differenceResponAndRequest)->sum() / sizeof($differenceResponAndRequest);
                $dataAllLine['totalLossTime'] = collect($differenceDeliveryAndLosTime)->sum() / sizeof($differenceDeliveryAndLosTime);
                $dataAllLine['avgDeliveryTime'] = collect($differenceDeliveryAndProses)->sum() / sizeof($differenceDeliveryAndProses);
                $dataAllLine['totalDeliveryTime'] = collect($differenceDeliveryAndRequest)->sum();
                $dataAllLine['totalRequestPerDay'] = collect($qtyReqDayGroupedByDateAndName)->sum();
                $dataAllLine['totalActualPerDay'] = collect($qtyActDayGroupedByDateAndName)->sum();

                $dataAllLineGroupedbyDate[] = $dataAllLine;
            }
            // dump($dataAllLineGroupedbyDate);


            //rata-rata untuk setiap line
                $avgAlldataPerLineAndDate['avgTotalRequest'] = collect($dataAllLineGroupedbyDate)->pluck('totalRequest')->avg();
                $avgAlldataPerLineAndDate['avgAvgResponTime'] = collect($dataAllLineGroupedbyDate)->pluck('avgResponTime')->avg();
                $avgAlldataPerLineAndDate['avgTotalLossTime'] = collect($dataAllLineGroupedbyDate)->pluck('totalLossTime')->avg();
                $avgAlldataPerLineAndDate['avgAvgDeliveryTime'] = collect($dataAllLineGroupedbyDate)->pluck('avgDeliveryTime')->avg();
                $avgAlldataPerLineAndDate['avgTotalDeliveryTime'] = collect($dataAllLineGroupedbyDate)->pluck('totalDeliveryTime')->avg();
                $avgAlldataPerLineAndDate['avgTotalRequestPerDay'] = collect($dataAllLineGroupedbyDate)->pluck('totalRequestPerDay')->avg();
                $avgAlldataPerLineAndDate['avgTotalActualPerDay'] = collect($dataAllLineGroupedbyDate)->pluck('totalActualPerDay')->avg();

                $avgAllDataPerLineAndDate[] = $avgAlldataPerLineAndDate;

                $sumAllDataPerLineAndDate['sumTotalRequest'] = collect($dataAllLineGroupedbyDate)->pluck('totalRequest')->sum();
                $sumAllDataPerLineAndDate['sumResponTime'] = collect($dataAllLineGroupedbyDate)->pluck('avgResponTime')->sum();
                $sumAllDataPerLineAndDate['sumTotalLossTime'] = collect($dataAllLineGroupedbyDate)->pluck('totalLossTime')->sum();
                $sumAllDataPerLineAndDate['sumDeliveryTime'] = collect($dataAllLineGroupedbyDate)->pluck('avgDeliveryTime')->sum();
                $sumAllDataPerLineAndDate['sumTotalDeliveryTime'] = collect($dataAllLineGroupedbyDate)->pluck('totalDeliveryTime')->sum();
                $sumAllDataPerLineAndDate['sumTotalRequestPerDay'] = collect($dataAllLineGroupedbyDate)->pluck('totalRequestPerDay')->sum();
                $sumAllDataPerLineAndDate['sumTotalActualPerDay'] = collect($dataAllLineGroupedbyDate)->pluck('totalActualPerDay')->sum();

                $sumAllDataPerLineAndDate[] = $sumAllDataPerLineAndDate;
            // dump( collect($dataAllLineGroupedbyDate)->pluck('totalRequest')->sum());
                // dump( collect($dataAllLineGroupedbyDate)->pluck('totalRequest')->sum());
                // dump( collect($dataAllLineGroupedbyDate)->pluck('avgResponTime')->avg());
                // dump( collect($dataAllLineGroupedbyDate)->pluck('avgDeliveryTime')->avg());
                // dump( "--------------------------------------------------------------------");
            //menampung rata rata ke array
                $rataRataResponTime[] = $avgResAndReq;
                $jumlahTargetPerHari[] = $qtyReqDay;
                $rataRataDeliEndTime[] = $avgDeliEndAndProses;
                $totWaktuDeliveryTime[] = $totWaktuDeliAndReq;
                $jumlahLosTime [] = $totLosTime;
                $jumlahRemarkPerHari [] = $qtyActDay;
        }

        // dump($rataRataResponTime);

        return view('production.reporttower', [
                'stowers' => $stowers,
                'rataRataResponTime' => $rataRataResponTime,
                'rataRataDeliEndTime' => $rataRataDeliEndTime,
                'jumlahTargetPerHari' => $jumlahTargetPerHari,
                'totWaktuDeliveryTime' => $totWaktuDeliveryTime,
                'jumlahLosTime' => $jumlahLosTime,
                '$lossTime' =>$lossTime,
                'jumlahRemarkPerHari' =>$jumlahRemarkPerHari,
                'avgAllDataPerLineAndDate' => $avgAllDataPerLineAndDate,
                'sumAllDataPerLineAndDate' => $sumAllDataPerLineAndDate,
        ]);
    }

    //tampilan halaman performance
    public function perform()
    {
        $stowers = Stower::all();
        // dd ($stowers);
        $stowerGroupedByDate = $stowers->groupBy('tanggal')->values();

        $rataRataResponTime = [];
        $rataRataDeliEndTime = [];
        $totWaktuDeliveryTime = [];
        $jumlahTargetPerHari = [];
        $jumlahLosTime = [];
        $jumlahRemarkPerHari = [];
        $avgAllDataPerLineAndDate = [];
        $sumAllDataPerLineAndDate = [];
        $pemenuhanRequest = [];

        foreach ($stowerGroupedByDate as $stowersByDate) {

            $stowerGroupedByNameAndDate = $stowersByDate->sortBy('namaline')->groupBy('namaline')->values();
            // dump($stowerGroupedByNameAndDate);
            $avgResAndReq = [];
            $avgDeliEndAndProses = [];
            $totWaktuDeliAndReq = [];
            $qtyReqDay = [];
            $qtyActDay = [];
            $totLosTime =[];
            $dataAllLineGroupedbyDate = [];
            $sumdataAllLineGroupedbyDate = [];
            $qtyActAndReq = [];

            foreach ($stowerGroupedByNameAndDate as $stowersByDateAndLine) {

                $differenceResponAndRequest = [];
                $differenceDeliveryAndProses = [];
                $differenceDeliveryAndRequest = [];
                $qtyReqDayGroupedByDateAndName = [];
                $differenceDeliveryAndLosTime = [];
                $qtyActDayGroupedByDateAndName = [];
                $differenceActualAndRequest = [];
                
                foreach ($stowersByDateAndLine as $stower) {

                     // Remark / QTY Actuall
                    if(gettype((int)$stower->Remark) === "integer" &&  $stower->Remark !== null && (int)$stower->Remark > 0){
                        $qtyActDayGroupedByDateAndName[] = (int)$stower->Remark;
                        $qtyAct = (int)$stower->Remark;
                    } else {
                        $qtyActDayGroupedByDateAndName[] = 0;
                        $qtyAct = 0;
                    }
                    // dump((int)$stower->Remark);
                
                    if(gettype((int)$stower->lostim) === "integer" && (int)$stower->lostim > 0){
                        $lossTime = (int)$stower->lostim;
                    } else {
                        $lossTime = 0; 
                    }
                    // dd($lossTime);
                    // Delivery End
                    if ($stower->deliend !== "" && $stower->deliend !== null) {
                        $deliendTime = explode(':', $stower->deliend);
                        $deliendJam = ((int) $deliendTime[0]) * 3600;
                        $deliendMenit = ((int) $deliendTime[1]) * 60;
                        $deliendDetik = ((int) $deliendTime[2]);
                        $deliEndTimeSeconds = $deliendJam + $deliendMenit + $deliendDetik;
                    } else {
                        $deliEndTimeSeconds = 0;
                    }

                    // proses end
                     if ($stower->prosesend !== "" && $stower->prosesend !== null) {
                        $prosesendTime = explode(':', $stower->prosesend);
                        $prosesendJam = ((int) $prosesendTime[0]) * 3600;
                        $prosesendMenit = ((int) $prosesendTime[1]) * 60;
                        $prosesendDetik = ((int) $prosesendTime[2]);
                        $prosesEndTimeSeconds = $prosesendJam + $prosesendMenit + $prosesendDetik;
                    } else {
                        $prosesEndTimeSeconds = 0;
                    }

                    // Target perday
                    if(gettype((int)$stower->target_perday) === "integer" && (int)$stower->target_perday > 0){
                        $qtyReqDayGroupedByDateAndName[] = (int)$stower->target_perday;
                        $qtyReq = (int)$stower->target_perday;
                    } else {
                        // dump((int)$stower->target_perday);
                        $qtyReqDayGroupedByDateAndName[] = 0;
                        $qtyReq = 0;
                    }
                    
                    // Response Time
                    if ($stower->resline !== "" && $stower->resline !== null) {
                        $resTime = explode(':', $stower->resline);
                        $resJam = ((int) $resTime[0]) * 3600;
                        $resMenit = ((int) $resTime[1]) * 60;
                        $resDetik = ((int) $resTime[2]);
                        $responTimeSeconds = $resJam + $resMenit + $resDetik;
                    } else {
                        $responTimeSeconds = 0;
                    }
                    
                    // Resquest Time
                    if ($stower->reqlin !== "" && $stower->reqlin !== null) {
                        $reqTime = explode(':', $stower->reqlin);
                        $reqJam = ((int) $reqTime[0]) * 3600;
                        $reqMenit = ((int) $reqTime[1]) * 60;
                        $reqDetik = ((int) $reqTime[2]);
                        $requestTimeSeconds = $reqJam + $reqMenit + $reqDetik;
                    } else {
                        $requestTimeSeconds = 0;
                    }
                    
                    //Hasil selisih dikonversi kembali ke bentuk waktu (Menit)
                    $differenceResponAndRequest[] = ($responTimeSeconds - $requestTimeSeconds) / 60;
                    $differenceDeliveryAndRequest[] = ($deliEndTimeSeconds - $requestTimeSeconds) / 60;
                    $differenceDeliveryAndProses[] = ($deliEndTimeSeconds - $prosesEndTimeSeconds)/60;
                    $differenceDeliveryAndLosTime[] = ($lossTime);
                    // $differenceActualAndRequest[] = ($qtyAct / $qtyReq) * 100; //kemungkinan seharusnya perhitungannya bukan disini
                    // dump($qtyAct);
                    // dump($qtyReq);
                    // dump(($qtyAct / $qtyReq) * 100);
                    // dump('=============================');
                }

                // $avgResAndReq[] = collect($differenceResponAndRequest)->sum() / sizeof($differenceResponAndRequest); //sebenernya bisa pake avg()
                $avgResAndReq[] = collect($differenceResponAndRequest)->avg(); //sebenernya bisa pake avg()
                // $avgDeliEndAndProses[] = collect($differenceDeliveryAndProses)->sum() / sizeof($differenceDeliveryAndProses); //avg()
                $avgDeliEndAndProses[] = collect($differenceDeliveryAndProses)->avg(); //avg()
                $totWaktuDeliAndReq[] = collect($differenceDeliveryAndRequest)->sum();
                $qtyReqDay[] = collect($qtyReqDayGroupedByDateAndName)->sum(); 
                $qtyActDay[] = collect($qtyActDayGroupedByDateAndName)->sum();
                // $totLosTime[] = collect($differenceDeliveryAndLosTime)->sum() / sizeof($differenceDeliveryAndLosTime);
                $totLosTime[] = collect($differenceDeliveryAndLosTime)->avg();

                // dump($qtyActAndReq);

                // Total Request pada Line keberapa
                $dataAllLine['totalRequest'] = $stowersByDateAndLine->count();
                // $dataAllLine['avgResponTime'] = collect($differenceResponAndRequest)->sum() / sizeof($differenceResponAndRequest);
                // $dataAllLine['totalLossTime'] = collect($differenceDeliveryAndLosTime)->sum() / sizeof($differenceDeliveryAndLosTime);
                // $dataAllLine['avgDeliveryTime'] = collect($differenceDeliveryAndProses)->sum() / sizeof($differenceDeliveryAndProses);
                $dataAllLine['avgResponTime'] = collect($differenceResponAndRequest)->avg();
                $dataAllLine['totalLossTime'] = collect($differenceDeliveryAndLosTime)->avg();
                $dataAllLine['avgDeliveryTime'] = collect($differenceDeliveryAndProses)->avg();
                $dataAllLine['totalDeliveryTime'] = collect($differenceDeliveryAndRequest)->sum();
                $dataAllLine['totalRequestPerDay'] = collect($qtyReqDayGroupedByDateAndName)->sum();
                $dataAllLine['totalActualPerDay'] = collect($qtyActDayGroupedByDateAndName)->sum();
                $dataAllLine['totalActualAndReq'] = collect($qtyActDayGroupedByDateAndName)->sum();

                $dataAllLineGroupedbyDate[] = $dataAllLine;
            }
        // dd($dataAllLineGroupedbyDate);

            //rata-rata untuk setiap line
            $avgAllDataPerLineAndDate[] = [
                'avgTotalRequest' => collect($dataAllLineGroupedbyDate)->pluck('totalRequest')->avg(),
                'avgAvgResponTime' => collect($dataAllLineGroupedbyDate)->pluck('avgResponTime')->avg(),
                'avgAvgDeliveryTime' => collect($dataAllLineGroupedbyDate)->pluck('avgDeliveryTime')->avg(),
                'avgTotalLossTime' =>collect($dataAllLineGroupedbyDate)->pluck('totalLossTime')->avg(),
                'avgTotalDeliveryTime' =>collect($dataAllLineGroupedbyDate)->pluck('totalDeliveryTime')->avg(),
                'avgTotalRequestPerDay' =>collect($dataAllLineGroupedbyDate)->pluck('totalRequestPerDay')->avg(),
                'avgTotalActualPerDay' => collect($dataAllLineGroupedbyDate)->pluck('totalActualPerDay')->avg(),
            ];

            
            /* 
            Kemungkinan lakuin perhitungannya disini 
            collect($qtyReqDayGroupedByDateAndName)->sum() / collect($qtyActDayGroupedByDateAndName)->sum() * 100
            */
            // $qtyActAndReq[] = collect($differenceActualAndRequest)->sum();
            $qtyActAndReq[] = (
                collect($dataAllLineGroupedbyDate)->pluck('totalActualPerDay')->avg() /
                collect($dataAllLineGroupedbyDate)->pluck('totalRequestPerDay')->avg()
            ) * 100;

            // $avgAllDataPerLineAndDate[] = $avgAlldataPerLineAndDate;

            $sumAllDataPerLineAndDate[] = [
                'sumTotalRequest' => collect($dataAllLineGroupedbyDate)->pluck('totalRequest')->sum(),
                'sumResponTime' => collect($dataAllLineGroupedbyDate)->pluck('avgResponTime')->sum(),
                'sumTotalLossTime' => collect($dataAllLineGroupedbyDate)->pluck('totalLossTime')->sum(),
                'sumDeliveryTime' => collect($dataAllLineGroupedbyDate)->pluck('avgDeliveryTime')->sum(),
                'sumTotalDeliveryTime' => collect($dataAllLineGroupedbyDate)->pluck('totalDeliveryTime')->sum(),
                'sumTotalRequestPerDay' =>collect($dataAllLineGroupedbyDate)->pluck('totalRequestPerDay')->sum(), 
                'sumTotalActualPerDay' => collect($dataAllLineGroupedbyDate)->pluck('totalActualPerDay')->sum(),
                'sumTotalActualAndReq' => collect($dataAllLineGroupedbyDate)->pluck('totalActualAndReq')->sum(),
            ];
            

            // $sumAllDataPerLineAndDate[] = $sumAllDataPerLineAndDate; //ini keliru
            // $sumAllDataPerLineAndDate[] = $sumAllDataPerLineAndDate;
            // dump( collect($dataAllLineGroupedbyDate)->pluck('totalActualPerDay')->sum(),
            // collect($dataAllLineGroupedbyDate)->pluck('totalRequestPerDay')->sum());
            // dump( "--------------------------------------------------------------------");
            // dump( collect($dataAllLineGroupedbyDate)->pluck('avgResponTime')->avg());
            // dump( collect($dataAllLineGroupedbyDate)->pluck('avgDeliveryTime')->avg());
            //menampung rata rata ke array
            $rataRataResponTime[] = $avgResAndReq;
            $jumlahTargetPerHari[] = $qtyReqDay;
            $rataRataDeliEndTime[] = $avgDeliEndAndProses;
            $totWaktuDeliveryTime[] = $totWaktuDeliAndReq;
            $jumlahLosTime [] = $totLosTime;
            $jumlahRemarkPerHari [] = $qtyActDay;

            // $pemenuhanRequest[] = $differenceActualAndRequest; //Ini keliru kayanya ya? 
            $pemenuhanRequest[] = $qtyActAndReq;
        }
        
        // dump($pemenuhanRequest);
        // dd($avgAllDataPerLineAndDate);
        // dd($pemenuhanRequest, $avgAlldataPerLineAndDate, $sumAllDataPerLineAndDate);
        // dump($avgAllDataPerLineAndDate);
        return view('production.perform',[
            'stowers' => $stowers,
            'avgAllDataPerLineAndDate' => $avgAllDataPerLineAndDate,
            'pemenuhanRequest' => $pemenuhanRequest,
            'sumAllDataPerLineAndDate' => $sumAllDataPerLineAndDate,
        ]);
    }

    //tampilan halaman grafik
    public function grafik()
    {
        $stowers = Stower::all();
        // dd ($stowers);
        $stowerGroupedByDate = $stowers->groupBy('tanggal')->values(); //ini grouping berdasarkan tanggal

        $rataRataResponTime = [];
        $rataRataDeliEndTime = [];
        $totWaktuDeliveryTime = [];
        $jumlahTargetPerHari = [];
        $jumlahLosTime = [];
        $jumlahRemarkPerHari = [];
        $avgAllDataPerLineAndDate = [];
        $sumAllDataPerLineAndDate = [];
        $pemenuhanRequest = [];

        $tanggals = [];

        foreach ($stowerGroupedByDate as $key => $stowersByDate) {
            //Kalau engga salah, kmrn $key ini valuenya adalah berupa date yg hasil grouping
            $tanggals[] = $key; //ini akan menyimpan tanggalnya

            $stowerGroupedByNameAndDate = $stowersByDate->sortBy('namaline')->groupBy('namaline')->values(); //ini group berdasarkan namaline
            // dump($stowerGroupedByNameAndDate);
            $avgResAndReq = [];
            $avgDeliEndAndProses = [];
            $totWaktuDeliAndReq = [];
            $qtyReqDay = [];
            $qtyActDay = [];
            $totLosTime =[];
            $dataAllLineGroupedbyDate = [];
            $sumdataAllLineGroupedbyDate = [];
            $qtyActAndReq = [];

            foreach ($stowerGroupedByNameAndDate as $stowersByDateAndLine) {

                $differenceResponAndRequest = [];
                $differenceDeliveryAndProses = [];
                $differenceDeliveryAndRequest = [];
                $qtyReqDayGroupedByDateAndName = [];
                $differenceDeliveryAndLosTime = [];
                $qtyActDayGroupedByDateAndName = [];
                $differenceActualAndRequest = [];
                
                foreach ($stowersByDateAndLine as $stower) {

                     // Remark / QTY Actuall
                    if(gettype((int)$stower->Remark) === "integer" &&  $stower->Remark !== null && (int)$stower->Remark > 0){
                        $qtyActDayGroupedByDateAndName[] = (int)$stower->Remark;
                        $qtyAct = (int)$stower->Remark;
                    } else {
                        $qtyActDayGroupedByDateAndName[] = 0;
                        $qtyAct = 0;
                    }
                    // dump((int)$stower->Remark);
                
                    if(gettype((int)$stower->lostim) === "integer" && (int)$stower->lostim > 0){
                        $lossTime = (int)$stower->lostim;
                    } else {
                        $lossTime = 0; 
                    }
                    // dd($lossTime);
                    // Delivery End
                    if ($stower->deliend !== "" && $stower->deliend !== null) {
                        $deliendTime = explode(':', $stower->deliend);
                        $deliendJam = ((int) $deliendTime[0]) * 3600;
                        $deliendMenit = ((int) $deliendTime[1]) * 60;
                        $deliendDetik = ((int) $deliendTime[2]);
                        $deliEndTimeSeconds = $deliendJam + $deliendMenit + $deliendDetik;
                    } else {
                        $deliEndTimeSeconds = 0;
                    }

                    // proses end
                     if ($stower->prosesend !== "" && $stower->prosesend !== null) {
                        $prosesendTime = explode(':', $stower->prosesend);
                        $prosesendJam = ((int) $prosesendTime[0]) * 3600;
                        $prosesendMenit = ((int) $prosesendTime[1]) * 60;
                        $prosesendDetik = ((int) $prosesendTime[2]);
                        $prosesEndTimeSeconds = $prosesendJam + $prosesendMenit + $prosesendDetik;
                    } else {
                        $prosesEndTimeSeconds = 0;
                    }

                    // Target perday
                    if(gettype((int)$stower->target_perday) === "integer" && (int)$stower->target_perday > 0){
                        $qtyReqDayGroupedByDateAndName[] = (int)$stower->target_perday;
                        $qtyReq = (int)$stower->target_perday;
                    } else {
                        // dump((int)$stower->target_perday);
                        $qtyReqDayGroupedByDateAndName[] = 0;
                        $qtyReq = 0;
                    }
                    
                    // Response Time
                    if ($stower->resline !== "" && $stower->resline !== null) {
                        $resTime = explode(':', $stower->resline);
                        $resJam = ((int) $resTime[0]) * 3600;
                        $resMenit = ((int) $resTime[1]) * 60;
                        $resDetik = ((int) $resTime[2]);
                        $responTimeSeconds = $resJam + $resMenit + $resDetik;
                    } else {
                        $responTimeSeconds = 0;
                    }
                    
                    // Resquest Time
                    if ($stower->reqlin !== "" && $stower->reqlin !== null) {
                        $reqTime = explode(':', $stower->reqlin);
                        $reqJam = ((int) $reqTime[0]) * 3600;
                        $reqMenit = ((int) $reqTime[1]) * 60;
                        $reqDetik = ((int) $reqTime[2]);
                        $requestTimeSeconds = $reqJam + $reqMenit + $reqDetik;
                    } else {
                        $requestTimeSeconds = 0;
                    }
                    
                    //Hasil selisih dikonversi kembali ke bentuk waktu (Menit)
                    $differenceResponAndRequest[] = ($responTimeSeconds - $requestTimeSeconds) / 60;
                    $differenceDeliveryAndRequest[] = ($deliEndTimeSeconds - $requestTimeSeconds) / 60;
                    $differenceDeliveryAndProses[] = ($deliEndTimeSeconds - $prosesEndTimeSeconds)/60;
                    $differenceDeliveryAndLosTime[] = ($lossTime);
                }

                $avgResAndReq[] = collect($differenceResponAndRequest)->avg(); 
                $avgDeliEndAndProses[] = collect($differenceDeliveryAndProses)->avg(); 
                $totWaktuDeliAndReq[] = collect($differenceDeliveryAndRequest)->sum();
                $qtyReqDay[] = collect($qtyReqDayGroupedByDateAndName)->sum(); 
                $qtyActDay[] = collect($qtyActDayGroupedByDateAndName)->sum();
                $totLosTime[] = collect($differenceDeliveryAndLosTime)->avg();

                // dump($qtyActAndReq);

                // Total Request pada Line keberapa
                $dataAllLine['totalRequest'] = $stowersByDateAndLine->count();
                $dataAllLine['avgResponTime'] = collect($differenceResponAndRequest)->avg();
                $dataAllLine['totalLossTime'] = collect($differenceDeliveryAndLosTime)->avg();
                $dataAllLine['avgDeliveryTime'] = collect($differenceDeliveryAndProses)->avg();
                $dataAllLine['totalDeliveryTime'] = collect($differenceDeliveryAndRequest)->sum();
                $dataAllLine['totalRequestPerDay'] = collect($qtyReqDayGroupedByDateAndName)->sum();
                $dataAllLine['totalActualPerDay'] = collect($qtyActDayGroupedByDateAndName)->sum();
                $dataAllLine['totalActualAndReq'] = collect($qtyActDayGroupedByDateAndName)->sum();

                $dataAllLineGroupedbyDate[] = $dataAllLine;
            }
        // dd($dataAllLineGroupedbyDate);

            //rata-rata untuk setiap line
            $avgAllDataPerLineAndDate[] = [
                'avgTotalRequest' => collect($dataAllLineGroupedbyDate)->pluck('totalRequest')->avg(),
                'avgAvgResponTime' => collect($dataAllLineGroupedbyDate)->pluck('avgResponTime')->avg(),
                'avgAvgDeliveryTime' => collect($dataAllLineGroupedbyDate)->pluck('avgDeliveryTime')->avg(),
                'avgTotalLossTime' =>collect($dataAllLineGroupedbyDate)->pluck('totalLossTime')->avg(),
                'avgTotalDeliveryTime' =>collect($dataAllLineGroupedbyDate)->pluck('totalDeliveryTime')->avg(),
                'avgTotalRequestPerDay' =>collect($dataAllLineGroupedbyDate)->pluck('totalRequestPerDay')->avg(),
                'avgTotalActualPerDay' => collect($dataAllLineGroupedbyDate)->pluck('totalActualPerDay')->avg(),
            ];

            
            $qtyActAndReq[] = (
                collect($dataAllLineGroupedbyDate)->pluck('totalActualPerDay')->avg() /
                collect($dataAllLineGroupedbyDate)->pluck('totalRequestPerDay')->avg()
            ) * 100;

            // $avgAllDataPerLineAndDate[] = $avgAlldataPerLineAndDate;

            $sumAllDataPerLineAndDate[] = [
                'sumTotalRequest' => collect($dataAllLineGroupedbyDate)->pluck('totalRequest')->sum(),
                'sumResponTime' => collect($dataAllLineGroupedbyDate)->pluck('avgResponTime')->sum(),
                'sumTotalLossTime' => collect($dataAllLineGroupedbyDate)->pluck('totalLossTime')->sum(),
                'sumDeliveryTime' => collect($dataAllLineGroupedbyDate)->pluck('avgDeliveryTime')->sum(),
                'sumTotalDeliveryTime' => collect($dataAllLineGroupedbyDate)->pluck('totalDeliveryTime')->sum(),
                'sumTotalRequestPerDay' =>collect($dataAllLineGroupedbyDate)->pluck('totalRequestPerDay')->sum(), 
                'sumTotalActualPerDay' => collect($dataAllLineGroupedbyDate)->pluck('totalActualPerDay')->sum(),
                'sumTotalActualAndReq' => collect($dataAllLineGroupedbyDate)->pluck('totalActualAndReq')->sum(),
            ];
            
                //menampung rata rata ke array
                $rataRataResponTime[] = $avgResAndReq;
                $jumlahTargetPerHari[] = $qtyReqDay;
                $rataRataDeliEndTime[] = $avgDeliEndAndProses;
                $totWaktuDeliveryTime[] = $totWaktuDeliAndReq;
                $jumlahLosTime [] = $totLosTime;
                $jumlahRemarkPerHari [] = $qtyActDay;

            // $pemenuhanRequest[] = $differenceActualAndRequest; //Ini keliru kayanya ya? 
            $pemenuhanRequest[] = $qtyActAndReq;
        }
        // dd($avgAllDataPerLineAndDate);
        return view('production.grafik', [
            'stowers' => $stowers,
            
            'avgAllDataPerLineAndDate' => $avgAllDataPerLineAndDate,
            'pemenuhanRequest' => $pemenuhanRequest,
            'sumAllDataPerLineAndDate' => $sumAllDataPerLineAndDate,
        ]);
    }

    public function getAvgTotalResponseTime()
    {
        $data = collect([10,20,30,40,50,60,70,80,90]); 

        //lakuan perhitungan seperti biasa yg kita lakuin kmrn kmrn.
        $avgAvgResponTime = []; //data kamuuu
        $qtyReqDay = [];
        return response([
            'guide' => 'Data yang ingin dikirimkan bisa dituliskan disini',
            'data' => $data, //letakkan disini variabelnya yang isi data ratar ata
            // 'tanggalnya' => $tanggalRequest, //
            // 'data' => $avgAvgResponTime,
        ], Response::HTTP_OK);
    }
}