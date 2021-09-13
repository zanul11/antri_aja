<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Http\Controllers\Controller;
use App\Models\Antri;
use App\Models\Dokter;
use Illuminate\Http\Request;
use App\Models\Marketing;
use App\Models\Provinsi;
use App\Models\Spesialis;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;

class AkunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jaringan = User::with('childrenRekursif')->where('id', Auth::id())->firstOrFail();
        $akun = Akun::where('role', 5)->where('email', Auth::user()->email)->get();
        $data = [
            'category_name' => 'Data Akun Nakes',
            'page_name' => 'Data Akun Nakes',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'data_akun' => $akun,
            'action' => 'Tambah',
            'jaringan' => $jaringan
        ];
        return view('pages.akun.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $spesialis = Spesialis::all();
        $provinsi =  Provinsi::all();

        $data = [
            'category_name' => 'Data Akun Nakes',
            'page_name' => 'Tambah Data',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'action' => 'Tambah',
            'data_spesialis' => $spesialis,
            'data_provinsi' => $provinsi,

        ];
        // return config('sidemenu.administrator');
        return view('pages.akun.form')->with($data);
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
        $cek = Akun::where('username', $request->username)->get();
        if (count($cek) > 0) {
            return Redirect::to('/akun/create')->withErrors(['Duplicate Akun username!.'])->withInput()->with('message', 'Duplicate Akun username!.');
        } else {
            Akun::create([
                "name" => $request->nama,
                "username" => $request->username,
                "email" => Auth::user()->email,
                "password" => bcrypt($request->password),
                "no_hp" => $request->no_hp,
                "alamat" => $request->alamat,
                "parent" => Auth::user()->parent,
                "spesialis" => $request->spesialis,
                "pengalaman" => $request->pengalaman,
                "deskripsi" => $request->deskripsi,
                "role" => 5,

                "id_province" => $request->province,
                "id_city" => $request->kota,
                "id_subdistrict" => $request->kec,
            ]);
            return Redirect::to('/akun')->with('success', 'Data Akun Nakes added!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Akun  $akun
     * @return \Illuminate\Http\Response
     */
    public function show(Akun $akun)
    {
        $antri = Antri::where('dokter', $akun->id)->with(['waktu_detail'])->orderBy('tgl', 'desc')->orderBy('dJam')->orderBy('no_antrian')->orderBy('status')->get();
        $data = [
            'category_name' => 'Data Akun Nakes',
            'page_name' => 'Daftar Antrian',
            'has_scrollspy' => 0,
            'action' => 'Tambah',
            'scrollspy_offset' => '',
            'data_antri' => $antri,
            'akun' => $akun

        ];

        return view('pages.akun.antrian')->with($data);

        return $akun;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Akun  $akun
     * @return \Illuminate\Http\Response
     */
    public function edit(Akun $akun)
    {
        $spesialis = Spesialis::all();
        $provinsi =  Provinsi::all();
        $data = [
            'category_name' => 'Data Akun Nakes',
            'page_name' => 'Lihat Data',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'action' => 'Edit',
            'data_spesialis' => $spesialis,
            'akun' => $akun,
            'data_provinsi' => $provinsi
        ];
        // return config('sidemenu.administrator');
        return view('pages.akun.form')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Akun  $akun
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Akun $akun)
    {
        // return $request;
        if ($request->username != $akun->username) {
            $cekUser = User::where('username', $request->username)->get();
            if (count($cekUser) > 0) {
                return Redirect::to('/akun/' . $akun->id . '/edit')->withErrors(['Duplicate username!.'])->withInput()->with('message', 'Duplicate username!.');
            } else {
                if (isset($request->password) || $request->password != '')
                    $akun->password = bcrypt($request->password);
                $akun->username = $request->username;
                $akun->name = $request->nama;
                $akun->no_hp = $request->no_hp;
                $akun->pengalaman = $request->pengalaman;
                $akun->deskripsi = $request->deskripsi;
                $akun->alamat = $request->alamat;
                $akun->id_province = $request->province;
                $akun->id_city = $request->kota;
                $akun->id_subdistrict = $request->kec;
                $akun->save();
                return Redirect::to('/akun')->with('success', 'Data Akun updated!');
            }
        } else {
            if (isset($request->password) || $request->password != '')
                $akun->password = bcrypt($request->password);
            $akun->name = $request->nama;
            $akun->no_hp = $request->no_hp;
            $akun->pengalaman = $request->pengalaman;
            $akun->deskripsi = $request->deskripsi;
            $akun->alamat = $request->alamat;
            $akun->id_province = $request->province;
            $akun->id_city = $request->kota;
            $akun->id_subdistrict = $request->kec;
            $akun->save();
            return Redirect::to('/akun')->with('success', 'Data Akun updated!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Akun  $akun
     * @return \Illuminate\Http\Response
     */
    public function destroy(Akun $akun)
    {
        $akun->delete();
    }
}
