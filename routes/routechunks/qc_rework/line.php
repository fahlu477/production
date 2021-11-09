<?php

Route::prefix('line')->namespace('Line')->group(function() {
        Route::get('/rework_index', 'ReworkController@index')->name('rework.index');
        Route::get('/rework_edit/{id}', 'ReworkController@edit')->name('rework.edit');
        Route::post('/rework_store', 'ReworkController@store')->name("rework.store");
        Route::get('/rework_export-csv','ReworkController@ExportCsvEndUser')->name('rework.export_csv');
        Route::get('/rework_export-pdf','ReworkController@RekapHariIni')->name('rework.rekap_hari_ini');

        Route::group(['prefix'=>'lines'], function(){
            Route::get('/', 'MasterLineController@index')->name("mline.index");
            Route::get('create', 'MasterLineController@create')->name("mline.create");
            Route::post('store', 'MasterLineController@store')->name("mline.store");
            Route::get('edit/{id}', 'MasterLineController@edit')->name('mline.edit');
            Route::post('update', 'MasterLineController@update')->name('mline.update');
            Route::get('pdf', 'MasterLineController@pdf')->name('mline.pdf');
            Route::get('export-csv','MasterLineController@excel')->name('mline.excel');
        });

        Route::group(['prefix'=>'luser'], function(){
            Route::get('/', 'LineToUserController@index')->name("luser.index");
            Route::get('create/{id}', 'LineToUserController@create')->name("luser.create");
            Route::get('show/{id}', 'LineToUserController@show')->name("luser.show");
            Route::post('store/{id}', 'LineToUserController@store')->name("luser.store");
            Route::get('delete/{id}','LineToUserController@delete')->name('luser.delete');
        });

        Route::group(['prefix'=>'ltarget'], function(){
            Route::get('/', 'LineToTargetController@index')->name("ltarget.index");
            Route::get('search/{id}', 'LineToTargetController@search')->name("ltarget.search");
            Route::get('tambah/{id}', 'LineToTargetController@tambah')->name("ltarget.tambah");
            Route::post('tambahHari/{id}', 'LineToTargetController@tambahHari')->name("ltarget.tambahHari");
            Route::post('searchwo', 'LineToTargetController@get')->name("ltarget.get");
            Route::get('show/{id}', 'LineToTargetController@show')->name("ltarget.show");
            Route::get('see/{id}', 'LineToTargetController@see')->name("ltarget.see");
            Route::get('summary/{id}', 'LineToTargetController@summary')->name("ltarget.summary");
            Route::get('summary/detail/{id}', 'LineToTargetController@summarydetail')->name("summary.detail");
            Route::post('store/{id}', 'LineToTargetController@store')->name("ltarget.store");
            Route::get('edit/{id}', 'LineToTargetController@edit')->name('ltarget.edit');
            Route::get('delete/{id}','LineToTargetController@delete')->name('ltarget.delete');
            Route::get('final', 'LineToTargetController@final')->name('ltarget.final');
            Route::post('update/{id}', 'LineToTargetController@update')->name('ltarget.update');
            Route::get('pdf', 'LineToTargetController@pdf')->name('ltarget.pdf');
            Route::get('export-csv','LineToTargetController@excel')->name('ltarget.excel');
        });
});