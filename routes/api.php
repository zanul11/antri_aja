<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/login', 'ApiController@login');
Route::post('/getAntriUser', 'ApiController@getAntriUser');
Route::post('/getAntriUserDitangani', 'ApiController@getAntriUserDitangani');
Route::get('/getSpesialis', 'ApiController@getSpesialis');
Route::post('/getDokterSpesialis', 'ApiController@getDokterSpesialis');
Route::post('/getJam', 'ApiController@getJam');
Route::post('/getJumAntrian', 'ApiController@getJumAntrian');
Route::post('/saveAntrian', 'ApiController@saveAntrian');
Route::post('/deleteAntrian', 'ApiController@deleteAntrian');
Route::post('/detailAntrian', 'ApiController@detailAntrian');
Route::get('/getDokterTernama', 'ApiController@getDokterTernama');
Route::get('/getSpesialisTernama', 'ApiController@getSpesialisTernama');
Route::post('/searchDokter', 'ApiController@searchDokter');
Route::post('/searchSpesialis', 'ApiController@searchSpesialis');


Route::get('/getFaskesTernama', 'ApiController@getFaskesTernama');
Route::get('/getFaskesAll', 'ApiController@getFaskesAll');
Route::post('/getDokterFaskes', 'ApiController@getDokterFaskes');
Route::post('/searchDokterFaskes', 'ApiController@searchDokterFaskes');
