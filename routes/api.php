<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Route::group(['namespace'=>'App\Http\Controllers','prefix' => 'api','middleware'=>'cors'],function (){
//     Route::get('login','Controllers@Login');
// });

Route::group(['namespace'=>'App\Http\Controllers','prefix' => 'api',],function (){
    Route::post('login','LoginController@Login');

    Route::group(['middleware' => ['auth:api']], function () {
	    Route::get('logout','LoginController@logout');
	    Route::get('get_all_user','LoginController@get_all_user');
	    Route::get('get_all_user_by_id/{id}','LoginController@userlistagainstid');
	    Route::post('create_user','LoginController@create_user');
	    Route::get('delete_user_by_id/{id}','LoginController@deleteuser');
	    Route::post('update_user','LoginController@updateuser');
	    Route::get('search_user/{data}','LoginController@search_user');
	});

});
