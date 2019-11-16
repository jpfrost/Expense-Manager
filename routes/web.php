<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'MainController@index');

Route::post('/login','MainController@login');
Route::get('/getCurrentUser','MainController@getCurrentUser');
Route::get('/logout','MainController@logout');

Route::group(['middleware' => ['auth']],function(){

	Route::group(['prefix' => 'user'],function(){
		Route::get('all','MainController@getAllUsers');
		Route::post('save','MainController@saveAccount');
		Route::post('delete','MainController@deleteAccount');
		Route::post('/changePassword','MainController@changePassword');
	});

	Route::group(['prefix' => 'roles'],function(){
		Route::get('/getAll','MainController@getAllRoles');
		Route::post('/getRoleAccess','MainController@getRoleAccess');
		Route::post('save','MainController@saveRole');
		Route::post('delete','MainController@deleteRole');
	});

	Route::group(['prefix' => 'expenses'],function(){
		Route::get('/getAll','MainController@getAllExpenses');
		Route::post('save','MainController@saveExpense');
		Route::post('delete','MainController@deleteExpense');
	});

	Route::group(['prefix' => 'user-expenses'],function(){
		Route::get('/getAll','MainController@getAllUserExpenses');
		Route::post('save','MainController@saveUserExpense');
		Route::post('delete','MainController@deleteUserExpense');
	});

	Route::get('/graph','MainController@getGraphData');
});
