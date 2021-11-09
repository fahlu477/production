<?php
use Illuminate\Support\Facades\Route;

Route::prefix('production')->namespace('production')->group(function() {
    Route::get('/dashboardProduction', 'ProductionController@produk')->name("production.index");
    Route::get('/andon', 'ProductionController@andon')->name("production.andon");
    Route::get('/SignalTowerProduction', 'ProductionController@reporttower')->name("production.reporttower"); 
    Route::get('/perform', 'ProductionController@perform')->name("production.perform");
    Route::get('/grafik', 'ProductionController@grafik')->name("production.grafik");
    // Route::get('production/grafik/getData', 'ProductionController@getAvgTotalResponseTime');
    Route::get('/grafik/getData', 'ProductionController@getAvgTotalResponseTime')->name('production.grafik.getData');
}); 