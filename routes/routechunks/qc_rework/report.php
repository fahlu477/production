<?php
Route::prefix('report')->namespace('Line')->group(function() {
    Route::group(['prefix'=>'qc-report'], function(){
        Route::get('rharian', 'QCReportController@rharian')->name('rharian.index');
        Route::post('harianget', 'QCReportController@harianGet')->name('harian.get');
        Route::post('harianpdf', 'QCReportController@harianPDF')->name('harian.pdf');
        Route::get('rbulanan', 'QCReportController@rbulanan')->name('rbulanan.index');
        Route::post('/rbulan/get','QCReportController@get')->name('rbulanan.get');
        Route::post('bulananpdf', 'QCReportController@bulananPDF')->name('bulanan.pdf');
        Route::get('rtahunan', 'QCReportController@rtahunan')->name('rtahunan.index');
        Route::post('/rtahunan/get','QCReportController@tahunget')->name('rtahunan.get');
        Route::post('tahunanpdf', 'QCReportController@tahunanPDF')->name('tahunan.pdf');
    });

    Route::group(['prefix'=>'report-all-fasilitas'], function(){
        Route::get('alltahunan', 'ReportAllFasilitasController@tahunan')->name('all.tahunan');
        Route::get('allharian', 'ReportAllFasilitasController@harian')->name('all.harian');
        Route::post('gettahunan', 'ReportAllFasilitasController@getTahunan')->name('get.AllTahunan');
        Route::post('getharian', 'ReportAllFasilitasController@getHarian')->name('get.AllHarian');
        Route::post('alltahunanpdf', 'ReportAllFasilitasController@AllTahunanPDF')->name('AllTahunan.pdf');
        Route::post('allharianpdf', 'ReportAllFasilitasController@AllHarianPDF')->name('AllHarian.pdf');
    });
});