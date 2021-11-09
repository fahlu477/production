<?php
Route::prefix('auto')->namespace('Line')->group(function() {
    Route::group(['prefix'=>'input-auto'], function(){
        Route::post('fg/{id}', 'AutoController@fg')->name('auto.fg');
        Route::post('ip/{id}', 'AutoController@ip')->name('auto.ip');
        Route::post('sticker/{id}', 'AutoController@sticker')->name('auto.sticker');
        Route::post('meas/{id}', 'AutoController@meas')->name('auto.meas');
        Route::post('trimming/{id}', 'AutoController@trimming')->name('auto.trimming');
        Route::post('other/{id}', 'AutoController@other')->name('auto.other');
        Route::post('ros/{id}', 'AutoController@ros')->name('auto.ros');
        Route::post('broken/{id}', 'AutoController@broken')->name('auto.broken');
        Route::post('skip/{id}', 'AutoController@skip')->name('auto.skip');
        Route::post('pktw/{id}', 'AutoController@pktw')->name('auto.pktw');
        Route::post('crooked/{id}', 'AutoController@crooked')->name('auto.crooked');
        Route::post('pleated/{id}', 'AutoController@pleated')->name('auto.pleated');
        Route::post('htl/{id}', 'AutoController@htl')->name('auto.htl');
        Route::post('button/{id}', 'AutoController@button')->name('auto.button');
        Route::post('print/{id}', 'AutoController@print')->name('auto.print');
        Route::post('shading/{id}', 'AutoController@shading')->name('auto.shading');
        Route::post('dof/{id}', 'AutoController@dof')->name('auto.dof');
        Route::post('dirty/{id}', 'AutoController@dirty')->name('auto.dirty');
        Route::post('shiny/{id}', 'AutoController@shiny')->name('auto.shiny');
        Route::post('bs/{id}', 'AutoController@bs')->name('auto.bs');
        Route::post('unb/{id}', 'AutoController@unb')->name('auto.unb');
        Route::post('remark/{id}', 'AutoController@remark')->name('auto.remark');
        Route::post('file/{id}', 'AutoController@file')->name('auto.file');
        Route::post('hapus/file/{id}', 'AutoController@hapus')->name('hapus.file');
        Route::post('selesai', 'AutoController@selesai')->name('auto.selesai');
    });
});