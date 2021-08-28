<?php

namespace App\Http\Controllers;

use App\Models\Antri;
use App\Models\Broadcast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $pie = array();
        $column_chart = array();
        $namaBulan = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        if (Auth::user()->role == 1) {
            $bln = array();
            $menunggu = array();
            $ditangani = array();
            $bulan = Antri::select(DB::raw('MONTH(tgl) bulan'))
                ->groupby('bulan')
                ->get();
            foreach ($bulan as $dt) {
                $fetch_line1 = Antri::where('status', 0)->whereMonth('tgl', $dt->bulan)->whereYear('tgl', date('Y'))->count();
                $fetch_line2 = Antri::where('status', 1)->whereMonth('tgl', $dt->bulan)->whereYear('tgl', date('Y'))->count();
                array_push($bln, $namaBulan[$dt->bulan]);
                array_push($menunggu, $fetch_line1);
                array_push($ditangani, $fetch_line2);
            }

            $pie1 = Antri::where('status', 0)->whereDate('tgl', date('Y-m-d'))->whereYear('tgl', date('Y'))->count();
            $pie2 = Antri::where('status', 1)->whereDate('tgl', date('Y-m-d'))->whereYear('tgl', date('Y'))->count();
            array_push($pie, [date('d-m-Y'), $pie1]);
            array_push($pie, [date('d-m-Y'), $pie2]);

            $column_chart =  array($bln, $menunggu, $ditangani);
        }
        $pesan = Broadcast::whereIN('jenis', [0, 1])->whereDATE('batas', '>=', date('Y-m-d'))->get();
        Session::put(['user' => 'KISE']);
        $data = [
            'category_name' => 'Dashboard',
            'page_name' => 'Dashboard',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'pesan' => $pesan,
            'column_chart' => $column_chart,
            'pie' => $pie
        ];
        // return config('sidemenu.administrator');
        return view('dashboard')->with($data);
    }

    public function getpiedate($tgl)
    {

        $pie = array();
        $pie1 = Antri::where('status', 0)->whereDate('tgl', $tgl)->count();
        $pie2 = Antri::where('status', 1)->whereDate('tgl', $tgl)->count();
        array_push($pie, ['a', $pie1]);
        array_push($pie, ['a', $pie2]);
        return $pie;
    }
}
