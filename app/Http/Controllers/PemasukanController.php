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
        $pasien = Antri::where('status', 1)->count();
        $saldo = TopUp::where('status', 1)->sum('jumlah');
        $fee = TopUp::where('status', 1)->sum('fee');
        $dokter = Dokter::where('role', 3)->with(['saldo' => function ($q) {
            $q->where('status', 1);
        }])->with(['antri' => function ($q) {
            $q->where('status', 1);
        }])->get();
        $data = [
            'category_name' => 'Saldo',
            'page_name' => 'Saldo',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'pasien' => $pasien,
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
