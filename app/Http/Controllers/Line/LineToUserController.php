<?php

namespace App\Http\Controllers\Line;

use DB;
use Auth;
use App\User;
use DataTables;
use App\LineToUser;
use App\MasterLine;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class LineToUserController extends Controller
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
    
    public function create($id)
    {
        $mline = Masterline::findOrFail($id);
        $line = Masterline::with('luser')->where('id', $id)->get();

        // untuk membatasi 2 orang tiap line 
        $person = LineToUser::where('id_line', $id)->get()->count();

        $member = User::where('role', 'QCR_OP')
                       ->where('branch', Auth::user()->branch)
                       ->where('branchdetail', Auth::user()->branchdetail)
                       ->get();

        $dataLuser = [];

        foreach ($line as $key => $value) {
            foreach ($value->luser as $key => $value1) {
                $dataLuser[] = [
                    $kode_line = $value->string1,
                    $id_line = $value->id,
                    'id' => $value1->id,
                    'line' => $value->string1,
                    'branch' => $value->branch,
                    'branch_detail' => $value->branch_detail,
                    'anggota' => $value1->id_user,
                    'created' => $value1->created_by,
                    'edited' => $value1->edited_by,
                ];
            }
        }

        return view('qc/rework/luser/add', compact('line', 'member', 'mline', 'dataLuser', 'person'));
    }

    public function store(Request $request, $id)
    {
        $input = $request->all();
        // dd($input);
        if(
            LineToUser::where('id_line', $request->id_line)->where('id_user', $request->id_user)->count()
        ) throw new \Exception('Proses simpan ditolak. Data terdaftar');

        LineToUser::create($input);
        $kerjakan = MasterLine::findOrFail($id);
       
        // return view('qc/rework/luser/berhasil', compact('kerjakan'));
        return back();
    }

    public function delete($id)
    {
        $luser = LineToUser::findOrFail($id);
        $luser->delete();
        
        return back();
    }

}
