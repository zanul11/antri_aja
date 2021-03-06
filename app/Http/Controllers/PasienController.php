<?php

namespace App\Http\Controllers;

use App\Exports\LaporanPasien;
use App\Models\Antri;
use App\Models\Dokter;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

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
        Session::put('dtgl', date('d-m-Y'));
        Session::put('stgl', date('d-m-Y'));
        Session::put('dokter', 0);
        Session::put('selectedTgld', date('Y-m-d'));
        Session::put('selectedTgls', date('Y-m-d'));
        Session::put('hari', $days[date('w')]);
        $dokter = Dokter::whereIN('role', [5])->get();
        $semua =  Antri::where('tgl', date('Y-m-d'))->count();
        $terdaftar =  Antri::where('tgl', date('Y-m-d'))->count();
        $ditangani =  Antri::where('tgl', date('Y-m-d'))->where('status', 1)->count();
        $antri = Antri::where('tgl', date('Y-m-d'))->with('waktu_detail')->orderBy('status')->with('dokter_detail.faskes')->orderBy('tgl')->orderBy('no_antrian')->get();

        $data = [
            'category_name' => 'Laporan Pasien',
            'page_name' => 'Laporan Pasien',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'semua' => $semua,
            'terdaftar' => $terdaftar,
            'ditangani' => $ditangani,
            'data_antrian' => $antri,
            'dokter' => $dokter
        ];
        return view('pages.laporan_pasien.index')->with($data);
    }



    public function ExportPasien()
    {

        return Excel::download(new LaporanPasien(Session::get('dokter'), Session::get('selectedTgld'), Session::get('selectedTgls')), 'export_laporan_pasien.xlsx');
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

        $dokter = Dokter::whereIN('role', [3, 5])->get();

        Session::put('dtgl', date('d-m-Y', strtotime($request->dtgl)));
        Session::put('stgl', date('d-m-Y', strtotime($request->stgl)));
        Session::put('dokter', $request->dokter);
        Session::put('selectedTgld', date('Y-m-d', strtotime($request->dtgl)));
        Session::put('selectedTgls', date('Y-m-d', strtotime($request->stgl)));
        Session::put('hari', $days[date('w', strtotime($request->dtgl))]);

        if ($request->dokter == 0) {
            $semua =  Antri::whereBetween('tgl', [date('Y-m-d', strtotime($request->dtgl)), date('Y-m-d', strtotime($request->stgl))])->count();
            $terdaftar =  Antri::whereBetween('tgl', [date('Y-m-d', strtotime($request->dtgl)), date('Y-m-d', strtotime($request->stgl))])->count();
            $ditangani =  Antri::whereBetween('tgl', [date('Y-m-d', strtotime($request->dtgl)), date('Y-m-d', strtotime($request->stgl))])->where('status', 1)->count();
            $antri = Antri::with('waktu_detail')->orderBy('status')->with('dokter_detail.faskes')->whereBetween('tgl', [date('Y-m-d', strtotime($request->dtgl)), date('Y-m-d', strtotime($request->stgl))])->orderBy('tgl')->orderBy('no_antrian')->get();
        } else {
            $semua =  Antri::where('dokter', $request->dokter)->whereBetween('tgl', [date('Y-m-d', strtotime($request->dtgl)), date('Y-m-d', strtotime($request->stgl))])->count();
            $terdaftar =  Antri::where('dokter', $request->dokter)->whereBetween('tgl', [date('Y-m-d', strtotime($request->dtgl)), date('Y-m-d', strtotime($request->stgl))])->count();
            $ditangani =  Antri::where('dokter', $request->dokter)->whereBetween('tgl', [date('Y-m-d', strtotime($request->dtgl)), date('Y-m-d', strtotime($request->stgl))])->where('status', 1)->count();
            $antri = Antri::with('waktu_detail')->orderBy('status')->with('dokter_detail.faskes')->where('dokter', $request->dokter)->whereBetween('tgl', [date('Y-m-d', strtotime($request->dtgl)), date('Y-m-d', strtotime($request->stgl))])->orderBy('tgl')->orderBy('no_antrian')->get();
        }

        $data = [
            'category_name' => 'Laporan Pasien',
            'page_name' => 'Laporan Pasien',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'semua' => $semua,
            'terdaftar' => $terdaftar,
            'ditangani' => $ditangani,
            'data_antrian' => $antri,
            'dokter' => $dokter
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
