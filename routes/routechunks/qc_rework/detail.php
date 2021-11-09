<?php
Route::prefix('line')->namespace('Line')->group(function() {
    Route::group(['prefix'=>'detail'], function(){
        Route::get('/', 'LineDetailController@index')->name("detail.index");
        Route::get('manual/{id}', 'LineDetailController@manual')->name("detail.manual");
        Route::post('manualstore/{id}', 'LineDetailController@manualstore')->name("detail.manualstore");
        Route::get('auto/{id}', 'LineDetailController@auto')->name("detail.auto");
        Route::get('create', 'LineDetailController@create')->name("detail.add");
        Route::get('DetaiShow/{id}', 'LineDetailController@show')->name("detail.show");
        Route::post('store', 'LineDetailController@store')->name("detail.store");
        Route::get('detail/edit/{id}', 'LineDetailController@edit')->name('details.edit');
        Route::get('delete/{id}', 'LineDetailController@delete')->name('detail.delete');
        Route::post('detail/update', 'LineDetailController@update')->name('details.update');
        Route::get('pdf', 'LineDetailController@pdf')->name('detail.pdf');
        Route::get('export-csv','LineDetailController@excel')->name('detail.excel');
    });
});