<?php
Route::prefix('admin')->namespace('Admin')->group(function() {
    Route::group(['prefix'=>'role'], function(){
        Route::get('/role', 'RoleandBranchController@roleindex')->name('role.index');
        Route::get('rolecreate', 'RoleandBranchController@rolecreate')->name("role.create");
        Route::post('rolestore', 'RoleandBranchController@rolestore')->name("role.store");
        Route::get('roleedit/{id}', 'RoleandBranchController@roleedit')->name('role.edit');
        Route::post('roleupdate', 'RoleandBranchController@roleupdate')->name('role.update');
        Route::get('rolepdf', 'RoleandBranchController@rolepdf')->name('role.pdf');
        Route::get('roleexport-csv','RoleandBranchController@roleexcel')->name('role.excel');
    });
    Route::group(['prefix'=>'branch'], function(){
        Route::get('/branch', 'RoleandBranchController@branchindex')->name('branch.index');
        Route::get('branchcreate', 'RoleandBranchController@branchcreate')->name("branch.create");
        Route::post('branchstore', 'RoleandBranchController@branchstore')->name("branch.store");
        Route::get('branchedit/{id}', 'RoleandBranchController@branchedit')->name('branch.edit');
        Route::post('branchupdate', 'RoleandBranchController@branchupdate')->name('branch.update');
        Route::get('branchpdf', 'RoleandBranchController@branchpdf')->name('branch.pdf');
        Route::get('branchexport-csv','RoleandBranchController@branchexcel')->name('branch.excel');
    });

});