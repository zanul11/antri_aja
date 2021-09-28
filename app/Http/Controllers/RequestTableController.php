<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Notif;
use App\Models\RequestTable;
use App\Models\TopUp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class RequestTableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = RequestTable::with('nakes_detail')->where('faskes', Auth::user()->email)->orderby('created_at')->orderby('status')->get();
        // return $request;
        $data = [
            'category_name' =>  'Request Saldo',
            'page_name' =>  'Request Saldo',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'action' => 'Tambah',
            'data_request' => $request,

        ];
        return view('pages.request.index')->with($data);
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
        $data = RequestTable::where('id', $request->id_request)->first();

        if ($request->status == 1) {
            if ($request->jumlah > $this->getSaldo()) {
                return Redirect::to('/request-saldo')->with('message', 'Maaf, Saldo anda tidak cukup!.');
            } else {
                // $tujuan = Dokter::where('id', $request->dokter)->first();
                //input potongan dokter
                TopUp::create([
                    // "session_id" => $res['Data']['SessionID'],
                    "trx_id" => '-',
                    "dokter" => Auth::user()->id,
                    "jumlah" => $request->jumlah,
                    "jumlah_admin" => 0,
                    "status" => 1,
                    "jenis" => 0,
                    "ket" => 'Disposisi',
                    "pasien_id" => '-',
                    "dari" => $data->nakes_detail->username,
                ]);
                TopUp::create([
                    // "session_id" => $res['Data']['SessionID'],
                    "trx_id" => '-',
                    "dokter" => $data->nakes_detail->id,
                    "jumlah" => $request->jumlah,
                    "status" => 1,
                    "jenis" => 1,
                    "ket" => 'Disposisi',
                    "dari" => Auth::user()->username,
                    "pasien_id" => '-'
                ]);
                $url = 'https://fcm.googleapis.com/fcm/send';
                $msg = [
                    'title' => 'Request Saldo Diterima!',
                    'body' => $request->ket,

                ];
                $extra = ["message" => $msg, "variable" => 'tes Variabel', "click_action" => 'FLUTTER_NOTIFICATION_CLICK'];
                $fcm = [
                    "to" =>   $data->nakes_detail->notif_id,
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
                Notif::create([
                    "user" => $data->nakes_detail->id,
                    "type" => 1,
                    "dari" => Auth::user()->name,
                    "isi" => $request->ket,
                    "judul" => 'Request Saldo Diterima',
                ]);
                RequestTable::where('id', $request->id_request)->update(['status' => 1, 'ket' => $request->ket]);
                return Redirect::to('/request-saldo')->with('success', 'Berhasil verifikasi request Saldo!.');
            }
        } else {
            //tolak
            $url = 'https://fcm.googleapis.com/fcm/send';
            $msg = [
                'title' => 'Request Saldo Ditolak!',
                'body' => $request->ket,

            ];
            $extra = ["message" => $msg, "variable" => 'tes Variabel', "click_action" => 'FLUTTER_NOTIFICATION_CLICK'];
            $fcm = [
                "to" =>   $data->nakes_detail->notif_id,
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
            Notif::create([
                "user" => $data->nakes_detail->id,
                "type" => 1,
                "dari" => Auth::user()->name,
                "isi" => $request->ket,
                "judul" => 'Request Saldo Ditolak',
            ]);
            RequestTable::where('id', $request->id_request)->update(['status' => 2, 'ket' => $request->ket]);
            return Redirect::to('/request-saldo')->with('success', 'Request Saldo ditolak!.');
        }
    }

    public function getSaldo()
    {
        $kredit = TopUp::where('dokter', Auth::user()->id)->where('status', 1)->where('jenis', 0)->sum('jumlah');
        $saldo = TopUp::where('dokter', Auth::user()->id)->where('status', 1)->where('jenis', 1)->sum('jumlah');
        return $saldo - $kredit;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RequestTable  $requestTable
     * @return \Illuminate\Http\Response
     */
    public function show(RequestTable $requestTable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RequestTable  $requestTable
     * @return \Illuminate\Http\Response
     */
    public function edit($requestTable)
    {
        $request = RequestTable::where('id', $requestTable)->first();
        $data = [
            'category_name' =>  'Request Saldo',
            'page_name' =>  'Verifikasi Request Saldo',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'action' => 'Tambah',
            'data_request' => $request,
        ];
        return view('pages.request.form')->with($data);

        return $request;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RequestTable  $requestTable
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RequestTable $requestTable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RequestTable  $requestTable
     * @return \Illuminate\Http\Response
     */
    public function destroy(RequestTable $requestTable)
    {
        //
    }
}
