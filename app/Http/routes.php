<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
return view('welcome');
});
Route::group( [ 'namespace' => 'Admin' ], function(){
    Route::resource( '{api?}/admin/students','StudentsController' );
    Route::resource( 'admin/students','StudentsController' );
    Route::post( 'students/multidestroy', 'StudentsController@multidestroy' );

    Route::resource( 'api/admin/customers','CustomersController' );
    Route::resource( 'admin/customers','CustomersController' );
    Route::post( 'customers/multidestroy', 'CustomersController@multidestroy' );
    Route::post( 'customers/changedisplay', 'CustomersController@changedisplay' );
    Route::get( 'customers/{id}/setdefault/', 'CustomersController@setdefault' );
    Route::get( 'customers/swapsort/{id1}/{id2}', 'CustomersController@swapsort' )->name( 'customers.swapsort' );
    Route::post( 'admin/customers/upload', 'CustomersController@upload' )->name('customers.upload');
    Route::get( 'customers/getstoreimage', 'CustomersController@storeImage' )->name( 'customers.getstoreimage' );
    Route::post( 'customers/clearimage', 'CustomersController@clearImage' )->name( 'customers.clearimage' );

} );

Route::get( 'clearsession', 'Admin\AdminPatternController@clearSession' );