<?php

namespace App\Http\Controllers\production;

use Auth;
use App\User;
use App\Stower;
use Carbon\Carbon;
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
        $data= Stower ::all();
        // return $data;
    
        return view('production.andon', compact('data'));
    }
    // report andon
    public function create(Request $request)
    {
    // $data= Stower ::all();
    //dd($d);
        // jumlah  total waktu request semua line 
        $data = Stower :: groupBy('date')
                ->selectRaw('count(*) as totalwaktu, date')
                ->get();
dd($data);

        foreach ($data as $key => $value)
        {   // LINE 1 REQUEST
            $line1= Stower :: groupBy('date','namaline')
                    ->selectRaw('count(*) as total, namaline, date')
                    ->where('date','=',$value->date)
                    ->where('namaline','=','LINE 1')->first();
            
                        if($line1 != null){
                            $line1=$line1->total;
                        }
                        else{
                            $line1='0';
                        }
            // LINE 2 REQUEST
            $line2= Stower :: groupBy('date','namaline')
                    ->selectRaw('count(*) as total, namaline, date')
                    ->where('date','=',$value->date)
                    ->where('namaline','=','LINE 2')->first();
                        if($line2 != null){
                            $line2=$line2->total;
                        }
                        else{
                            $line2='0';
                        }
                        // dd($line2); 
            // LINE 3 REQUEST
            $line3= Stower :: groupBy('date','namaline')
                    ->selectRaw('count(*) as total, namaline, date')
                    ->where('date','=',$value->date)
                    ->where('namaline','=','LINE 3')->first();
                        if($line3 != null){
                            $line3=$line3->total;
                        }
                        else{
                            $line3='0';
                        }
            // LINE 4 REQUEST
            $line4= Stower :: groupBy('date','namaline')
                    ->selectRaw('count(*) as total, namaline, date')
                    ->where('date','=',$value->date)
                    ->where('namaline','=','LINE 4')->first();
                        if($line4 != null){
                            $line4=$line4->total;
                        }
                        else{
                            $line4='0';
                        }
            // LINE 5 REQUEST
            $line5= Stower :: groupBy('date','namaline')
                    ->selectRaw('count(*) as total, namaline, date')
                    ->where('date','=',$value->date)
                    ->where('namaline','=','LINE 5')->first();
                        if($line5 != null){
                            $line5=$line5->total;
                        }
                        else{
                            $line5='0';
                        }
            // LINE 6 REQUEST
            $line6= Stower :: groupBy('date','namaline')
                    ->selectRaw('count(*) as total, namaline, date')
                    ->where('date','=',$value->date)
                    ->where('namaline','=','LINE 6')->first();
                        if($line6 != null){
                            $line6=$line6->total;
                        }
                        else{
                            $line6='0';
                        }
            // LINE 7 REQUEST
            $line7= Stower :: groupBy('date','namaline')
                    ->selectRaw('count(*) as total, namaline, date')
                    ->where('date','=',$value->date)
                    ->where('namaline','=','LINE 7')->first();
                        if($line7 != null){
                            $line7=$line7->total;
                        }
                        else{
                            $line7='0';
                        }
                        
            $d[] = [
                'namaline' => $value->namaline,
                'reqlin'=>$value->reqlin,
                'date' => $value->date,
                'line1'=>$line1,
                'line2'=>$line2,
                'line3'=>$line3,
                'line4'=>$line4,
                'line5'=>$line5,
                'line6'=>$line6,
                'line7'=>$line7,
                'totalwaktu' =>$value->totalwaktu,
            ];

             $a[] = [
                'namaline' =>$value->namaline,
                'reqlin'=>$value->reqlin,
                'date' => $value->date,
                'line1'=>$line1,
                'line2'=>$line2,
                'line3'=>$line3,
                'line4'=>$line4,
                'line5'=>$line5,
                'line6'=>$line6,
                'line7'=>$line7,
                'totalwaktu' =>$value->totalwaktu,
            ];
        //    dd($a);

        }
        
        // $collection = collect($data);
    return view('production.create', compact('d'));
    }

    //tampilan halaman performance 
    public function perform()
    {
    // $data= Stower ::all();
    // $data = Stower :: groupBy('namaline','date')
    //         ->selectRaw('count(*) as total, date')
    //         ->get();
       
           
    //         //dd($data);
    //         foreach ($data as $key => $value){
                
    //             $d[] = [
    //                 'namaline' => $value->namaline,
    //                 // 'date' => $value->date,
    //                 'total' =>$value->total,
    //             ];
    //         }
      $data = Stower :: groupBy('namaline','target_perday')
                ->selectRaw('count(*) as total, namaline,target_perday')
                ->get();
                // dd($data);
    foreach ($data as $key => $value)
        {   // LINE 1 REQUEST
            $line2= Stower :: groupBy('date','namaline','target_perday')
                    ->selectRaw('count(*) as total,date,namaline,target_perday')
                    ->where('target_perday','=',$value->target_perday)
                    ->where('namaline','=','LINE 2')->first();
                        if($line2 != null){
                            $line2=$line2->total;
                        }
                        else{
                            $line2='0';
                        }
                        // dd($line2);
                 $d[] = [
                'namaline' => $value->namaline,
                'target_perday'=>$value->target_perday,
                'reqlin'=>$value->reqlin,
                'date' => $value->date,
                'line2'=>$line2,
                // 'totalavg'=>$value->totalavg,
                'totalqty' =>$value->totalqty,
            ];
            // dd($d);

        }

    return view('production.perform', compact('d'));
    }

    public function grafik()
    {
    $data= Stower ::all();
    return view('production.grafik', compact('data'));
    }

}
