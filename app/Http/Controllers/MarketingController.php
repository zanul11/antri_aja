<?php

namespace App\Http\Controllers;

use App\Models\Marketing;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MarketingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $marketing = Marketing::where('role', 2)->get();
        $data = [
            'category_name' => 'Data Marketing',
            'page_name' => 'Data Marketing',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'data_marketing' => $marketing
        ];
        return view('pages.marketing.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'category_name' => 'Data Marketing',
            'page_name' => 'Tambah Data',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'action' => 'Tambah'
        ];
        // return config('sidemenu.administrator');
        return view('pages.marketing.form')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cek = Marketing::where('email', $request->email)->orWhere('nik', $request->nik)->get();
        if (count($cek) > 0) {
            return Redirect::to('/marketing/create')->withErrors(['Duplicate marketing email/nik!.'])->withInput()->with('message', 'Duplicate marketing email/nik!.');
        } else {
            Marketing::create([
                "name" => $request->nama,
                "email" => $request->email,
                "password" => bcrypt($request->password),
                "nik" => $request->nik,
                "no_hp" => $request->no_hp,
                "alamat" => $request->alamat,
                "role" => 2
            ]);
            return Redirect::to('/marketing')->with('success', 'Data Marketing added!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Marketing  $marketing
     * @return \Illuminate\Http\Response
     */
    public function show(Marketing $marketing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Marketing  $marketing
     * @return \Illuminate\Http\Response
     */
    public function edit(Marketing $marketing)
    {
        $data = [
            'category_name' => 'Marketing',
            'page_name' => 'Tambah Data',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'action' => 'Edit',
            'marketing' => $marketing
        ];
        // return config('sidemenu.administrator');
        return view('pages.marketing.form')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Marketing  $marketing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Marketing $marketing)
    {
        if ($request->email != $marketing->email && $request->nik != $marketing->nik) {
            $cek = Marketing::where('email', $request->email)->orWhere('nik', $request->nik)->get();
            if (count($cek) > 0) {
                return Redirect::to('/marketing/' . $marketing->id . '/edit')->withErrors(['Duplicate user email/nik!.'])->withInput()->with('message', 'Duplicate user email/nik!.');
            } else {
                if (isset($request->password) || $request->password != '')
                    $marketing->password = bcrypt($request->password);
                $marketing->email = $request->email;
                $marketing->name = $request->nama;
                $marketing->nik = $request->nik;
                $marketing->no_hp = $request->no_hp;
                $marketing->alamat = $request->alamat;
                $marketing->save();
                return Redirect::to('/marketing')->with('success', 'Data Marketing updated!');
            }
        } else {
            if (isset($request->password) || $request->password != '')
                $marketing->password = bcrypt($request->password);
            $marketing->email = $request->email;
            $marketing->name = $request->nama;
            $marketing->nik = $request->nik;
            $marketing->no_hp = $request->no_hp;
            $marketing->alamat = $request->alamat;
            $marketing->save();
            return Redirect::to('/marketing')->with('success', 'Data Marketing updated!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Marketing  $marketing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Marketing $marketing)
    {
        $marketing->delete();
    }
}
