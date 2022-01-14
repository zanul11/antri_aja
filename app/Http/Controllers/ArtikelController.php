<?php

namespace App\Http\Controllers;

use App\Models\Antri;
use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Notif;

class ArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $broadcast = Artikel::orderby('created_at', 'desc')->get();
        $data = [
            'category_name' => 'Artikel',
            'page_name' => 'Artikel',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'data_broadcast' => $broadcast
        ];
        return view('pages.artikel.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'category_name' => 'Artikel',
            'page_name' => 'Tambah Artikel',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'action' => 'Tambah'

        ];
        // $this->notifNakes('tes dong');
        return view('pages.artikel.form')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function notifNakes($pesan)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $msg = [
            'title' => 'Artikel Terbaru!',
            'body' => $pesan . "...",

        ];
        $extra = ["message" => $msg, "variable" => 'tes Variabel', "click_action" => 'FLUTTER_NOTIFICATION_CLICK'];
        $fcm = [
            "to" =>  'eQB32sEuQ-mXkyWETF4akb:APA91bG5UkDcuShj3dBYvxuEdFraCvYkYpDod4gEG2Vqs2cf_TsHnwDv-BtT05uEk3cmLudrJetsJ7deZxhS-Ue8kius77XTrlN5mrk-6E9etvVobFxzoqCZABnGb7Cp2kvF5ZI9YB7z',
            "notification" => $msg,
            "data" => $extra
        ];
        $headers = [
            'Authorization: key=AAAA2BU4go4:APA91bGPl4BUpyENr52_pbDNAVvMO_CztuHh370psnvNcegJt2sB7QlEwUfc-W3f6aXRiPBPP9Hp4RLRqn0h_pd-x5-MlL3ykfg02ebaKNZDCefU3vsXXkGnLoNIo9emq1UG7a10Y_an',
            'Content-Type: application/json'
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcm));
        $result = curl_exec($ch);
        curl_close($ch);
    }
    public function store(Request $request)
    {
        $foto = null;
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $path = public_path() . '/uploads/';
            $foto = 'gambar' . date('mdYHis') . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($path, $foto);
        }
        $getnotif = Antri::select('notif_id')->groupby('notif_id')->get()->pluck('notif_id');
        $artikel = Artikel::create([
            "judul" => $request->judul,
            "isi" => $request->isi,
            "user" => Auth::user()->name,
            "foto" => $foto,
        ]);


        $url = 'https://fcm.googleapis.com/fcm/send';
        $msg = [
            'title' => 'Artikel Terbaru!',
            'body' => $request->judul . "...",

        ];
        Notif::create([
            "user" => 'Broadcast',
            "type" => 1,
            "judul" => 'Artikel Terkini',
            "dari" => 'Administrator',
            "id_data" => $artikel->id,
            "isi" => $request->judul . "...",
        ]);
        $extra = ["message" => $msg];
        $fcm = [
            "registration_ids" =>  $getnotif,
            "notification" => $msg,
            "data" => $extra
        ];
        $headers = [
            'Authorization: key=AAAAJjWldH0:APA91bH3gGJvWDe3U6DkR8P5hnqhc9h7xqM3LSY8q8vfzjDJNMPnbGqk-91KRZfpWmF4XvA89GEzht8NvNyN-MJVjnz9x9il8tyZpCTPd_f7AjdsoMqtjkWQbtwJ9WLr55VfuiXizDXY',
            'Content-Type: application/json'
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcm));
        $result = curl_exec($ch);
        curl_close($ch);
        $this->notifNakes($request->pesan);
        return Redirect::to('/artikel')->with('success', 'Data Artikel Terkirim!');
        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Artikel  $artikel
     * @return \Illuminate\Http\Response
     */
    public function show(Artikel $artikel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Artikel  $artikel
     * @return \Illuminate\Http\Response
     */
    public function edit(Artikel $artikel)
    {
        $data = [
            'category_name' => 'Artikel',
            'page_name' => 'Edit Data',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'action' => 'Edit',
            'artikel' => $artikel
        ];
        return view('pages.artikel.form')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Artikel  $artikel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Artikel $artikel)
    {
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $path = public_path() . '/uploads/';
            $foto = 'gambar' . date('mdYHis') . uniqid() . '.' . $image->getClientOriginalExtension();
            if (is_file($path . $artikel->foto))
                unlink($path . $artikel->foto);
            $image->move($path, $foto);
            $artikel->foto =  $foto;
        }
        $artikel->isi = $request->isi;
        $artikel->judul = $request->judul;
        $artikel->user = Auth::user()->name;
        $artikel->save();
        return Redirect::to('/artikel')->with('success', 'Data Artikel updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Artikel  $artikel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Artikel $artikel)
    {
        $path = public_path() . '/uploads/';
        if (is_file($path . $artikel->foto))
            unlink($path . $artikel->foto);
        Artikel::where('id', $artikel->id)->delete();
    }
}
