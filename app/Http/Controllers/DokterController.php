<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Http\Controllers\Controller;
use App\Models\Spesialis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;

class DokterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jaringan = User::with('childrenRekursif')->where('id', Auth::id())->firstOrFail();
        $dokter = Dokter::where('role', 3)->where('parent', Auth::user()->id)->get();
        $data = [
            'category_name' => 'Data Dokter',
            'page_name' => 'Data Dokter',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'data_dokter' => $dokter,
            'jaringan' => $jaringan
        ];
        return view('pages.dokter.index')->with($data);
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
            'category_name' => 'Data Dokter',
            'page_name' => 'Tambah Data',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'action' => 'Tambah',
            'data_spesialis' => $spesialis
        ];
        // return config('sidemenu.administrator');
        return view('pages.dokter.form')->with($data);
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
        $cek = Dokter::where('email', $request->email)->orWhere('nik', $request->nik)->get();
        if (count($cek) > 0) {
            return Redirect::to('/dokter/create')->withErrors(['Duplicate Dokter email/nik!.'])->withInput()->with('message', 'Duplicate Dokter email/nik!.');
        } else {
            $tmp =  str_replace(']', '', str_replace('[', '', $request->latlong));
            $tmpLokasi = explode(",", $tmp);
            Dokter::create([
                "name" => $request->nama,
                "email" => $request->email,
                "password" => bcrypt($request->password),
                "nik" => $request->nik,
                "no_hp" => $request->no_hp,
                "alamat" => $request->alamat,
                "parent" => Auth::user()->id,
                "spesialis" => $request->spesialis,
                "pengalaman" => $request->pengalaman,
                "deskripsi" => $request->deskripsi,
                "role" => 3,
                "latlong" => $request->latlong,
                "lat" => $tmpLokasi[0],
                "long" => $tmpLokasi[1],
            ]);
            return Redirect::to('/dokter')->with('success', 'Data Dokter added!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dokter  $dokter
     * @return \Illuminate\Http\Response
     */
    public function show(Dokter $dokter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dokter  $dokter
     * @return \Illuminate\Http\Response
     */
    public function edit(Dokter $dokter)
    {
        $spesialis = Spesialis::all();
        $data = [
            'category_name' => 'Data Dokter',
            'page_name' => 'Tambah Data',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'action' => 'Edit',
            'data_spesialis' => $spesialis,
            'dokter' => $dokter
        ];
        // return config('sidemenu.administrator');
        return view('pages.dokter.form')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dokter  $dokter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dokter $dokter)
    {
        // return $request;
        if ($request->email != $dokter->email && $request->nik != $dokter->nik) {
            $cek = Marketing::where('email', $request->email)->orWhere('nik', $request->nik)->get();
            if (count($cek) > 0) {
                return Redirect::to('/dokter/' . $dokter->id . '/edit')->withErrors(['Duplicate dokter email/nik!.'])->withInput()->with('message', 'Duplicate dokter email/nik!.');
            } else {
                if (isset($request->password) || $request->password != '')
                    $dokter->password = bcrypt($request->password);
                $dokter->email = $request->email;
                $dokter->name = $request->nama;
                $dokter->nik = $request->nik;
                $dokter->no_hp = $request->no_hp;
                $dokter->alamat = $request->alamat;
                $dokter->spesialis = $request->spesialis;
                $dokter->pengalaman = $request->pengalaman;
                $dokter->deskripsi = $request->deskripsi;

                if (isset($request->latlong)) {
                    $dokter->latlong = $request->latlong;
                    $tmp =  str_replace(']', '', str_replace('[', '', $request->latlong));
                    $tmpLokasi = explode(",", $tmp);
                    $dokter->lat = $tmpLokasi[0];
                    $dokter->long = $tmpLokasi[1];
                }
                $dokter->save();
                return Redirect::to('/dokter')->with('success', 'Data Dokter updated!');
            }
        } else {
            if (isset($request->password) || $request->password != '')
                $dokter->password = bcrypt($request->password);
            $dokter->email = $request->email;
            $dokter->name = $request->nama;
            $dokter->nik = $request->nik;
            $dokter->no_hp = $request->no_hp;
            $dokter->alamat = $request->alamat;
            $dokter->spesialis = $request->spesialis;
            $dokter->pengalaman = $request->pengalaman;
            $dokter->deskripsi = $request->deskripsi;

            if (isset($request->latlong)) {
                $dokter->latlong = $request->latlong;
                $tmp =  str_replace(']', '', str_replace('[', '', $request->latlong));
                $tmpLokasi = explode(",", $tmp);
                $dokter->lat = $tmpLokasi[0];
                $dokter->long = $tmpLokasi[1];
            }
            $dokter->save();
            return Redirect::to('/dokter')->with('success', 'Data Dokter updated!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dokter  $dokter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dokter $dokter)
    {
        //
    }
}
