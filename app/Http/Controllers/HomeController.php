<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        $data = [
            'category_name' => 'Dashboard',
            'page_name' => 'Dashboard',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];
        // return config('sidemenu.administrator');
        return view('dashboard')->with($data);
    }
}
