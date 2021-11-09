<?php
Route::prefix('ggi_indah')->namespace('ggi_indah')->group(function() {
    Route::group(['prefix'=>'indah'], function(){
        Route::get('/dashboarindah', 'IndahController@indah')->name("indah.index");
       // Route::get('/Kvote', 'IndahController@karyawanV')->name("karyawan.pilih");
       // Route::get('vote/{nik}', 'IndahController@vote')->name('karyawan.vote');
       // Route::get('/create', 'IndahController@create')->name("indah.create");
        Route::post('/store', 'IndahController@store')->name("vote.store");
        Route::get('/countvote', 'IndahController@countvote')->name("indah.countvote");
        
        Route::get('/cari', 'IndahController@cari')->name("indah.cari");
        Route::post('/vote', 'IndahController@vote')->name("indah.vote");
});
    Route::group(['prefix'=>'petugas'], function(){
        Route::get('/see', 'IpetugasController@petugas')->name("Pindah.index");
        Route::get('/create', 'IpetugasController@create')->name("satgas.create");
        Route::post('/store', 'IpetugasController@store')->name("satgas.store");
        Route::get('edit/{id}', 'IpetugasController@edit')->name('satgas.edit');
        Route::post('/update', 'IpetugasController@update')->name("satgas.update");
        Route::get('delete/{id}', 'IpetugasController@delete')->name('satgas.delete');
    
    });
    Route::group(['prefix'=>'jpiket'], function(){
        Route::get('/see', 'IjadwalController@jadwal')->name("Jindah.index");
        //Route::get('/create', 'IpetugasController@create')->name("satgas.create");
        //Route::post('/store', 'IpetugasController@store')->name("satgas.store");
        Route::get('edit/{id}', 'IjadwalController@edit')->name('piket.edit');
        Route::post('/update', 'IjadwalController@update')->name("piket.update");
    });

    Route::group(['prefix'=>'report'], function(){
        Route::get('/report', 'IreportController@index')->name("indah.report");
        Route::post('harianget', 'IreportController@getharian')->name('indah.harian');
        Route::post('mingguanget', 'IreportController@getmingguan')->name('indah.mingguan');
        Route::post('bulananget', 'IreportController@getbulanan')->name('indah.bulanan');
        Route::post('tahunanget', 'IreportController@gettahunan')->name('indah.tahunan');
        Route::Post('detailhari', 'IreportController@haridetail')->name('indah.Hdetail');
        Route::Post('detailminggu', 'IreportController@minggudetail')->name('indah.Mdetail');
        Route::Post('detailbulan', 'IreportController@bulandetail')->name('indah.Bdetail');
        Route::Post('detailtahun', 'IreportController@tahundetail')->name('indah.Tdetail');
       // Route::get('/reportdetai', 'IreportController@reportdetail')->name("indah.reportdtail");
       // Route::get('/see', 'IjadwalController@jadwal')->name("Jindah.index");
        //Route::get('/create', 'IpetugasController@create')->name("satgas.create");
        //Route::post('/store', 'IpetugasController@store')->name("satgas.store");
       // Route::get('edit/{id}', 'IjadwalController@edit')->name('piket.edit');
       // Route::post('/update', 'IjadwalController@update')->name("piket.update");
    });

});