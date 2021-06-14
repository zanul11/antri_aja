<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Antri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Dokter;
use App\Models\Spesialis;

class AntriDokterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return $user_info = DB::table('antri')
        //     ->select('tgl', DB::raw('count(*) as total'))
        //     ->where('dokter', Auth::user()->id)
        //     ->where('status', 0)
        //     ->groupBy('tgl')
        //     ->get();
        $antri =  Dokter::with(['antri' => function ($q) {
            $q->orderBy('tgl');
            $q->orderBy('no_antrian');
        }])->with('antri.waktu_detail')->with('antri.pasien_detail')->where('id', Auth::user()->id)->first();
        // $spesialis = Spesialis::all();
        $data = [
            'category_name' => 'Daftar Antrian',
            'page_name' => 'Daftar Antrian',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'data_antri' => $antri,

        ];
        return view('pages.antri_dokter.index')->with($data);
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
        $spesialis = Spesialis::all();
        // return $antri =  Dokter::with(['antri' => function ($q) {
        //     $q->orderBy('tgl');
        //     $q->orderBy('no_antrian');
        // }])->with('antri.waktu_detail')->with('antri.pasien_detail')->where('id', Auth::user()->id)->first();

        $antri = Antri::with('waktu_detail')->with('pasien_detail')->where('dokter', Auth::user()->id)->where('id', $id)->first();

        $data = [
            'category_name' => 'Daftar Antrian',
            'page_name' => 'Pilih Waktu',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'antri' => $antri,
            'data_spesialis' => $spesialis,

        ];
        return view('pages.antri_dokter.detail')->with($data);
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
