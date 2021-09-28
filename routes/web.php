<?php

use App\Http\Middleware\FaskesMiddleware;
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
    Route::get('/dashboard', 'HomeController@index');

    //SELECT2
    Route::get('select2/dokter', 'Select2Controller@dokter')->name('select2.dokter');
    Route::get('select2/getkota/{provinsi}', 'Select2Controller@getkota');
    Route::get('select2/getkec/{kota}', 'Select2Controller@getkec');
    Route::group(['middleware' => 'admin'], function () {
        Route::resource('user', 'UserController');
        Route::resource('spesialis', 'SpesialisController');
        Route::resource('marketing', 'MarketingController');
        Route::resource('persen', 'PersenController');
        Route::resource('pemasukan', 'PemasukanController');
        //PASIEN
        Route::resource('pasien', 'PasienController');

        //EXPORT
        Route::get('export-pasien', 'PasienController@ExportPasien');
        Route::get('export-marketing', 'MarketingController@ExportPasien');
        Route::get('export-faskes', 'FaskesController@ExportFaskes');
        Route::get('export-nakes/{id}', 'FaskesController@ExportNakes');

        Route::resource('data-faskes', 'FaskesController');
        Route::resource('data-akun', 'FaskesAkunController');

        Route::resource('broadcast', 'BroadcastController');
        Route::resource('disposisi-admin', 'DisposisiAdminController');
        Route::get('select2/getDataDisposisi', 'Select2Controller@getDataDisposisi')->name('select2.getdata');
    });

    // $this->middleware
    Route::middleware([FaskesMiddleware::class])->group(function () {
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
        Route::resource('disposisi', 'DisposisiController');
    });
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

Route::resource('/daftar', 'RegisterController', [
    'names' => [
        'index' => 'daftar'
    ]
]);

//chart
Route::get('/chart/getpiedate/{tgl}', 'HomeController@getpiedate');
Route::get('/chart/getcolumn/{tahun}', 'HomeController@getcolumn');

Route::get('/password/reset', function () {
    return redirect('/login');
});

// Route::get('/', function () {
//     return redirect('/');
// });
