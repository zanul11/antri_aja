<?php

namespace App\Http\Controllers;

use App\Models\Broadcast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $pesan = Broadcast::whereIN('jenis', [0, 1])->whereDATE('batas', '>=', date('Y-m-d'))->get();
        Session::put(['user' => 'KISE']);
        $data = [
            'category_name' => 'Dashboard',
            'page_name' => 'Dashboard',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'pesan' => $pesan
        ];
        // return config('sidemenu.administrator');
        return view('dashboard')->with($data);
    }
}
