<?php

namespace App\Http\Controllers;

use App\Branch;
use App\MasterLine;
use App\LineDetail;
use Illuminate\Http\Request;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // dd(auth()->user()->nama);
        return view('home');
    }

    public function commandCenter()
    {
        // untuk di command center 
        $branch = Branch::all();
        $dataSemua = 75.12;
        $dataQualityControl = 75;
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

        return view('commandCenter', compact('branch','dataSemua','dataQualityControl','dataProduction', 'dataExpedition',
         'dataMarketing','dataAccounting','dataPurchasing','dataWarehouse','dataHR',
         'dataDocument','dataInternalAudit','dataIT', 'dataDepartemen1','dataDepartemen2', 'dataDepartemen3', 'dataDepartemen4'));
    }
}
