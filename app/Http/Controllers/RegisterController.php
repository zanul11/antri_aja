<?php

namespace App\Http\Controllers;

use App\Models\Register;
use App\Http\Controllers\Controller;
use App\Models\Antri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Session::has('user')) {
            // return Session::get('id');
            // return $antri =  User::with('antri')->with('antri.dokter_detail')->with('antri.waktu_detail')->where('pasien', Session::get('id'))->first();
            $antri = Antri::with('dokter_detail')->with('waktu_detail')->where('user_id')->get();
            // $spesialis = Spesialis::all();
            $data = [
                'category_name' => 'Daftar Antrian',
                'page_name' => 'Daftar Antrian',
                'has_scrollspy' => 0,
                'scrollspy_offset' => '',
                'data_antri' => $antri,
            ];
            return view('pages.antri.index')->with($data);
        } else {
            $data = [
                'category_name' => 'Data Marketing',
                'page_name' => 'Data Marketing',
                'has_scrollspy' => 0,
                'scrollspy_offset' => '',
            ];
            return view('auth.register');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return 'tes';
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
        Session::put(
            [
                'user' => $request->nama,
                'no_hp' => $request->no_hp,
                'id' => substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 9)
            ]
        );
        return Redirect::to('/antri')->with('success', 'Daftar berhasil!');
        // $cek = Register::where('email', $request->no_hp)->get();
        // if (count($cek) > 0) {
        //     return Redirect::to('/register')->withErrors(['Duplicate no hp!.'])->withInput()->with('message', 'Duplicate no hp!.');
        // } else {
        //     // return $request;
        //     Register::create([
        //         "name" => $request->nama,
        //         "email" => $request->no_hp,
        //         "password" => bcrypt($request->password),
        //         "no_hp" => $request->no_hp,
        //         "role" => 4
        //     ]);
        //     return Redirect::to('/login')->with('success', 'Daftar berhasil!');
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Register  $register
     * @return \Illuminate\Http\Response
     */
    public function show(Register $register)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Register  $register
     * @return \Illuminate\Http\Response
     */
    public function edit($register)
    {
        Session::flush();
        return Redirect::to('/')->with('success', 'Cache Cleared');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Register  $register
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Register $register)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Register  $register
     * @return \Illuminate\Http\Response
     */
    public function destroy(Register $register)
    {
        //
    }
}
