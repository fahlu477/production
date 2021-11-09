<?php
Route::group(['prefix'=>'Command-Center'], function(){
    Route::get('cs/rework', 'CommandCenterController@rework')->name('cs.rework');
});