<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Marketing;
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
            'category_name' => 'Data Akun Dokter',
            'page_name' => 'Data Akun Dokter',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'data_akun' => $akun,
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
        $data = [
            'category_name' => 'Data Akun Dokter',
            'page_name' => 'Tambah Data',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'action' => 'Tambah',
            'data_spesialis' => $spesialis
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
            $tmp =  str_replace(']', '', str_replace('[', '', $request->latlong));
            $tmpLokasi = explode(",", $tmp);
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
                "latlong" => $request->latlong,
                "lat" => $tmpLokasi[0],
                "long" => $tmpLokasi[1],
            ]);
            return Redirect::to('/akun')->with('success', 'Data Akun Dokter added!');
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
        //
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
        $data = [
            'category_name' => 'Data Akun Dokter',
            'page_name' => 'Lihat Data',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'action' => 'Edit',
            'data_spesialis' => $spesialis,
            'akun' => $akun
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
        $tmp =  str_replace(']', '', str_replace('[', '', $request->latlong));
        $tmpLokasi = explode(",", $tmp);
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
                $akun->latlong = $request->latlong;
                $akun->lat =  $tmpLokasi[0];
                $akun->long = $tmpLokasi[1];
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
            $akun->latlong = $request->latlong;
            $akun->lat =  $tmpLokasi[0];
            $akun->long = $tmpLokasi[1];
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
