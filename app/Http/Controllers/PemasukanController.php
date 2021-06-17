<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Antri;
use App\Models\Dokter;
use App\Models\TopUp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemasukanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pemasukan = TopUp::where('status', 1)->where('jenis', 0)->sum('jumlah');;
        $saldo = TopUp::where('status', 1)->where('jenis', 1)->sum('jumlah');
        $fee = TopUp::where('status', 1)->where('jenis', 1)->sum('fee');
        $dokter = Dokter::where('role', 3)->with(['saldo' => function ($q) {
            $q->where('status', 1);
            $q->where('jenis', 1);
        }])->with(['antri' => function ($q) {
            $q->where('status', 1);
        }])->get();
        $data = [
            'category_name' => 'Pemasukan',
            'page_name' => 'Pemasukan',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'pemasukan' => $pemasukan,
            'saldo' => $saldo,
            'fee' => $fee,
            'data_dokter' => $dokter

        ];
        return view('pages.pemasukan.index')->with($data);
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
        //
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
        $dokter = Dokter::where('id', $id)->with(['saldo' => function ($q) {
            $q->where('status', 1);
        }])->first();
        $pemasukan = TopUp::where('status', 1)->where('jenis', 0)->where('dokter', $dokter['email'])->sum('jumlah');;
        $saldo = TopUp::where('status', 1)->where('jenis', 1)->where('dokter', $dokter['email'])->sum('jumlah');
        $fee = TopUp::where('status', 1)->where('jenis', 1)->where('dokter', $dokter['email'])->sum('fee');
        $data = [
            'category_name' => 'Pemasukan',
            'page_name' => 'Pemasukan',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'pemasukan' => $pemasukan,
            'saldo' => $saldo,
            'fee' => $fee,
            'data_dokter' => $dokter

        ];
        return view('pages.pemasukan.detail_dokter')->with($data);
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
