<?php

namespace App\Http\Controllers;

use App\Models\Antri;
use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Jadwal;
use App\Models\Spesialis;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AntriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $antri = Antri::with('dokter_detail')->with('waktu_detail')->where('user_id', Session::get('id'))->get();
        // $spesialis = Spesialis::all();
        $data = [
            'category_name' => 'Daftar Antrian',
            'page_name' => 'Daftar Antrian',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'data_antri' => $antri,
        ];
        return view('pages.antri.index')->with($data);
    }

    public function pilihSpesialis()
    {
        // return User::with('antri')->with('antri.dokter_detail')->where('id', Auth::user()->id)->first();

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $spesialis = Spesialis::all();
        $data = [
            'category_name' => 'Daftar Antrian',
            'page_name' => 'Daftar Antrian',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'spesialis' => $spesialis,

        ];
        return view('pages.antri.list_spesialis')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $jum = Antri::where('dokter', $request->dokter)->whereDate('tgl', $request->tgl)->where('waktu', $request->jam['id'])->count();
        Antri::create([
            'no_antrian' => $jum + 1,
            'user_id' => Session::get('id'),
            'pasien' => $request->pasien,
            'umur' => $request->umur,
            'tgl' => $request->tgl,
            'dokter' => $request->dokter,
            'waktu' => $request->jam['id'],
            'dJam' => $request->jam['dJam'],
            'sJam' => $request->jam['sJam'],
            'catatan' => $request->catatan,
            'no_hp' => Session::get('no_hp'),
            'user_name' => Session::get('user')
        ]);
        // return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Antri  $antri
     * @return \Illuminate\Http\Response
     */
    public function show($antri)
    {

        $dokter = Dokter::with(['jadwal' => function ($q) {
            // $q->orderBy('hari');
            // $q->orderBy('dJam');
            $q->groupBy('hari');
        }])->where('spesialis', $antri)->get();
        // return $dokter;
        $spesialis = Spesialis::where('id', $antri)->first();
        $data = [
            'category_name' => 'Daftar Antrian',
            'page_name' => 'Daftar Antrian',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'dokter' => $dokter,
            'spesialis' => $spesialis,
        ];
        return view('pages.antri.list_dokter')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Antri  $antri
     * @return \Illuminate\Http\Response
     */
    public function edit(Antri $antri)
    {
        $spesialis = Spesialis::all();

        $data = [
            'category_name' => 'Daftar Antrian',
            'page_name' => 'Pilih Waktu',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'antri' => $antri,
            'data_spesialis' => $spesialis,

        ];
        return view('pages.antri.detail')->with($data);
        return $antri;
    }

    public function pilihJam($id)
    {
        $spesialis = Spesialis::all();
        $dokter = Dokter::with(['jadwal' => function ($q) {
            $q->orderBy('hari');
            $q->orderBy('dJam');
        }])->with('spesialis_detail')->where('id', $id)->first();
        $data = [
            'category_name' => 'Daftar Antrian',
            'page_name' => 'Pilih Waktu',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'dokter' => $dokter,
            'data_spesialis' => $spesialis
        ];
        return view('pages.antri.list_jam')->with($data);

        return $id;
    }

    public function getJam(Request $request)
    {
        // $dokter = Dokter::with(['jadwal' => function ($q) use ($request) {
        //     $q->orderBy('hari');
        //     $q->orderBy('dJam');
        //     $q->where('hari', $request->hari);
        // }])->where('id', $request->dokter)->first();
        $jam = Jadwal::where('hari', $request->hari)->where('id_user', $request->dokter)->orderBy('hari')->orderBy('dJam')->get();
        return $jam;
    }

    public function getJum(Request $request)
    {
        $jum = Antri::where('dokter', $request->dokter)->whereDate('tgl', $request->tgl)->where('waktu', $request->jam)->count();
        return $jum;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Antri  $antri
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Antri $antri)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Antri  $antri
     * @return \Illuminate\Http\Response
     */
    public function destroy(Antri $antri)
    {
        $antri->delete();
    }
}
