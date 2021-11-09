<?php

namespace App\Http\Controllers\ggi_indah;

use DB;
use Auth;
use App\User;
use App\IndahVote;
use App\IndahKaryawan;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IreportController extends Controller
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
     // $tg= YEARWEEK(NOW());
     // WHERE YEARWEEK(tanggal)=YEARWEEK(NOW())
     //$t= date('w');
    // $b = Indahvote::whereyearweek('tgl_vote', '2021')->get();
       // $FirstDate = Carbon::createFromFormat('Y-m', $bulan)->firstOfMonth()->format('Y-m-d'); 
       // $LastDate = Carbon::createFromFormat('Y-m', $bulan)->endOfMonth()->format('Y-m-d');
     // dd($vote);

        
       // $tanggal = $request->tanggal;
      
        return view('indah/report/report');
    }

    public function getharian(Request $request)
        {
            
            $tanggal = $request->tanggal;
            $bulan ='';

            if(
                Indahvote::where('tgl_vote', $tanggal)->count()
            ) {

            $vote = Indahvote::where('tgl_vote', $tanggal)
            ->groupBy('nik', 'nama','bagian')
            ->selectRaw('count(*) as total, nik, nama, bagian')
            ->get();
            foreach ($vote as $key => $value) {

                $like = IndahVote::where('nik','=',$value->nik)->where('tgl_vote', $tanggal)->count('like');
            // dd($like);
            if($like!='0'){
            if(($like >='10') AND ($like <='30')){
                $bintang=' ⭐ ';
            }
            else if(($like >='31') AND ($like <='50')){
                $bintang= '⭐ ⭐';
            }
            else if(($like >='51') AND ($like <='70')){
                $bintang= '⭐ ⭐ ⭐ ';
            }
            else if(($like >='71') AND ($like <='90')){
                $bintang= '⭐ ⭐ ⭐ ⭐';
            }
            else if(($like >='91')){
                $bintang= '⭐ ⭐ ⭐ ⭐ ⭐';
            }
            else {
                $bintang='';
            }
                $dataKaryawanlike[] = [
                    'nik' => $value->nik,
                    'nama' => $value->nama,
                    'bagian' => $value->bagian,
                    'like' => $like,
                    'bintang' =>$bintang
                    
                ];
            
            }
        }
            $collection = collect($dataKaryawanlike);
            $test1 = $collection->sortByDesc('like')->take(5);

            // untuk tabel 2 
            $dataKaryawanDislike = [];



            foreach ($vote as $key => $value) {

                $dislike = IndahVote::where('nik','=',$value->nik)->where('tgl_vote', $tanggal)->count('dislike');
            
            
                // dd($like);

                if($dislike!='0'){
                $dataKaryawanDislike[] = [
                    'nik' => $value->nik,
                    'nama' => $value->nama,
                    'bagian' => $value->bagian,
                    'dislike' => $dislike
                    
                ];
            }
            }
            $collection = collect($dataKaryawanDislike);
            $test2 = $collection->sortByDesc('dislike')->take(5);

            return view('indah/report/rharian', compact( 'test2','vote','test1','tanggal','bulan'));
        }else{
            throw new \Exception('Data Kosong !');
            }
        }

        public function getmingguan(Request $request)
        {

            $tanggal = $request->tanggal;
            $bulan ='';

            $FirstDate = Carbon::createFromFormat('Y-m-d', $tanggal)->startOfWeek()->format('Y-m-d'); 
            $LastDate = Carbon::createFromFormat('Y-m-d', $tanggal)->endOfWeek()->format('Y-m-d'); 
        
        

        if(Indahvote::where('tgl_vote', '>=' , $FirstDate)->where('tgl_vote', '<=' , $LastDate)->count()){
            $vote = Indahvote::where('tgl_vote', '>=' , $FirstDate)->where('tgl_vote', '<=' , $LastDate)
            ->groupBy('nik', 'nama','bagian')
            ->selectRaw('count(*) as total, nik, nama, bagian')
            ->get();
            foreach ($vote as $key => $value) {

                $like = IndahVote::where('tgl_vote', '>=' , $FirstDate)->where('tgl_vote', '<=' , $LastDate)->where('nik','=',$value->nik)->count('like');
            // dd($like);
            if($like!='0'){
                if(($like >='10') AND ($like <='30')){
                    $bintang='⭐ ';
                }
                else if(($like >='31') AND ($like <='50')){
                    $bintang= '⭐ ⭐';
                }
                else if(($like >='51') AND ($like <='70')){
                    $bintang= '⭐ ⭐ ⭐';
                }
                else if(($like >='71') AND ($like <='90')){
                    $bintang= '⭐ ⭐ ⭐ ⭐';
                }
                else if(($like >='91')){
                    $bintang= '⭐ ⭐ ⭐ ⭐ ⭐';
                }
                else {
                    $bintang='';
                }
                $dataKaryawanlike[] = [
                    'nik' => $value->nik,
                    'nama' => $value->nama,
                    'bagian' => $value->bagian,
                    'like' => $like,
                    'bintang' => $bintang
                    
                ];
            }
        }
            $collection = collect($dataKaryawanlike);
            $test1 = $collection->sortByDesc('like')->take(5);

            // untuk tabel 2 
            $dataKaryawanDislike = [];



            foreach ($vote as $key => $value) {

                $dislike = IndahVote::where('tgl_vote', '>=' , $FirstDate)->where('tgl_vote', '<=' , $LastDate)->where('nik','=',$value->nik)->count('dislike');
            // dd($like);
            if($dislike!='0'){
                $dataKaryawanDislike[] = [
                    'nik' => $value->nik,
                    'nama' => $value->nama,
                    'bagian' => $value->bagian,
                    'dislike' => $dislike
                    
                ];
            }
        }
            $collection = collect($dataKaryawanDislike);
            $test2 = $collection->sortByDesc('dislike')->take(5);

            return view('indah/report/rmingguan', compact( 'test2','vote','test1','tanggal','bulan'));
        }else{
            throw new \Exception('Data Kosong !');
            }
        }

        
    public function getbulanan(Request $request)
        {
            $tanggal='';
            $bulan = $request->bulan;
            $FirstDate = Carbon::createFromFormat('Y-m', $bulan)->firstOfMonth()->format('Y-m-d'); 
            $LastDate = Carbon::createFromFormat('Y-m', $bulan)->endOfMonth()->format('Y-m-d'); 

        if(Indahvote::where('tgl_vote', '>=' , $FirstDate)->where('tgl_vote', '<=' , $LastDate)->count()){
            $vote = Indahvote::where('tgl_vote', '>=' , $FirstDate)->where('tgl_vote', '<=' , $LastDate)
            ->groupBy('nik', 'nama','bagian')
            ->selectRaw('count(*) as total, nik, nama, bagian')
            ->get();
            foreach ($vote as $key => $value) {

                $like = IndahVote::where('tgl_vote', '>=' , $FirstDate)->where('tgl_vote', '<=' , $LastDate)->where('nik','=',$value->nik)->count('like');
            // dd($like);
            if($like!='0'){
                if(($like >='10') AND ($like <='30')){
                    $bintang='⭐ ';
                }
                else if(($like >='31') AND ($like <='50')){
                    $bintang= '⭐ ⭐';
                }
                else if(($like >='51') AND ($like <='70')){
                    $bintang= '⭐ ⭐ ⭐';
                }
                else if(($like >='71') AND ($like <='90')){
                    $bintang= '⭐ ⭐ ⭐ ⭐';
                }
                else if(($like >='91')){
                    $bintang= '⭐ ⭐ ⭐ ⭐ ⭐';
                }
                else {
                    $bintang='';
                }
                $dataKaryawanlike[] = [
                    'nik' => $value->nik,
                    'nama' => $value->nama,
                    'bagian' => $value->bagian,
                    'like' => $like,
                    'bintang' => $bintang
                    
                ];
            }
        }
            $collection = collect($dataKaryawanlike);
            $test1 = $collection->sortByDesc('like')->take(5);

            // untuk tabel 2 
            $dataKaryawanDislike = [];



            foreach ($vote as $key => $value) {

                $dislike = IndahVote::where('tgl_vote', '>=' , $FirstDate)->where('tgl_vote', '<=' , $LastDate)->where('nik','=',$value->nik)->count('dislike');
            // dd($like);
            if($dislike!='0'){
                $dataKaryawanDislike[] = [
                    'nik' => $value->nik,
                    'nama' => $value->nama,
                    'bagian' => $value->bagian,
                    'dislike' => $dislike
                    
                ];
            }
        }
            $collection = collect($dataKaryawanDislike);
            $test2 = $collection->sortByDesc('dislike')->take(5);

            return view('indah/report/rbulan', compact( 'test2','vote','test1','tanggal','bulan'));
        }else{
            throw new \Exception('Data Kosong !');
            }
        }


        public function gettahunan(Request $request)
            {
                $tanggal='';
                $tahun = $request->tahun;
                $bulan='';
                
                

            if(Indahvote::whereYear('tgl_vote', '=' ,$tahun)->count()){
                $vote = Indahvote::whereYear('tgl_vote', '=' , $tahun)
                ->groupBy('nik', 'nama','bagian')
                ->selectRaw('count(*) as total, nik, nama, bagian')
                ->get();
                foreach ($vote as $key => $value) {

                    $like = IndahVote::whereYear('tgl_vote', '=' ,$tahun)->where('nik','=',$value->nik)->count('like');
                // dd($like);
                if($like!='0'){
                    if(($like >='10') AND ($like <='30')){
                        $bintang='⭐ ';
                    }
                    else if(($like >='31') AND ($like <='50')){
                        $bintang= '⭐ ⭐';
                    }
                    else if(($like >='51') AND ($like <='70')){
                        $bintang= '⭐ ⭐ ⭐';
                    }
                    else if(($like >='71') AND ($like <='90')){
                        $bintang= '⭐ ⭐ ⭐ ⭐';
                    }
                    else if(($like >='91')){
                        $bintang= '⭐ ⭐ ⭐ ⭐ ⭐';
                    }
                    else {
                        $bintang='';
                    }
                    $dataKaryawanlike[] = [
                        'nik' => $value->nik,
                        'nama' => $value->nama,
                        'bagian' => $value->bagian,
                        'like' => $like,
                        'bintang'=> $bintang 
                        
                    ];
                }
            }
                $collection = collect($dataKaryawanlike);
                $test1 = $collection->sortByDesc('like')->take(5);

                // untuk tabel 2 
                $dataKaryawanDislike = [];



                foreach ($vote as $key => $value) {

                    $dislike = IndahVote::whereYear('tgl_vote', '=' ,$tahun)->where('nik','=',$value->nik)->count('dislike');
                // dd($like);
                if($dislike!='0'){
                    $dataKaryawanDislike[] = [
                        'nik' => $value->nik,
                        'nama' => $value->nama,
                        'bagian' => $value->bagian,
                        'dislike' => $dislike
                        
                    ];
                }
            }
                $collection = collect($dataKaryawanDislike);
                $test2 = $collection->sortByDesc('dislike')->take(5);

                return view('indah/report/rtahun', compact( 'test2','vote','test1','tanggal','bulan','tahun'));
            }else{
                throw new \Exception('Data Kosong !');
                }
        }

    public function haridetail(Request $request)
    {
      
        $tanggal = $request->tanggal;
        $vote = Indahvote::where('tgl_vote', $tanggal)
        ->groupBy('nik', 'nama','bagian')
       ->selectRaw('count(*) as total, nik, nama, bagian')
       ->get();
      
      // dd($l);
        // mengambil data karyawan yang akan ditampilkan di views
        
        $dataKaryawanDislike = [];

        foreach ($vote as $key => $value) {

            $dislike = IndahVote::where('tgl_vote', $tanggal)->where('nik','=',$value->nik)->count('dislike');
            $like = IndahVote::where('tgl_vote', $tanggal)->where('nik','=',$value->nik)->count('like');
            if(($like >='10') AND ($like <='30')){
                $bintang='⭐ ';
            }
            else if(($like >='31') AND ($like <='50')){
                $bintang= '⭐ ⭐';
            }
            else if(($like >='51') AND ($like <='70')){
                $bintang= '⭐ ⭐ ⭐';
            }
            else if(($like >='71') AND ($like <='90')){
                $bintang= '⭐ ⭐ ⭐ ⭐';
            }
            else if(($like >='91')){
                $bintang= '⭐ ⭐ ⭐ ⭐ ⭐';
            }
            else {
                $bintang='';
            }
            // dd($like);
            $dataKaryawanDislike[] = [
                'nik' => $value->nik,
                'nama' => $value->nama,
                'bagian' => $value->bagian,
                'dislike' => $dislike,
                'like' => $like,
                'bintang' => $bintang
                
            ];
        }
        $collection = collect($dataKaryawanDislike);
        $test2 = $collection->sortByDesc('like');

        return view('indah/report/haridetail', compact( 'test2','vote','tanggal'));
    }

    public function minggudetail(Request $request)
    {
        $tanggal = $request->tanggal;
        $bulan ='';

        $FirstDate = Carbon::createFromFormat('Y-m-d', $tanggal)->startOfWeek()->format('Y-m-d'); 
        $LastDate = Carbon::createFromFormat('Y-m-d', $tanggal)->endOfWeek()->format('Y-m-d'); 
        $vote = Indahvote::where('tgl_vote', '>=' , $FirstDate)->where('tgl_vote', '<=' , $LastDate)
            ->groupBy('nik', 'nama','bagian')
            ->selectRaw('count(*) as total, nik, nama, bagian')
            ->get();
      
      // dd($l);
        // mengambil data karyawan yang akan ditampilkan di views
        
        $dataKaryawanDislike = [];

        foreach ($vote as $key => $value) {

            $like = IndahVote::where('tgl_vote', '>=' , $FirstDate)->where('tgl_vote', '<=' , $LastDate)->where('nik','=',$value->nik)->count('like');
            $dislike = IndahVote::where('tgl_vote', '>=' , $FirstDate)->where('tgl_vote', '<=' , $LastDate)->where('nik','=',$value->nik)->count('dislike');
            if(($like >='10') AND ($like <='30')){
                $bintang='⭐ ';
            }
            else if(($like >='31') AND ($like <='50')){
                $bintang= '⭐ ⭐';
            }
            else if(($like >='51') AND ($like <='70')){
                $bintang= '⭐ ⭐ ⭐';
            }
            else if(($like >='71') AND ($like <='90')){
                $bintang= '⭐ ⭐ ⭐ ⭐';
            }
            else if(($like >='91')){
                $bintang= '⭐ ⭐ ⭐ ⭐ ⭐';
            }
            else {
                $bintang='';
            }
            
            $dataKaryawanDislike[] = [
                'nik' => $value->nik,
                'nama' => $value->nama,
                'bagian' => $value->bagian,
                'dislike' => $dislike,
                'like' => $like,
                'bintang'=> $bintang
            ];
        }
        $collection = collect($dataKaryawanDislike);
        $test2 = $collection->sortByDesc('like');

        return view('indah/report/minggudetail', compact( 'test2','vote','tanggal'));
    }

    public function bulandetail(Request $request)
    {
      
        $bulan = $request->bulan;
        $FirstDate = Carbon::createFromFormat('Y-m', $bulan)->firstOfMonth()->format('Y-m-d'); 
        $LastDate = Carbon::createFromFormat('Y-m', $bulan)->endOfMonth()->format('Y-m-d'); 
        $vote = Indahvote::where('tgl_vote', '>=' , $FirstDate)->where('tgl_vote', '<=' , $LastDate)
            ->groupBy('nik', 'nama','bagian')
            ->selectRaw('count(*) as total, nik, nama, bagian')
            ->get();
      
      // dd($l);
        // mengambil data karyawan yang akan ditampilkan di views
        
        $dataKaryawanDislike = [];

        foreach ($vote as $key => $value) {

            $like = IndahVote::where('tgl_vote', '>=' , $FirstDate)->where('tgl_vote', '<=' , $LastDate)->where('nik','=',$value->nik)->count('like');
            $dislike = IndahVote::where('tgl_vote', '>=' , $FirstDate)->where('tgl_vote', '<=' , $LastDate)->where('nik','=',$value->nik)->count('dislike');
            if(($like >='10') AND ($like <='30')){
                $bintang='⭐ ';
            }
            else if(($like >='31') AND ($like <='50')){
                $bintang= '⭐ ⭐';
            }
            else if(($like >='51') AND ($like <='70')){
                $bintang= '⭐ ⭐ ⭐ ';
            }
            else if(($like >='71') AND ($like <='90')){
                $bintang= '⭐ ⭐ ⭐ ⭐';
            }
            else if(($like >='91')){
                $bintang= '⭐ ⭐ ⭐ ⭐ ⭐';
            }
            else {
                $bintang='';
            }
            
            $dataKaryawanDislike[] = [
                'nik' => $value->nik,
                'nama' => $value->nama,
                'bagian' => $value->bagian,
                'dislike' => $dislike,
                'like' => $like,
                'bintang'=> $bintang
            ];
        }
        $collection = collect($dataKaryawanDislike);
        $test2 = $collection->sortByDesc('like');

        return view('indah/report/bulandetail', compact( 'test2','vote','bulan'));
    }

    public function tahundetail(Request $request)
    {
      
        $tahun = $request->tahun;
        $vote = Indahvote::whereYear('tgl_vote', '=' , $tahun)
                ->groupBy('nik', 'nama','bagian')
                ->selectRaw('count(*) as total, nik, nama, bagian')
                ->get();
      
      // dd($l);
        // mengambil data karyawan yang akan ditampilkan di views
        
        $dataKaryawanDislike = [];

        foreach ($vote as $key => $value) {

            $like = IndahVote::whereYear('tgl_vote', '=' ,$tahun)->where('nik','=',$value->nik)->count('like');
            $dislike = IndahVote::whereYear('tgl_vote', '=' ,$tahun)->where('nik','=',$value->nik)->count('dislike');
            if(($like >='10') AND ($like <='30')){
                $bintang='⭐ ';
            }
            else if(($like >='31') AND ($like <='50')){
                $bintang= '⭐ ⭐';
            }
            else if(($like >='51') AND ($like <='70')){
                $bintang= '⭐ ⭐ ⭐ ';
            }
            else if(($like >='71') AND ($like <='90')){
                $bintang= '⭐ ⭐ ⭐ ⭐';
            }
            else if(($like >='91')){
                $bintang= '⭐ ⭐ ⭐ ⭐ ⭐';
            }
            else {
                $bintang='';
            }
            
            
            $dataKaryawanDislike[] = [
                'nik' => $value->nik,
                'nama' => $value->nama,
                'bagian' => $value->bagian,
                'dislike' => $dislike,
                'like' => $like,
                'bintang' => $bintang
                
            ];
        }
        $collection = collect($dataKaryawanDislike);
        $test2 = $collection->sortByDesc('like');

        return view('indah/report/tahundetail', compact( 'test2','vote','tahun'));
    }

}