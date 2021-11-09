<?php

namespace App\Http\Controllers\Line;

use DB;
use PDF;
use Auth;
use DataTables;
use App\MasterLine;
use Illuminate\Http\Request;
use App\Exports\MasterLineExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class MasterLineController extends Controller
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
        $branch = auth()->user()->branch;
        $branch_detail = auth()->user()->branchdetail;

        $data = MasterLine::where('branch', $branch)
                ->where('branch_detail', $branch_detail)->get();
        // dd($data);
        if ($request->ajax()) {
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        return view('qc.rework.mline.atribut.btn_action', compact('row'));
                    })
                    ->editColumn('branch', function($row){
                        return view('qc.rework.mline.atribut.branch', compact('row'));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('qc/rework/mline/index');
    }

    public function create()
    {
    
        return view('qc/rework/mline/add');
    
    }

    public function store(Request $request)
    {
        if(
            MasterLine::where('string1', $request->string1)->where('string2', $request->string2)->count()
        ) throw new \Exception('Proses simpan ditolak. Data terdaftar');
    
        $input = [
            'string1' => strtoupper(auth()->user()->branchdetail.'-'.$request->string1),
            'string2' => strtoupper($request->string2),
            'branch' => $request->branch,
            'branch_detail' => $request->branch_detail
        ];


        $show = MasterLine::create($input);
        // dd($request);
        return redirect()->route('mline.index')->with('success', 'Master Line is successfully saved');
    }

    public function edit($id)
    {
        $data = MasterLine::findOrFail($id);
        //dd($data->id);

        return view('qc/rework/mline/edit', compact('data','id'));
 
    }
    public function update(Request $request)
    {
        $id = $request->id;
        // dd($id);
        $validatedData = [
            'string1' => strtoupper(auth()->user()->branchdetail.'-'.$request->string1),
            'string2' => strtoupper($request->string2),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        MasterLine::whereId($id)->update($validatedData);

	    return redirect()->route('mline.index')->with('success', 'Master Line Data is successfully updated');
    }
    public function excel(Request $request)
	{
        return Excel::download(new MasterLineExport, 'masterline.xlsx');
	}

    public function pdf()
    {
        $branch = Auth::user()->branch;
        $branch_detail = Auth::user()->branchdetail;
        $mline = MasterLine::where('branch', $branch)
                ->where('branch_detail', $branch_detail)->get();
 
    	$pdf = PDF::loadview('qc/rework/mline/masterline_pdf',['master_line'=>$mline]);
    	return $pdf->download('masterline.pdf');
    }
}
