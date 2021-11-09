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

        // Melakukan pengelompokan berdasarkan tanggal request tertentu
        $stowerGroupedByDate = $stowers->groupBy('date')->values();
        // variabel untuk menampung hasil rata rata respon time berdasarkan date dan nama line 
        //untuk variabel yang akan digunakan sebaiknya di definisikan kosongan dulu
        $rataRataResponTime = [];
        $jumlahTargetPerHari = [];
        // untuk memanggil hasil pengelompokan berdasarkan date dgn perulangan
        foreach ($stowerGroupedByDate as $stowersByDate) {
            // Dari masing-masing kelompok data (by date) dikelompokan lagi berdasarkan nama line 
            $stowerGroupedByNameAndDate = $stowersByDate->sortBy('namaline')->groupBy('namaline')->values();
            // dump($stowerGroupedByNameAndDate);

            //variabel array ini didefinisikan untuk menyimpan rata rata per nama line
            $avgResAndReq = [];
            //ini variabel array untuk menampung data target_perhari yang berdasarkan date
            $qtyReqDay = [];
            // untuk memanggil hasil pengelompokan berdasarkan nameline dgn perulangan
            foreach ($stowerGroupedByNameAndDate as $stowersByDate) {
                // variabel array ini berguna untuk menampung hasil pengurangan response time dan request time
                $differenceResponAndRequest = [];
                // melakukan looping pada hasil kelompok

                //jangan lupa ini ditambahkan untuk nampung data target_perhari yang berdasarkan namaline
                $qtyReqDayGroupedByDateAndName = []; 
                foreach ($stowersByDate as $stower) {
                    /**
                     * Tempat ini bisa panggil data kolom table apa saja.
                     * contoh:  id, namaline, resline, reqlin, dkk
                     */

                    // agar bisa tertampung semua target_perday berdasarkan namaline dan date sebagai item di array, tambahkan []
                    //parsing tipe data dari string ke int
                    if(gettype((int)$stower->target_perday) === "integer" && (int)$stower->target_perday > 0){
                        $qtyReqDayGroupedByDateAndName[] = (int)$stower->target_perday;
                    } else {
                        // dump((int)$stower->target_perday);
                        $qtyReqDayGroupedByDateAndName[] = (int)$stower->target_perday;
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
                }
                // Hasil rata rata dan tampung dalam variabel array
                // sum() -> untuk melakukan penjumlahan seluruh data dalam collectoin
                // sizeof() -> untuk menghitung total item dalam array
                $avgResAndReq[] = collect($differenceResponAndRequest)->sum() / sizeof($differenceResponAndRequest);

                //seharusnya berupa array
                // dump($qtyReqDays);
                $qtyReqDay[] = collect($qtyReqDayGroupedByDateAndName)->sum();
                // dd($qtyReqDay);
            }
            //  dd(collect($qtyReqDays));

            //menampung rata rata ke array
            $rataRataResponTime[] = $avgResAndReq;
            $jumlahTargetPerHari[] = $qtyReqDay;
        }
                    
        // Manfaatkan die and dump untuk melihat struktur collection, agar mudah merumuskan struktur tabelnya
        // dd($jumlahTargetPerHari);

        return view('production.reporttower', [
            'stowers' => $stowers,
            'rataRataResponTime' => $rataRataResponTime,
            'jumlahTargetPerHari' => $jumlahTargetPerHari,
        ]);
    }

    //tampilan halaman performance
    public function perform()
    {

        return view('production.perform');
    }

    public function grafik()
    {
        $data = Stower::all();
        return view('production.grafik', compact('data'));
    }
}
