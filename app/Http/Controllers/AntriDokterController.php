<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Antri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Dokter;
use App\Models\Persen;
use App\Models\Spesialis;
use App\Models\TopUp;
use Illuminate\Support\Facades\Redirect;

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
        $antri = Antri::where('dokter', Auth::user()->id)->with('waktu_detail')->orderBy('status')->orderBy('tgl')->orderBy('no_antrian')->get();



        // return $antri =  Dokter::with(['antri' => function ($q) {
        //     $q->orderBy('status', 'asc');
        //     // $q->orderBy('tgl');
        //     // $q->orderBy('no_antrian');
        // }])->with('antri.waktu_detail')->with('antri.pasien_detail')->where('id', Auth::user()->id)->first();
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

        $dokter = Dokter::where('username', Auth::user()->username)->first();
        $persen = Persen::first();
        // return ($persen['dokter'] / 100) * $persen['nilai'];
        Antri::where('id', $request->id_antri)
            ->update(["status" => 1, "catatan_dokter" => $request->catatan, "selesai_at" => date('Y-m-d H:i:s')]);

        //input potongan dokter
        TopUp::create([
            // "session_id" => $res['Data']['SessionID'],
            "trx_id" => '-',
            "dokter" => Auth::user()->id,
            "jumlah" => $persen['nilai'],
            "jumlah_admin" => $persen['nilai'] - (($persen['dokter'] / 100) * $persen['nilai']),
            "status" => 1,
            "jenis" => 0,
            "ket" => 'Menangani pasien',
            "pasien_id" => $request->id_antri
        ]);

        //bonus parent to saldo
        TopUp::create([
            // "session_id" => $res['Data']['SessionID'],
            "trx_id" => '-',
            "dokter" => $dokter['parent'],
            "jumlah" => ($persen['dokter'] / 100) * $persen['nilai'],
            "status" => 1,
            "jenis" => 1,
            "ket" => 'Bonus',
            "dari" => Auth::user()->username,
            "pasien_id" => $request->id_antri
        ]);

        //bonus parent to saldo
        // TopUp::create([
        //     // "session_id" => $res['Data']['SessionID'],
        //     "trx_id" => '-',
        //     "dokter" => Auth::user()->id,
        //     "jumlah" => $persen['nilai'] - (($persen['dokter'] / 100) * $persen['nilai']),
        //     "status" => 1,
        //     "jenis" => 2,
        //     "ket" => 'Menangani pasien',
        //     "pasien_id" => $request->id_antri
        // ]);
        return Redirect::to('/antri_dokter')->with('success', 'Selesai ditangani!');
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
        $pasien = Antri::where('dokter', Auth::user()->id)->where('status', 1)->count();
        $saldo = TopUp::where('dokter', Auth::user()->id)->where('status', 1)->sum('jumlah');

        if (($saldo - ($pasien * 2000)) < 2000) {
            return Redirect::to('/antri_dokter')->with('message', 'Saldo kurang, mohon segera Top Up!.');
        } else {
            $spesialis = Spesialis::all();
            $antri = Antri::with('waktu_detail')->where('dokter', Auth::user()->id)->where('id', $id)->first();
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
