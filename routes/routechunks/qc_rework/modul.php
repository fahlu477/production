<?php

Route::group(['prefix'=>'modul'], function(){
    Route::get('/', 'ModulController@index')->name("modul.index");
    Route::get('create', 'ModulController@create')->name("modul.add");
    Route::get('show/{id}', 'ModulController@show')->name("modul.show");
    Route::post('store', 'ModulController@store')->name("modul.store");
    Route::get('edit/{id}', 'ModulController@edit')->name('modul.edit');
    Route::get('delete/{id}', 'ModulController@delete')->name('modul.delete');
    Route::post('update', 'ModulController@update')->name('modul.update');
    Route::get('pdf', 'ModulController@pdf')->name('modul.pdf');
    Route::get('export-csv','ModulController@excel')->name('modul.excel');
});