<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\WOExport;
use Illuminate\Http\Request;
use DataTables;
use App\JdeApi;
use DB;

class JdeApiController extends Controller
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
        $wo = new JdeApi;
        $wo->setConnection('mysql2');
        $arr_wo = $wo->all();
        $dataWo = [];
        foreach ($arr_wo as $key => $value) {
            $dataWo[] = [
                'no_wo' => $value->F4801_DOCO,
                'second_item' => $value->F4801_AITM,
                'item_description' => $value->F4801_DL01,
                'order_quantity' => $value->F4801_UORG,
                'quantity_shipped' => $value->F4801_SOQS,
                'no_so' => $value->F4801_RORN,
            ];
        }

        if ($request->ajax()) {
            return Datatables::of($dataWo)
                ->addColumn('detail', function($row){
                    return view('qc.rework.wo.atribut.btn_detail', compact('row'));
                })
                ->make(true);
        }
      
        return view('qc/rework/wo/index');
    }

    public function show(Request $request, $id)
     {
        $data = JdeApi::Where('F4801_DOCO', $id)
        ->with('wobreakdown')
        ->get();
        $woBreakDown = [];

        foreach ($data as $key => $value) {
           foreach ($value->wobreakdown as $key => $value1) {
               $woBreakDown[] = [
                'no_wo' => $value1->F560020_DOCO,
                'country' => $value1->F560020_SEG3,
                'colour' => $value1->F560020_SEG4,
                'size' => $value1->F560020_SIZE55,
                'description' => $value1->F560020_DSC1,
               ];
           }
        }

        $finaldata = $woBreakDown;

        return view('qc/rework/wo/detail', compact('finaldata'));
     }

    public function excel(Request $request)
	{
        return Excel::download(new WOExport, 'wo.xlsx');
	}
}
