<?php

namespace App\Http\Controllers;

use App\Models\Antri;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $days = [
            'Minggu',
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu'
        ];
        Session::put('tgl', date('d-m-Y'));
        Session::put('selectedTgl', date('Y-m-d'));
        Session::put('hari', $days[date('w')]);
        $semua =  Antri::where('tgl', date('Y-m-d'))->count();
        $terdaftar =  Antri::where('tgl', date('Y-m-d'))->count();
        $ditangani =  Antri::where('tgl', date('Y-m-d'))->where('status', 1)->count();
        $antri = Antri::where('tgl', date('Y-m-d'))->with('waktu_detail')->orderBy('status')->with('dokter_detail')->orderBy('tgl')->orderBy('no_antrian')->get();

        $data = [
            'category_name' => 'Laporan Pasien',
            'page_name' => 'Laporan Pasien',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'semua' => $semua,
            'terdaftar' => $terdaftar,
            'ditangani' => $ditangani,
            'data_antrian' => $antri
        ];
        return view('pages.laporan_pasien.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $days = [
            'Minggu',
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu'
        ];
        Session::put('tgl', date('d-m-Y', strtotime($request->dtgl)));
        Session::put('selectedTgl', date('Y-m-d', strtotime($request->dtgl)));
        Session::put('hari', $days[date('w', strtotime($request->dtgl))]);
        $semua =  Antri::where('tgl', date('Y-m-d', strtotime($request->dtgl)))->count();
        $terdaftar =  Antri::where('tgl', date('Y-m-d', strtotime($request->dtgl)))->count();
        $ditangani =  Antri::where('tgl', date('Y-m-d', strtotime($request->dtgl)))->where('status', 1)->count();
        $antri = Antri::with('waktu_detail')->orderBy('status')->with('dokter_detail')->where('tgl', date('Y-m-d', strtotime($request->dtgl)))->orderBy('tgl')->orderBy('no_antrian')->get();
        $data = [
            'category_name' => 'Laporan Pasien',
            'page_name' => 'Laporan Pasien',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'semua' => $semua,
            'terdaftar' => $terdaftar,
            'ditangani' => $ditangani,
            'data_antrian' => $antri
        ];
        return view('pages.laporan_pasien.index')->with($data);
        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
