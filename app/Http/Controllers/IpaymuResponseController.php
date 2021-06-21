<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Keranjang;
use App\Models\TopUp;
use App\Produk;
use App\Slider;
use Auth;

class IpaymuResponseController extends Controller
{
    public function success(Request $request)
    {
        $trx_id = $request->trx_id;
        $sid = $request->sid;
        $status = $request->status;
        if ($request->status == 'berhasil')
            TopUp::where('trx_id',  $trx_id)->update(["status" => 1]);
        return view('ipaymu_success');
    }

    public function successView()
    {
        // TopUp::where('dokter', $email)->where('uid', $uid)->update(["status" => 1]);
        return view('ipaymu_success');
    }


    public function cancel()
    { }
}
