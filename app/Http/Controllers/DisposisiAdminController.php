<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\TopUp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class DisposisiAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data_disposisi = TopUp::with('bonus_detail')->where('dokter', Auth::user()->id)->where('status', 1)->where('jenis', 0)->get();
        $data = [
            'category_name' => 'Disposisi Saldo',
            'page_name' => 'Disposisi Saldo',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'data_disposisi' => $data_disposisi

        ];
        return view('pages.disposisi.index')->with($data);
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
        // return $request;
        $tujuan = Dokter::where('id', $request->dokter)->first();

        //input potongan ke admin
        TopUp::create([
            // "session_id" => $res['Data']['SessionID'],
            "trx_id" => '-',
            "dokter" => Auth::user()->id,
            "jumlah" => $request->jumlah,
            "jumlah_admin" => 0,
            "status" => 1,
            "jenis" => 0,
            "ket" => 'Disposisi (Super Admin)',
            "pasien_id" => '-',
            "dari" => $tujuan->username,
        ]);

        //input disposisi ke faskes tujuan
        TopUp::create([
            // "session_id" => $res['Data']['SessionID'],
            "trx_id" => '-',
            "dokter" => $request->dokter,
            "jumlah" => $request->jumlah,
            "status" => 1,
            "jenis" => 1,
            "ket" => 'Disposisi',
            "dari" => "Super Admin",
            "pasien_id" => '-'
        ]);
        return Redirect::to('/disposisi-admin')->with('success', 'Berhasil Disposisi Saldo!');
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
