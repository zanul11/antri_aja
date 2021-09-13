<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Http\Controllers\Controller;
use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $jadwal = Jadwal::all();
        $data = [
            'category_name' => 'Jadwal Pelayanan',
            'page_name' => 'Jadwal Pelayanan',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'data_jadwal' => $jadwal
        ];
        return view('pages.jadwal.create')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'category_name' => 'Jadwal Pelayanan',
            'page_name' => 'Tambah Data',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];
        // return config('sidemenu.administrator');
        return view('pages.jadwal.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {
        // return 'tes';
        Jadwal::create([
            "id_user" => Auth::user()->id,
            "hari" => $request->value,
            "dJam" => $request->dJam,
            "sJam" => $request->sJam,
            "estimasi" => $request->estimasi,
            "kuota" => $request->kuota
        ]);
        return $request;
    }

    public function saveAkun(Request $request)
    {
        // return 'tes';
        Jadwal::create([
            "id_user" => $request->user_id,
            "hari" => $request->value,
            "dJam" => $request->dJam,
            "sJam" => $request->sJam,
            "estimasi" => $request->estimasi,
            "kuota" => $request->kuota
        ]);
        return $request;
    }

    public function delete(Request $request)
    {
        Jadwal::where('id_user', Auth::user()->id)->where('dJam', $request->dJam)->where('sJam', $request->sJam)->delete();
        return $request;
    }

    public function getData()
    {
        return Jadwal::where('id_user', Auth::user()->id)->get();
    }

    public function getJadwal()
    {
        $jadwal = [];
        for ($i = 0; $i < 7; $i++) {
            array_push($jadwal, (object) [
                'hari' => $i,
                'jadwals' => Jadwal::where('id_user', Auth::user()->id)->where('hari', $i)->orderBy('dJam')->get(),
            ]);
        }
        return $jadwal;
    }


    public function deleteAkun(Request $request)
    {
        Jadwal::where('id_user', $request->user_id)->where('dJam', $request->dJam)->where('sJam', $request->sJam)->delete();
        return $request;
    }

    public function getDataAkun(Request $request)
    {
        return Jadwal::where('id_user', $request->user_id)->get();
    }

    public function getJadwalAkun(Request $request)
    {
        $jadwal = [];
        for ($i = 0; $i < 7; $i++) {
            array_push($jadwal, (object) [
                'hari' => $i,
                'jadwals' => Jadwal::where('id_user', $request->user_id)->where('hari', $i)->orderBy('dJam')->get(),
            ]);
        }
        return $jadwal;
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jadwal  $jadwal
     * @return \Illuminate\Http\Response
     */
    public function show(Jadwal $jadwal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jadwal  $jadwal
     * @return \Illuminate\Http\Response
     */
    public function edit($jadwal)
    {
        $user = Akun::where('id', $jadwal)->first();
        $data = [
            'category_name' => 'Data Akun Nakes',
            'page_name' => 'Tambah Data',
            'has_scrollspy' => 0,
            'action' => 'Tambah',
            'scrollspy_offset' => '',
            'user' => $user
        ];
        // return config('sidemenu.administrator');
        return view('pages.jadwal.create_user')->with($data);
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jadwal  $jadwal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jadwal $jadwal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jadwal  $jadwal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jadwal $jadwal)
    {
        //
    }
}
