<?php

namespace App\Http\Controllers;

use App\Models\Antri;
use App\Models\Dokter;
use App\Models\TopUp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class DisposisiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $kredit = TopUp::where('dokter', Auth::user()->id)->where('status', 1)->where('jenis', 0)->sum('jumlah');
        $saldo = TopUp::where('dokter', Auth::user()->id)->where('status', 1)->where('jenis', 1)->sum('jumlah');


        // return $saldo - $kredit;
        if (($saldo - $kredit) < $request->jumlah) {
            return Redirect::to('/saldo')->with('message', 'Saldo kurang, mohon segera Top Up!.');
        } else {
            $tujuan = Dokter::where('id', $request->dokter)->first();
            //input potongan dokter
            TopUp::create([
                // "session_id" => $res['Data']['SessionID'],
                "trx_id" => '-',
                "dokter" => Auth::user()->id,
                "jumlah" => $request->jumlah,
                "jumlah_admin" => 0,
                "status" => 1,
                "jenis" => 0,
                "ket" => 'Disposisi',
                "pasien_id" => '-',
                "dari" => $tujuan->username,
            ]);
            TopUp::create([
                // "session_id" => $res['Data']['SessionID'],
                "trx_id" => '-',
                "dokter" => $request->dokter,
                "jumlah" => $request->jumlah,
                "status" => 1,
                "jenis" => 1,
                "ket" => 'Disposisi',
                "dari" => Auth::user()->username,
                "pasien_id" => '-'
            ]);
            return Redirect::to('/saldo')->with('success', 'Berhasil Disposisi Saldo!');
        }
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
