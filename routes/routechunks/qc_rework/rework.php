<?php

Route::group(['prefix'=>'rework'], function(){
    Route::get('/dashboarQC', 'ReworkController@qc')->name("qc.index");
    Route::get('/rework', 'ReworkController@index')->name("rework.index");
    Route::get('/master', 'ReworkController@master')->name("rework.master");
    Route::get('create', 'ReworkController@create')->name("rework.create");
    Route::get('take/{id}', 'ReworkController@take')->name('rework.take');
    Route::post('kerjakan/{id}','ReworkController@kerjakan')->name('rework.kerjakan');
    Route::post('pindah/{id}','ReworkController@pindah')->name('rework.pindah');
    Route::post('selesai/{id}','ReworkController@selesai')->name('rework.selesai');
    Route::get('lanjutkan/{id}','ReworkController@lanjutkan')->name('rework.lanjutkan');
    Route::get('manual/{id}','ReworkController@manual')->name('rework.manual');
    Route::get('auto/{id}','ReworkController@auto')->name('rework.auto');
    Route::post('lanjutkan/{id}','ReworkController@lanjutkan')->name('rework.lanjutkan');
    Route::get('show/{id}', 'ReworkController@show')->name("rework.show");
    Route::post('store', 'ReworkController@store')->name("rework.store");
    Route::get('edit/{id}', 'ReworkController@edit')->name('rework.edit');
    Route::put('update', 'ReworkController@update')->name('rework.update');
    Route::get('export-csv','ReworkController@exportCsvEndUser')->name('rework.export_csv_enduser');
});