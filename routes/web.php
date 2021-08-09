<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::group(['middleware' => 'auth'], function () {

    Route::group(['middleware' => 'admin'], function () {
        Route::resource('user', 'UserController');
        Route::resource('spesialis', 'SpesialisController');
        Route::resource('marketing', 'MarketingController');
        Route::resource('persen', 'PersenController');
        Route::resource('pemasukan', 'PemasukanController');
    });

    // $this->middleware

    Route::get('/dashboard', 'HomeController@index');
    Route::resource('profile', 'ProfileController');
    Route::resource('password', 'PasswordController');
    Route::resource('faskes', 'DokterController');
    Route::resource('akun', 'AkunController');

    Route::get('/jadwal/getJadwal', 'JadwalController@getJadwal');
    Route::get('/jadwal/getData', 'JadwalController@getData');
    Route::post('/jadwal/delete', 'JadwalController@delete');
    //akun-jadwal
    Route::post('/jadwal/getJadwalAkun', 'JadwalController@getJadwalAkun');
    Route::post('/jadwal/getDataAkun', 'JadwalController@getDataAkun');
    Route::post('/jadwal/deleteAkun', 'JadwalController@deleteAkun');
    Route::post('/jadwal/saveAkun', 'JadwalController@saveAkun');
    Route::resource('jadwal', 'JadwalController');

    Route::resource('antri_dokter', 'AntriDokterController');
    Route::resource('saldo/pembayaran', 'SaldoController@pembayaran');
    Route::resource('saldo', 'SaldoController');

    Route::resource('pesan', 'PesanController');
});

Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/sales', 'HomeController@index');

// Route::any('/ipaymu-success/{email}/{uid}', 'IpaymuResponseController@success');
Route::post('/ipaymu-success', 'IpaymuResponseController@success');
Route::any('/topup-success', 'IpaymuResponseController@successView');

Route::get('/antri/waktu/{antri}', 'AntriController@pilihJam');
Route::post('/antri/getJam', 'AntriController@getJam');
Route::post('/antri/getJum', 'AntriController@getJum');
Route::resource('antri', 'AntriController');

Route::resource('/daftar', 'RegisterController');

Route::get('/password/reset', function () {
    return redirect('/login');
});

Route::get('/', function () {
    return redirect('/daftar');
});
