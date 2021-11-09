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
        // $a= Stower :: groupBy('namaline')->get();
        $data = Stower :: groupBy('namaline','date')
        ->selectRaw('count(*) as total, namaline, date')
        ->get();
        // dd($data);
        // return($a);
        foreach ($data as $key => $value){
            $data = Stower::where('namaline','=',$value->namaline)->count('reqlin');
        }
        
        $data[] = [
            'namaline' => $value->namaline,
            'date' => $value->date,
            'reqlin' =>$value->reqlin,
        ];

        $collection = collect($data);
    return view('production.create', compact('data'));
    }

    //tampilan halaman performance 
    public function perform()
    {
    $data= Stower ::all();
    return view('production.perform', compact('data'));
    }

    public function grafik()
    {
    $data= Stower ::all();
    return view('production.grafik', compact('data'));
    }

    //query buat tampilan create

}
