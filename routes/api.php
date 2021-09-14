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
Route::post('/searchFaskes', 'ApiController@searchFaskes');

Route::post('/getFaskesTernamaWilayah', 'ApiController@getFaskesTernamaWilayah');
Route::post('/getFaskesAllWilayah', 'ApiController@getFaskesAllWilayah');
Route::post('/searchFaskesWilayah', 'ApiController@searchFaskesWilayah');

Route::get('/getDokterTernamaWilayah', 'ApiController@getDokterTernamaWilayah');
Route::post('/searchDokterWilayah', 'ApiController@searchDokterWilayah');

Route::post('/getDokterFaskes', 'ApiController@getDokterFaskes');
Route::post('/searchDokterFaskes', 'ApiController@searchDokterFaskes');
Route::post('/getDokterSpesialisWilayah', 'ApiController@getDokterSpesialisWilayah');


Route::get('/broadcast', 'ApiController@broadcast');


Route::get('/get-provinsi', 'ApiController@getProvinsi');
Route::get('/cari-provinsi/{cari}', 'ApiController@cariProvinsi');
Route::get('/get-kota/{provinsi}', 'ApiController@getKota');
Route::get('/get-kec/{kota}', 'ApiController@getKec');

Route::post('/get-dokter-wilayah', 'ApiController@getDokterWilayah');
Route::post('/search-dokter-wilayah', 'ApiController@cariDokterWilayah');
