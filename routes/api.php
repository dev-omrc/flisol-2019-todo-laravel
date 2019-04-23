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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:api')->prefix('task')->name('task.')->group(function () {
    Route::get('/', 'TaskController@index')->name('index');
    Route::get('/{task}', 'TaskController@show')->name('show')->middleware('can:view,task');
    Route::post('/', 'TaskController@store')->name('store');
    Route::put('/{task}', 'TaskController@update')->name('update')->middleware('can:update,task');
    Route::delete('/{task}', 'TaskController@destroy')->name('delete')->middleware('can:delete,task');
});
