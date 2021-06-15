<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\TopUp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;


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
        $client = new \GuzzleHttp\Client();
        $response = $client->post('https://my.ipaymu.com/api/saldo', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => json_encode([
                'key' => $profile['api_key'],
            ])
        ]);
        // return json_decode($response->getBody(), true);
        $data = [
            'category_name' => 'Saldo',
            'page_name' => 'Saldo',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'profile' => $profile,
            'saldo' => json_decode($response->getBody(), true)
        ];
        return view('pages.saldo.index')->with($data);
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
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        $va           = '1179002340758828'; //get on iPaymu dashboard
        $secret       = '2BC8D477-98DC-414F-9DC1-8D9B7B9C9CDA'; //get on iPaymu dashboard

        $url          = 'https://sandbox.ipaymu.com/api/v2/payment'; //url
        $method       = 'POST'; //method

        //Request Body//
        $body['product']    = array('Top Up Saldo');
        $body['qty']        = array('1');
        $body['price']      = array($request->jumlah);
        $body['returnUrl']  = url('/') . '/ipaymu-success';
        $body['cancelUrl']  = 'http://antriaja.com/';
        $body['notifyUrl']  = 'https://mywebsite.com/notify';
        $body['name']  = Auth::user()->name;
        $body['email']  = Auth::user()->email;
        $body['phone']  = Auth::user()->no_hp;
        //End Request Body//

        //Generate Signature
        // *Don't change this
        $jsonBody     = json_encode($body, JSON_UNESCAPED_SLASHES);
        $requestBody  = strtolower(hash('sha256', $jsonBody));
        $stringToSign = strtoupper($method) . ':' . $va . ':' . $requestBody . ':' . $secret;
        $signature    = hash_hmac('sha256', $stringToSign, $secret);
        $timestamp    = Date('YmdHis');
        //End Generate Signature


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
            // return $res;
            if ($res['Status'] == 200) {
                TopUp::create([
                    "session_id" => $res['Data']['SessionID'],
                    "dokter" => Auth::user()->id,
                    "jumlah" => $request->jumlah
                ]);
                return Redirect::to($res['Data']['Url']);
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
