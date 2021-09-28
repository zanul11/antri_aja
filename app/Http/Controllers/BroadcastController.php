<?php

namespace App\Http\Controllers;

use App\Models\Antri;
use App\Models\Broadcast;
use App\Models\Notif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class BroadcastController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $broadcast = Broadcast::orderby('created_at', 'desc')->get();
        $data = [
            'category_name' => 'Broadcast',
            'page_name' => 'Broadcast',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'data_broadcast' => $broadcast
        ];
        return view('pages.broadcast.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'category_name' => 'Broadcast',
            'page_name' => 'Tambah Broadcast',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'action' => 'Tambah'

        ];
        // $this->notifNakes('tes dong');
        return view('pages.broadcast.form')->with($data);
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
        // return substr(strip_tags(str_replace('<br>', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $request->pesan)), 0, 50) . "...";
        $foto = null;
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $path = public_path() . '/uploads/';
            $foto = 'gambar' . date('mdYHis') . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($path, $foto);
        }

        if ($request->jenis == 1) {
            Broadcast::create([
                "isi" => $request->pesan,
                "user" => Auth::user()->name,
                "batas" => $request->batas,
                "jenis" => $request->jenis,
                "foto" => $foto,
            ]);
        } else {
            $getnotif = Antri::select('notif_id')->groupby('notif_id')->get()->pluck('notif_id');
            Broadcast::create([
                "isi" => $request->pesan,
                "user" => Auth::user()->name,
                "batas" => $request->batas,
                "jenis" => $request->jenis,
                "foto" => $foto,
            ]);
            $url = 'https://fcm.googleapis.com/fcm/send';
            $msg = [
                'title' => 'Kabar Terbaru!',
                'body' => substr(strip_tags($request->pesan), 0, 110) . "...",

            ];
            Notif::create([
                "user" => 'Broadcast',
                "type" => 1,
                "judul" => 'Berita Terkini',
                "dari" => 'Administrator',
                "isi" => substr(strip_tags($request->pesan), 0, 110) . "...",
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
        }

        return Redirect::to('/broadcast')->with('success', 'Data Broadcast Sent!');
        return $request;
    }

    public function notifNakes($pesan)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $msg = [
            'title' => 'Kabar Terbaru!',
            'body' => substr(strip_tags($pesan), 0, 110) . "...",

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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Broadcast  $broadcast
     * @return \Illuminate\Http\Response
     */
    public function show(Broadcast $broadcast)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Broadcast  $broadcast
     * @return \Illuminate\Http\Response
     */
    public function edit(Broadcast $broadcast)
    {
        $data = [
            'category_name' => 'Broadcast',
            'page_name' => 'Edit Data',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'action' => 'Edit',
            'broadcast' => $broadcast
        ];
        return view('pages.broadcast.form')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Broadcast  $broadcast
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Broadcast $broadcast)
    {
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $path = public_path() . '/uploads/';
            $foto = 'gambar' . date('mdYHis') . uniqid() . '.' . $image->getClientOriginalExtension();
            if (is_file($path . $broadcast->foto))
                unlink($path . $broadcast->foto);
            $image->move($path, $foto);
            $broadcast->foto =  $foto;
        }
        $broadcast->isi = $request->pesan;
        $broadcast->jenis = $request->jenis;
        $broadcast->batas = $request->batas;
        $broadcast->user = Auth::user()->name;
        $broadcast->save();
        return Redirect::to('/broadcast')->with('success', 'Data Broadcast updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Broadcast  $broadcast
     * @return \Illuminate\Http\Response
     */
    public function destroy(Broadcast $broadcast)
    {
        $path = public_path() . '/uploads/';
        if (is_file($path . $broadcast->foto))
            unlink($path . $broadcast->foto);
        Broadcast::where('id', $broadcast->id)->delete();
    }
}
