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

Route::get('/page/list', 'API\PageController@getList');
Route::post('/page/create', 'API\PageController@create');
Route::post('/page/update', 'API\PageController@update');
Route::post('/page/delete', 'API\PageController@delete');
