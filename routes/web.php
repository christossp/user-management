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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tasks', function(){
	
	$tasks = App\Task::all();
	
	return view('tasks.index', compact('tasks'));
});

Route::get('/tasks/{task}', function($id){
	
	$task = App\Task::find($id);
	
	return view('tasks.show', compact('task'));
});


Route::get('/createuser', function () {
    return view('users.create');
});


Route::get('/createaccount', 'AccountsController@create');

Route::post('/createaccount', 'AccountsController@store');

Route::get('/accounts', 'AccountsController@index');

Route::get('/editaccount/{account}','AccountsController@editshow');

Route::post('/editaccount/{account}', 'AccountsController@edit');

Route::get('/destroyaccount/{account}', 'AccountsController@destroy');

Route::get('/media', 'MediaController@index');

Route::post('/fileUpload', 'MediaController@upload');

Route::get('/test/{folder1}', 'MediaController@getFiles');

Route::post('/openfolder', 'MediaController@getFiles');

Route::post('/deletemedia', 'MediaController@destroy');

Route::post('/renamemedia', 'MediaController@edit');

Route::post('/createdir', 'MediaController@createDir');

Route::post('/breadclicked', 'MediaController@getFilesByDirPath');


//AD
Route::get('/adimport', 'AccountsController@adfetch');

//Route::post('/adimport', 'AccountsController@adfetchAjax');

Route::post('/adimport', 'AccountsController@getLdapUsers');

Route::post('/importselectedusers', 'AccountsController@storeAdUsers');


