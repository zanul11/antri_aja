<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Antri;
use App\Models\Dokter;
use App\Models\PotonganSaldo;
use App\Models\TopUp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use PharIo\Manifest\Author;

class SaldoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $profile = Auth::user();
        // $client = new \GuzzleHttp\Client();
        // $response = $client->post('https://my.ipaymu.com/api/saldo', [
        //     'headers' => ['Content-Type' => 'application/json'],
        //     'body' => json_encode([
        //         'key' => $profile['api_key'],
        //     ])
        // ]);
        $dokter = Dokter::where('id', Auth::user()->id)->with(['saldo' => function ($q) {
            $q->where('status', 1);
            $q->orderby('created_at');
        }])->first();
        // return json_decode($response->getBody(), true);
        $data = [
            'category_name' => 'Saldo',
            'page_name' => 'Saldo',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'profile' => $profile,
            'saldo' => $this->getSaldo(),
            'data_dokter' => $dokter

        ];
        return view('pages.saldo.index')->with($data);
    }

    public function getSaldo()
    {
        $kredit = PotonganSaldo::where('dokter', Auth::user()->id)->sum('jumlah');
        $kredit2 = TopUp::where('dokter', Auth::user()->id)->where('ket', 'Withdraw/Penarikan')->sum('jumlah');
        $kredit3 = TopUp::where('dokter', Auth::user()->id)->where('jenis', 0)->where('ket', 'Disposisi')->sum('jumlah');
        $saldo = TopUp::where('dokter', Auth::user()->id)->where('status', 1)->where('jenis', 1)->sum('jumlah');
        return $saldo - $kredit - $kredit2 - $kredit3;
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
        Dokter::where('id', Auth::user()->id)
            ->update(["api_key" => $request->api_key]);
        return Redirect::to('/saldo')->with('success', 'Api Key iPaymu berhasil ditambahkan!');
        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    { }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // return $request;
        //production
        $va           = '1179001227977474';
        $secret       = 'BE93365D-9A7A-469F-B34D-7B96EA454568';
        // $va           = '1179002340758828'; //sandbox dev
        // $secret       = '2BC8D477-98DC-414F-9DC1-8D9B7B9C9CDA'; //sandbox dev

        // $url          = 'https://sandbox.ipaymu.com/api/v2/payment'; //redirect
        // $url          = 'https://sandbox.ipaymu.com/api/v2/payment/direct';
        $url          = 'https://my.ipaymu.com/api/v2/payment/direct'; //direct
        $method       = 'POST'; //method

        $generateUid =  substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 9);
        // return $request->jumlah;

        // if ($request->metode == 'va') {
        //     $fee = 3500;
        // } else if ($request->metode == 'banktransfer') {
        //     $fee = 4000;
        // } else {
        //     $fee = ceil(((0.7 / 100) * $request->jumlah) + ((1.43 / 100) * $request->jumlah));
        // }
        // return $fee;
        //Request Body//
        $body['product']    = array('Top Up Saldo Antri Aja');
        $body['qty']        = array('1');
        $body['price']      = array($request->jumlah);
        // $body['amount']     = $request->jumlah;
        $body['returnUrl']  = url('/') . '/topup-success';
        $body['cancelUrl']  = url('/') . '/saldo';
        $body['notifyUrl']  = url('/') . '/ipaymu-success';
        $body['name']  = Auth::user()->name;
        $body['email']  = Auth::user()->email;
        $body['phone']  = '081939477455';

        //khusus direct
        $body['paymentMethod']  = $request->metode;
        $body['paymentChannel']  = $request->paymentChannel;
        $body['amount']     = $request->jumlah;

        //End Request Body//

        //Generate Signature
        // *Don't change this
        $jsonBody     = json_encode($body, JSON_UNESCAPED_SLASHES);
        $requestBody  = strtolower(hash('sha256', $jsonBody));
        $stringToSign = strtoupper($method) . ':' . $va . ':' . $requestBody . ':' . $secret;
        $signature    = hash_hmac('sha256', $stringToSign, $secret);
        $timestamp    = Date('YmdHis');
        //End Generate Signature

        // return $signature . ' - ' . $timestamp;


        $ch = curl_init($url);

        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
            'va: ' . $va,
            'signature: ' . $signature,
            'timestamp: ' . $timestamp
        );

        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_POST, count($body));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $err = curl_error($ch);
        $ret = curl_exec($ch);
        curl_close($ch);

        // header('Location: https://www.facebook.com/');

        if ($err) {
            // echo $err;
            return Redirect::to('/saldo')->with('message', 'Error Ipaymu');
        } else {

            $res = json_decode($ret, true);

            if ($res['Status'] == 200) {
                // TopUp::create([
                //     // "session_id" => $res['Data']['SessionID'],
                //     "trx_id" => $res['Data']['TransactionId'],
                //     "dokter" => Auth::user()->id,
                //     "jumlah" => $request->jumlah,
                //     "uid" => $generateUid,
                //     "fee" => $res['Data']['Fee'],
                //     "metode" => $request->metode,
                //     "channel" => $request->paymentChannel
                // ]);
                $data = [
                    'category_name' => 'Saldo',
                    'page_name' => 'Saldo',
                    'has_scrollspy' => 0,
                    'scrollspy_offset' => '',
                    'dt_pembayaran' => $res['Data']
                ];
                return view('pages.saldo.pembayaran')->with($data);
                // return Redirect::to($res['Data']['Url']);
            } else {
                return Redirect::to('/saldo')->with('message', $res['Message']);
            }
            // return $res['Data']['Url'];

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
        //
    }
}
