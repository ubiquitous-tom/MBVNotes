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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Notes', 'prefix' => '/notes'], function () {

    Route::get('/', ['as' => 'notes', 'uses' => 'NoteController@index']);
    Route::put('/', ['as' => 'notes.store', 'uses' => 'NoteController@store']);
    Route::get('/{note}', ['as' => 'notes.show', 'uses' => 'NoteController@show']);
    Route::post('/{note}', ['as' => 'notes.update', 'uses' => 'NoteController@update']);
    Route::delete('/{note}', ['as' => 'notes', 'uses' => 'NoteController@destroy']);

});
