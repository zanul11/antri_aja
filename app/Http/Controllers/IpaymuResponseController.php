<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Keranjang;
use App\Produk;
use App\Slider;
use Auth;

class IpaymuResponseController extends Controller
{
    public function success($id)
    {
        return view('ipaymu_success');
    }
    public function cancel()
    { }
}
