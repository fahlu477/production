<?php
Route::prefix('line')->namespace('Line')->group(function() {
    Route::group(['prefix'=>'detail'], function(){
        Route::get('/', 'SPVController@index')->name("spv.index");
        Route::get('/finalreport/{id}', 'SPVController@final')->name("report.done");
        Route::post('/spv/approve','SPVController@approve')->name("spv.approve");
        Route::get('see/{id}','SPVController@see')->name("spv.see");
        Route::get('show/{id}','SPVController@show')->name("spv.show");
        Route::get('edit/{id}','SPVController@edit')->name("spv.edit");
        Route::post('/spv/update','SPVController@update')->name("spv.update");

    });
});