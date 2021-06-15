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
    public function success($id)
    {
        TopUp::where('dokter', $id)->update(["status" => 1]);
        return view('ipaymu_success');
    }
    public function cancel()
    { }
}
