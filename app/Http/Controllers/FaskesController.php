<?php

namespace App\Http\Controllers;

use App\Exports\LaporanFaskes;
use App\Exports\LaporanNakes;
use App\Models\Dokter;
use App\Models\Provinsi;
use App\Models\Spesialis;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;

class FaskesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $jaringan = User::with('childrenRekursif')->where('id', Auth::id())->firstOrFail();
        $dokter = Dokter::with('akun_faskes')->where('role', 3)->get();
        $data = [
            'category_name' => 'Data Faskes',
            'page_name' => 'Data Faskes',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'action' => 'Tambah',
            'data_dokter' => $dokter,

        ];
        return view('pages.data-faskes.index')->with($data);
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
            'category_name' => 'Data Faskes',
            'page_name' => 'Tambah Data',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'action' => 'Tambah',
            'data_spesialis' => $spesialis,
            'data_provinsi' => $provinsi,

        ];
        return view('pages.data-faskes.form')->with($data);
    }

    public function ExportFaskes()
    {
        return Excel::download(new LaporanFaskes(), 'export_laporan_marketing.xlsx');
    }

    public function ExportNakes($id)
    {
        return Excel::download(new LaporanNakes($id), 'export_laporan_marketing.xlsx');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cek = Dokter::where('email', $request->email)->get();
        if (count($cek) > 0) {
            return Redirect::to('/data-faskes/create')->withErrors(['Duplicate Faskes email/username!.'])->withInput()->with('message', 'Duplicate Faskes email/username!.');
        } else {
            Dokter::create([
                "name" => $request->nama,
                "email" => $request->email,
                "username" => $request->email,
                "password" => bcrypt($request->password),
                "password_show" => $request->password,
                "no_hp" => $request->no_hp,
                "alamat" => $request->alamat,
                "parent" => Auth::user()->id,
                "spesialis" => $request->spesialis,
                "pengalaman" => $request->pengalaman,
                "deskripsi" => $request->deskripsi,
                "role" => 3,
                "nama_faskes" => $request->nama_faskes,
                "kode_faskes" => $request->kode_faskes,
                "tlp_faskes" => $request->tlp_faskes,
                "id_province" => $request->province,
                "id_city" => $request->kota,
                "id_subdistrict" => $request->kec,
                "potongan" => $request->potongan

            ]);
            return Redirect::to('/data-faskes')->with('success', 'Data Faskes added!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Dokter $data_faske)
    {

        $akun = Dokter::where('email', $data_faske->email)->where('role', 5)->get();
        $data = [
            'category_name' => 'Data Faskes',
            'page_name' => 'Data Nakes',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'action' => 'Tambah',
            'data_akun' => $akun,
            'faskes' => $data_faske
        ];
        return view('pages.data-faskes.akun')->with($data);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Dokter $data_faske)
    {
        $provinsi =  Provinsi::all();
        $spesialis = Spesialis::all();
        $data = [
            'category_name' => 'Data Faskes',
            'page_name' => 'Lihat Data',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'action' => 'Edit',
            'data_spesialis' => $spesialis,
            'dokter' => $data_faske,
            'data_provinsi' => $provinsi
        ];
        return view('pages.data-faskes.form')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  Dokter $data_faske)
    {
        $faske =  $data_faske;
        if ($request->email != $faske->email) {
            $cek = Dokter::where('email', $request->email)->get();
            if (count($cek) > 0) {
                return Redirect::to('/data-faskes/' . $faske->id . '/edit')->withErrors(['Duplicate Faskes email/username!.'])->withInput()->with('message', 'Duplicate Faskes email/username!.');
            } else {
                if (isset($request->password) || $request->password != '') {
                    $faske->password = bcrypt($request->password);
                    $faske->password_show = $request->password;
                }
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
                $faske->potongan = $request->potongan;
                $faske->save();
                return Redirect::to('/data-faskes')->with('success', 'Data Faskes updated!');
            }
        } else {
            if (isset($request->password) || $request->password != '') {
                $faske->password = bcrypt($request->password);
                $faske->password_show = $request->password;
            }
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
            $faske->potongan = $request->potongan;
            $faske->save();
            return Redirect::to('/data-faskes')->with('success', 'Data Faskes updated!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Dokter::where('id', $id)->delete();
    }
}
