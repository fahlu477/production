<?php

Route::group(['prefix'=>'wo'], function(){
    Route::get('/', 'JdeApiController@index')->name("wo.index");
    Route::get('create', 'JdeApiController@create')->name("wo.add");
    Route::get('show/{id}', 'JdeApiController@show')->name("wo.show");
    Route::post('store', 'JdeApiController@store')->name("wo.store");
    Route::get('edit/{id}', 'JdeApiController@edit')->name('wo.edit');
    Route::get('delete/{id}', 'JdeApiController@delete')->name('wo.delete');
    Route::post('update', 'JdeApiController@update')->name('wo.update');
    Route::get('pdf', 'JdeApiController@pdf')->name('wo.pdf');
    Route::get('export-csv','JdeApiController@excel')->name('wo.excel');
    Route::get('export-detail','JdeApiController@detailexcel')->name('detail.excel');
});