<?php

use Illuminate\Http\Request;

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

Route::group([
	'prefix' => 'project',
	'middleware' => ['cors'],
	'name' => 'project.'
], function() {
	Route::post('/add', [
    	'as' => 'add',
    	'uses' => 'ProjectController@add'
    ]);
    Route::get('/index', [
    	'as' => 'index',
    	'uses' => 'ProjectController@index'
    ]);
    Route::put('/mark/{id}', [
    	'as' => 'mark',
    	'uses' => 'ProjectController@markAsCompleted'
    ]);
});

Route::group([
	'prefix' => 'task',
	'middleware' => ['cors'],
	'name' => 'task.'
], function() {
	Route::post('/add', [
    	'as' => 'add',
    	'uses' => 'TaskController@add'
    ]);
    Route::get('/getTasksByProject/{projectId}', [
    	'as' => 'index',
    	'uses' => 'TaskController@getTasksByProject'
    ]);
    Route::put('/mark/{id}', [
    	'as' => 'mark',
    	'uses' => 'TaskController@markAsCompleted'
    ]);
});
