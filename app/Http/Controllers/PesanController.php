<?php

namespace App\Http\Controllers;

use App\Models\Antri;
use App\Models\Dokter;
use App\Models\Pesan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class PesanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pesan = Pesan::where('dokter', Auth::user()->id)->first();
        $data = [
            'category_name' => 'Template Pesan',
            'page_name' => 'Template Pesan',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'data_pesan' => $pesan
        ];
        return view('pages.pesan.index')->with($data);
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
        $pesan = Pesan::where('dokter', Auth::user()->id)->delete();
        Pesan::create([
            "pesan" => $request->pesan,
            "dokter" => Auth::user()->id
        ]);
        return Redirect::to('/pesan')->with('success', 'Data Pesan updated!');
        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pesan  $pesan
     * @return \Illuminate\Http\Response
     */
    public function show(Pesan $pesan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pesan  $pesan
     * @return \Illuminate\Http\Response
     */
    public function edit(Pesan $pesan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pesan  $pesan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pesan $pesan)
    {
        // return $request;

    }
    public function addReminder(Request $request)
    {
        $data = Dokter::where('id', Auth::user()->id)->update([
            'pagi' => $request->pagi,
            'siang' => $request->siang,
            'sore' => $request->sore,
            'malam' => $request->malam,
        ]);
        return Redirect::to('/pesan')->with('success', 'Data Reminder updated!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pesan  $pesan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pesan $pesan)
    {
        //
    }
}
