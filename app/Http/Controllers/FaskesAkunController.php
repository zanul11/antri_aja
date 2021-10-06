<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Dokter;
use App\Models\Provinsi;
use App\Models\Spesialis;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class FaskesAkunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $cek = Akun::where('username', $request->username)->get();
        if (count($cek) > 0) {
            return Redirect::to('/data-akun/' . $request->id_faskes)->withErrors(['Duplicate Username!.'])->withInput()->with('message', 'Duplicate Username!.');
        } else {

            Akun::create([
                "name" => $request->nama,
                "username" => $request->username,
                "email" => $request->email_faskes,
                "password" => bcrypt($request->password),
                "password_show" => $request->password,
                "no_hp" => $request->no_hp,
                "alamat" => $request->alamat,
                "parent" => $request->parent_faskes,
                "spesialis" => $request->spesialis,
                "pengalaman" => $request->pengalaman,
                "deskripsi" => $request->deskripsi,
                "role" => 5,
                "id_province" => $request->province,
                "id_city" => $request->kota,
                "id_subdistrict" => $request->kec,
            ]);
            return Redirect::to('/data-faskes/' . $request->id_faskes)->with('success', 'Data Akun Nakes added!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $faskes = Dokter::where('id', $id)->first();
        $spesialis = Spesialis::all();
        $provinsi =  Provinsi::all();

        $data = [
            'category_name' => 'Data Faskes',
            'page_name' => 'Data Akun',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'action' => 'Tambah',
            'data_spesialis' => $spesialis,
            'data_provinsi' => $provinsi,
            'faskes' => $faskes

        ];
        // return config('sidemenu.administrator');
        return view('pages.data-faskes.data-akun.form')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Dokter $data_akun)
    {
        // return $id;
        $spesialis = Spesialis::all();
        $provinsi =  Provinsi::all();
        $faskes = Dokter::where('email', $data_akun->email)->where('username', $data_akun->email)->first();
        $data = [
            'category_name' => 'Data Faskes',
            'page_name' => 'Data Akun',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'action' => 'Edit',
            'data_spesialis' => $spesialis,
            'akun' => $data_akun,
            'data_provinsi' => $provinsi,
            'faskes' => $faskes
        ];
        // return config('sidemenu.administrator');
        return view('pages.data-faskes.data-akun.form')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Akun $data_akun)
    {
        // return $request;
        // $faskes = Dokter::where()
        if ($request->username != $data_akun->username) {
            $cekUser = User::where('username', $request->username)->get();
            if (count($cekUser) > 0) {
                return Redirect::to('/data-akun/' . $request->id_faskes)->withErrors(['Duplicate username!.'])->withInput()->with('message', 'Duplicate username!.');
            } else {
                if (isset($request->password) || $request->password != '') {
                    $data_akun->password = bcrypt($request->password);
                    $data_akun->password_show = $request->password;
                }
                $data_akun->username = $request->username;
                $data_akun->name = $request->nama;
                $data_akun->no_hp = $request->no_hp;
                $data_akun->pengalaman = $request->pengalaman;
                $data_akun->deskripsi = $request->deskripsi;
                $data_akun->alamat = $request->alamat;
                $data_akun->id_province = $request->province;
                $data_akun->id_city = $request->kota;
                $data_akun->id_subdistrict = $request->kec;
                $data_akun->save();
                return Redirect::to('/data-faskes/' . $request->id_faskes)->with('success', 'Data Akun updated!');
            }
        } else {
            if (isset($request->password) || $request->password != '') {
                $data_akun->password = bcrypt($request->password);
                $data_akun->password_show = $request->password;
            }
            $data_akun->name = $request->nama;
            $data_akun->no_hp = $request->no_hp;
            $data_akun->pengalaman = $request->pengalaman;
            $data_akun->deskripsi = $request->deskripsi;
            $data_akun->alamat = $request->alamat;
            $data_akun->id_province = $request->province;
            $data_akun->id_city = $request->kota;
            $data_akun->id_subdistrict = $request->kec;
            $data_akun->save();
            return Redirect::to('/data-faskes/' . $request->id_faskes)->with('success', 'Data Akun updated!');
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
