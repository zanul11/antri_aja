<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Http\Controllers\Controller;
use App\Models\Marketing;
use App\Models\Provinsi;
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
            'category_name' => (Auth::user()->role == 2) ? 'Data Faskes' : 'Data Mitra',
            'page_name' => (Auth::user()->role == 2) ? 'Data Faskes' : 'Data Mitra',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'action' => 'Tambah',
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
        $provinsi =  Provinsi::all();

        $data = [
            'category_name' => (Auth::user()->role == 2) ? 'Data Faskes' : 'Data Mitra',
            'page_name' => 'Tambah Data',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'action' => 'Tambah',
            'data_spesialis' => $spesialis,
            'data_provinsi' => $provinsi,

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
        $cek = Dokter::where('email', $request->email)->get();
        if (count($cek) > 0) {
            return Redirect::to('/faskes/create')->withErrors(['Duplicate Faskes email/username!.'])->withInput()->with('message', 'Duplicate Faskes email/username!.');
        } else {
            // $tmp =  str_replace(']', '', str_replace('[', '', $request->latlong));
            // $tmpLokasi = explode(",", $tmp);
            Dokter::create([
                "name" => $request->nama,
                "email" => $request->email,
                "username" => $request->email,
                "password" => bcrypt($request->password),
                "no_hp" => $request->no_hp,
                "alamat" => $request->alamat,
                "parent" => Auth::user()->id,
                "spesialis" => $request->spesialis,
                "pengalaman" => $request->pengalaman,
                "deskripsi" => $request->deskripsi,
                "role" => 3,
                // "latlong" => $request->latlong,
                "nama_faskes" => $request->nama_faskes,
                "kode_faskes" => $request->kode_faskes,
                "tlp_faskes" => $request->tlp_faskes,
                "id_province" => $request->province,
                "id_city" => $request->kota,
                "id_subdistrict" => $request->kec,
                // "lat" => $tmpLokasi[0],
                // "long" => $tmpLokasi[1],
            ]);
            return Redirect::to('/faskes')->with('success', 'Data Faskes added!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dokter  $dokter
     * @return \Illuminate\Http\Response
     */
    public function show(Dokter $faske)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dokter  $dokter
     * @return \Illuminate\Http\Response
     */
    public function edit(Dokter $faske)
    {
        // return $faske;
        $provinsi =  Provinsi::all();
        $spesialis = Spesialis::all();
        $data = [
            'category_name' => (Auth::user()->role == 2) ? 'Data Faskes' : 'Data Mitra',
            'page_name' => 'Lihat Data',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'action' => 'Edit',
            'data_spesialis' => $spesialis,
            'dokter' => $faske,
            'data_provinsi' => $provinsi
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
    public function update(Request $request, Dokter $faske)
    {
        // return $request;
        if ($request->email != $faske->email) {
            $cek = Dokter::where('email', $request->email)->get();
            if (count($cek) > 0) {
                return Redirect::to('/faskes/' . $faske->id . '/edit')->withErrors(['Duplicate Faskes email/username!.'])->withInput()->with('message', 'Duplicate Faskes email/username!.');
            } else {
                if (isset($request->password) || $request->password != '')
                    $faske->password = bcrypt($request->password);
                $faske->email = $request->email;
                $faske->name = $request->nama;
                $faske->username = $request->email;
                $faske->no_hp = $request->no_hp;
                $faske->alamat = $request->alamat;
                $faske->spesialis = $request->spesialis;
                $faske->pengalaman = $request->pengalaman;
                $faske->deskripsi = $request->deskripsi;
                $faske->kode_faskes = $request->kode_faskes;
                $faske->nama_faskes = $request->nama_faskes;
                $faske->tlp_faskes = $request->tlp_faskes;
                $faske->id_province = $request->province;
                $faske->id_city = $request->kota;
                $faske->id_subdistrict = $request->kec;
                // if (isset($request->latlong)) {
                //     $faske->latlong = $request->latlong;
                //     $tmp =  str_replace(']', '', str_replace('[', '', $request->latlong));
                //     $tmpLokasi = explode(",", $tmp);
                //     $faske->lat = $tmpLokasi[0];
                //     $faske->long = $tmpLokasi[1];
                // }
                $faske->save();
                return Redirect::to('/faskes')->with('success', 'Data Faskes updated!');
            }
        } else {
            if (isset($request->password) || $request->password != '')
                $faske->password = bcrypt($request->password);
            $faske->email = $request->email;
            $faske->name = $request->nama;
            $faske->username = $request->email;
            $faske->no_hp = $request->no_hp;
            $faske->alamat = $request->alamat;
            $faske->spesialis = $request->spesialis;
            $faske->pengalaman = $request->pengalaman;
            $faske->deskripsi = $request->deskripsi;
            $faske->kode_faskes = $request->kode_faskes;
            $faske->nama_faskes = $request->nama_faskes;
            $faske->tlp_faskes = $request->tlp_faskes;
            $faske->id_province = $request->province;
            $faske->id_city = $request->kota;
            $faske->id_subdistrict = $request->kec;

            // if (isset($request->latlong)) {
            //     $faske->latlong = $request->latlong;
            //     $tmp =  str_replace(']', '', str_replace('[', '', $request->latlong));
            //     $tmpLokasi = explode(",", $tmp);
            //     $faske->lat = $tmpLokasi[0];
            //     $faske->long = $tmpLokasi[1];
            // }
            $faske->save();
            return Redirect::to('/faskes')->with('success', 'Data Faskes updated!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dokter  $dokter
     * @return \Illuminate\Http\Response
     */
    public function destroy($dokter)
    {
        Dokter::where('id', $dokter)->delete();
    }
}
