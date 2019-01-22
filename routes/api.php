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

Route::get('tasks', 'Api\TasksController@index');
Route::post('/tasks', 'Api\TasksController@store');
Route::get('/tasks/{task}/download', 'Api\TasksController@download');