<?php

namespace App\Http\Controllers\production;

use Auth;
use App\User;
use App\Stower;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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
        $data = Stower::all();
        // dd ($data);

        return view('production.andon', compact('data'));
    }
    // report andon
    public function reporttower(Request $request)
    {
        $stowers = Stower::all();
        $stowerGroupedByDate = $stowers->groupBy('date')->values();

        $rataRataResponTime = [];
        $rataRataDeliEndTime = [];
        $totWaktuDeliveryTime = [];
        $jumlahTargetPerHari = [];
        $jumlahLosTime = [];
        $avgAllDataPerLineAndDate = [];

        foreach ($stowerGroupedByDate as $stowersByDate) {

            $stowerGroupedByNameAndDate = $stowersByDate->sortBy('namaline')->groupBy('namaline')->values();
            // dump($stowerGroupedByNameAndDate);
            $avgResAndReq = [];
            $avgDeliEndAndProses = [];
            $totWaktuDeliAndReq = [];
            $qtyReqDay = [];
            $totLosTime =[];
            $dataAllLineGroupedbyDate = [];

            foreach ($stowerGroupedByNameAndDate as $stowersByDateAndLine) {

                $differenceResponAndRequest = [];
                $differenceDeliveryAndProses = [];
                $differenceDeliveryAndRequest = [];
                $qtyReqDayGroupedByDateAndName = [];
                $differenceDeliveryAndLosTime = [];

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
                    // dump((int)$stower->lostim);
                    // dump(gettype($stower->lostim));
                    // dump(gettype((int)$stower->lostim));
                    // dump("------------------------------");

                    if(gettype((int)$stower->lostim) === "integer" && (int)$stower->lostim > 0){
                        $lossTime = (int)$stower->lostim;
                    } else {
                        //lebih baik ini langsung di passingkan dgn angka nol, karna diatas sudah diberi pengondisian "jika tidak nol"
                        $lossTime = 0; 
                    }
                    // dd($differenceDeliveryAndlostime);
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

                    $differenceDeliveryAndProses[] = ($deliEndTimeSeconds - $prosesEndTimeSeconds)/60;
                    $differenceDeliveryAndLosTime[] = ($deliEndTimeSeconds - $lossTime);


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
                    $differenceDeliveryAndRequest[] = ($deliEndTimeSeconds -  $requestTimeSeconds) / 60;
                }

                $avgResAndReq[] = collect($differenceResponAndRequest)->sum() / sizeof($differenceResponAndRequest);
                $avgDeliEndAndProses[] = collect($differenceDeliveryAndProses)->sum() / sizeof($differenceDeliveryAndProses);
                $totWaktuDeliAndReq[] = collect($differenceDeliveryAndRequest)->sum();
                $qtyReqDay[] = collect($qtyReqDayGroupedByDateAndName)->sum(); //ini dijadikan collection karna untuk melakukan panggilan method sum()
                $totLosTime[] = collect($differenceDeliveryAndLosTime)->sum();

                // dump($stowersByDateAndLine);

                // Total Request pada Line keberapa
                $dataAllLine['totalRequest'] = $stowersByDateAndLine->count();
                // Avg Request pada Line keberapa
                $dataAllLine['avgResponTime'] = collect($differenceResponAndRequest)->sum() / sizeof($differenceResponAndRequest);
                // totalLosTIme pada Line keberapa
                $dataAllLine['totalLossTime'] = collect($differenceDeliveryAndLosTime)->sum();
                // Avg Request pada Line keberapa
                $dataAllLine['avgDeliveryTime'] = collect($differenceDeliveryAndProses)->sum() / sizeof($differenceDeliveryAndProses);
                // totalDeliveryTime pada Line keberapa
                $dataAllLine['totalDeliveryTime'] = collect($differenceDeliveryAndRequest)->sum();
                // totalRequestPerDay pada Line keberapa
                $dataAllLine['totalRequestPerDay'] = collect($qtyReqDayGroupedByDateAndName)->sum();

                $dataAllLineGroupedbyDate[] = $dataAllLine;
            }
            // dump($dataAllLineGroupedbyDate);


            //disini tinggal lakukan rata rata                              pluck ini digunakan buat ambil index array yg spesifik
            $avgAlldataPerLineAndDate['avgTotalRequest'] = collect($dataAllLineGroupedbyDate)->pluck('totalRequest')->avg();
            // Avg Request pada Line keberapa
            $avgAlldataPerLineAndDate['avgAvgResponTime'] = collect($dataAllLineGroupedbyDate)->pluck('avgResponTime')->avg();
            // totalLosTIme pada Line keberapa
            $avgAlldataPerLineAndDate['avgTotalLossTime'] = collect($dataAllLineGroupedbyDate)->pluck('totalLossTime')->avg();
            // Avg Request pada Line keberapa
            $avgAlldataPerLineAndDate['avgAvgDeliveryTime'] = collect($dataAllLineGroupedbyDate)->pluck('avgDeliveryTime')->avg();
            // totalDeliveryTime pada Line keberapa
            $avgAlldataPerLineAndDate['avgTotalDeliveryTime'] = collect($dataAllLineGroupedbyDate)->pluck('totalDeliveryTime')->avg();
            // totalRequestPerDay pada Line keberapa
            $avgAlldataPerLineAndDate['avgTotalRequestPerDay'] = collect($dataAllLineGroupedbyDate)->pluck('totalRequestPerDay')->avg();

            $avgAllDataPerLineAndDate[] = $avgAlldataPerLineAndDate;

            //menampung rata rata ke array
            $rataRataResponTime[] = $avgResAndReq;
            $jumlahTargetPerHari[] = $qtyReqDay;
            $rataRataDeliEndTime[] = $avgDeliEndAndProses;
            $totWaktuDeliveryTime[] = $totWaktuDeliAndReq;
            $jumlahLosTime [] = $totLosTime;
        }

        // dd($avgAllDataPerLineAndDate);

        return view('production.reporttower', [
            'stowers' => $stowers,
            'rataRataResponTime' => $rataRataResponTime,
            'rataRataDeliEndTime' => $rataRataDeliEndTime,
            'jumlahTargetPerHari' => $jumlahTargetPerHari,
            'totWaktuDeliveryTime' => $totWaktuDeliveryTime,
            'jumlahLosTime' => $jumlahLosTime,
            'avgAllDataPerLineAndDate' => $avgAllDataPerLineAndDate,
        ]);
    }

    //tampilan halaman performance
    public function perform()
    {

        return view('production.perform');
    }
    //tampilan halaman grafik
    public function grafik()
    {
        $data = Stower::all();
        return view('production.grafik', compact('data'));
    }
}
