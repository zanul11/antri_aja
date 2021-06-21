<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Http\Controllers\Controller;
use App\Models\Marketing;
use App\Models\Spesialis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profile = Auth::user();
        $spesialis = Spesialis::all();

        $data = [
            'category_name' => 'My Profile',
            'page_name' => 'My Profile',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'profile' => $profile,
            'data_spesialis' => $spesialis
        ];
        return view('pages.user.profile')->with($data);
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



        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        // return $request;
        if ($request->username != $profile->username) {
            $cek = Marketing::where('username', $request->username)->get();
            if (count($cek) > 0) {
                return Redirect::to('/profile')->withErrors(['Duplicate username!.'])->withInput()->with('message', 'Duplicate username!.');
            } else {
                if ($request->hasFile('file')) {
                    $image = $request->file('file');
                    $path = public_path() . '/uploads/';
                    $foto = 'foto' . $request->username . '.' . $image->getClientOriginalExtension();
                    if (is_file($path . $profile->foto))
                        unlink($path . $profile->foto);
                    $image->move($path, $foto);
                    $profile->foto =  $foto;
                }
                $profile->email = $request->email;
                $profile->name = $request->nama;
                $profile->username = $request->username;
                $profile->no_hp = $request->no_hp;
                $profile->alamat = $request->alamat;
                $profile->spesialis = $request->spesialis;
                $profile->pengalaman = $request->pengalaman;
                $profile->deskripsi = $request->deskripsi;
                $profile->ig = $request->ig;
                $profile->fb = $request->fb;
                $profile->twitter = $request->twitter;
                $profile->youtube = $request->youtube;
                if (isset($request->latlong)) {
                    $profile->latlong = $request->latlong;
                    $tmp =  str_replace(']', '', str_replace('[', '', $request->latlong));
                    $tmpLokasi = explode(",", $tmp);
                    $profile->lat = $tmpLokasi[0];
                    $profile->long = $tmpLokasi[1];
                }
                $profile->save();
                return Redirect::to('/profile')->with('success', 'Data updated!');
            }
        } else {
            if ($request->hasFile('file')) {
                $image = $request->file('file');
                $path = public_path() . '/uploads/';
                $foto = 'foto' . $request->username . '.' . $image->getClientOriginalExtension();
                if (is_file($path . $profile->foto))
                    unlink($path . $profile->foto);
                $image->move($path, $foto);
                $profile->foto =  $foto;
            }
            $profile->email = $request->email;
            $profile->name = $request->nama;
            // $profile->username = $request->username;
            $profile->no_hp = $request->no_hp;
            $profile->alamat = $request->alamat;
            $profile->spesialis = $request->spesialis;
            $profile->pengalaman = $request->pengalaman;
            $profile->deskripsi = $request->deskripsi;
            $profile->ig = $request->ig;
            $profile->fb = $request->fb;
            $profile->twitter = $request->twitter;
            $profile->youtube = $request->youtube;
            if (isset($request->latlong)) {
                $profile->latlong = $request->latlong;
                $tmp =  str_replace(']', '', str_replace('[', '', $request->latlong));
                $tmpLokasi = explode(",", $tmp);
                $profile->lat = $tmpLokasi[0];
                $profile->long = $tmpLokasi[1];
            }
            $profile->save();
            return Redirect::to('/profile')->with('success', 'Data updated!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
