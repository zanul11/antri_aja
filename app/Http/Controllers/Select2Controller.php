<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Kecamatan;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Select2Controller extends Controller
{
    public function dokter(Request $request)
    {
        if ($request->has('key')) {
            $cari = str_replace(" ", "%", $request->key);
            if (Auth::user()->role == 2) {
                $data = Dokter::query()
                    ->whereRaw("concat(name,' ',username) like '%" . $cari . "%'")
                    ->where('id', '!=', Auth::user()->id)
                    ->where('parent', Auth::user()->id)
                    ->get();
            } else {
                $data = Dokter::query()
                    ->whereRaw("concat(name,' ',username) like '%" . $cari . "%'")
                    ->where('id', '!=', Auth::user()->id)
                    ->where('role', 5)
                    // ->orwhere('parent', Auth::user()->id)
                    ->where('email', Auth::user()->email)
                    ->get();
            }

            return response()->json($data);
        }
        return response()->json([]);
    }

    public function getkota(Provinsi $provinsi)
    {
        return $provinsi->kota;
    }
    public function getkec($kota)
    {
        return Kecamatan::where('city_id', $kota)->get();
    }
    public function getDataDisposisi(Request $request)
    {
        if ($request->has('key')) {
            $cari = str_replace(" ", "%", $request->key);
            $data = Dokter::query()
                ->whereRaw("concat(name,' ',username) like '%" . $cari . "%'")
                ->where('id', '!=', Auth::user()->id)
                ->whereIN('role', [2, 3])
                ->get();
            return response()->json($data);
        }
        return response()->json([]);
    }
}
