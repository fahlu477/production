<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


// Authenticate
Route::view('login', 'login')->name('login_form')->middleware('guest');
Route::post('login','AuthController@login')->name('login')->middleware('guest');
Route::get('logout', 'AuthController@logout')->name('logout');
Route::get('/home', 'HomeController@index')->name('home');
// CommanCenter 
Route::get('/commandCenter', 'HomeController@commandCenter')->name('commandCenter');
Route::get('/commandCenter/allfactory_qc', 'CCAllBranchController@allfac')->name('allfac.qc');
Route::get('/commandCenter/qc', 'CCAllBranchController@qc')->name('allcc.qc');
Route::get('/commandCenter/qc/rework', 'CCAllBranchController@rework')->name('allcc.rework');
Route::get('/commandCenter/qc/rework/lines/{id}', 'CCAllBranchController@lines')->name('allcc.lines');
Route::get('/cc/level2/{id}', 'CommandCenterController@level2')->name('cc.level2');
Route::get('/cc/qc/{id}','CommandCenterController@qc')->name("cc.qc");
Route::get('/cc/qc/rework/{id}', 'CCQualityController@rework')->name('cc.rework');
Route::get('/cc/qc/rework/lines/{id}', 'CCQualityController@lines')->name('cc.lines');
// end CommanCenter 

Route::prefix('CommandCenterAll')->namespace('CommandCenter')->group(function() {
    Route::group(['prefix'=>'gistex-commandcenter'], function(){
        Route::get('/CLNCC', 'CLNCCController@commandCenter')->name('CLN.CommandCenter');
        Route::get('/GM1CC', 'GM1CCController@commandCenter')->name('GM1.CommandCenter');
        Route::get('/GM2CC', 'GM2CCController@commandCenter')->name('GM2.CommandCenter');
    });
});

//Definisikan route disini untuk melakukan request menggunakan javascript
// Route::get('production/grafik/getData', 'ProductionController@getAvgTotalResponseTime')->name('production.grafik.getData');

// SYS_ADMIN
Route::get('/admin', 'AdminController@index')->name('admin.index');
include "routechunks/admin/karyawan.php";
include "routechunks/admin/rolebranch.php";

// QC Rework 
// 1. Line
include "routechunks/qc_rework/line.php";
// 2. Modul
include "routechunks/qc_rework/modul.php";
// 3. Rework
include "routechunks/qc_rework/rework.php";
// 4. Wo
include "routechunks/qc_rework/wo.php";
// 5. DetailTarget
include "routechunks/qc_rework/detail.php";
// 6. InputAuto
include "routechunks/qc_rework/auto.php";
// 7. QC Report
include "routechunks/qc_rework/report.php";
// 8. SPV
include "routechunks/qc_rework/spv.php";
// 9. Command Center
include "routechunks/cs.php";
// End 

// ggi indah
// 1. indah
include "routechunks/ggi_indah/indah.php";


//production
include "routechunks/production/production.php";