<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(Request $request){
        $cred = [
            'nik' => $request->nik,
            'password' => $request->password,
            'isaktif' => '1',
            'role' => 'OWNER',
            'role' => 'SYS_ADMIN',
        ];

        $karyawan = [
            'nik' => $request->nik,
            'password' => $request->password,
            'isaktif' => '1',
        ];

        if(auth()->attempt($cred)){
            // update last login time
            DB::table('karyawan')->where('nik', $request->nik)->update(['lastlogin'=>date('Y-m-d H:i:s')]);
            
            // direct dashboard
            return redirect('/commandCenter');
        }
        if(auth()->attempt($karyawan)){
            // update last login time
            DB::table('karyawan')->where('nik', $request->nik)->update(['lastlogin'=>date('Y-m-d H:i:s')]);
            
            // direct dashboard
            return redirect('/home');
        }
        
        return back()->with([
            'msg' => 'NIK atau Password salah',
            'status' => 'danger'
        ]);
    }

    public function logout(){
        auth()->logout();

        return redirect('/login');
    }
}
