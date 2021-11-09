<?php
Route::prefix('admin')->namespace('Admin')->group(function() {
    Route::group(['prefix'=>'karyawan'], function(){
        Route::get('/', 'KaryawanController@index')->name('karyawan.index');
        Route::get('masterwo', 'KaryawanController@masterwo')->name("masterwo.index");
        Route::get('wo/{id}', 'KaryawanController@woshow')->name("masterwo.show");
    });

});