<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
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
                    ->where('parent', Auth::user()->id)
                    ->orWhere('parent', Auth::user()->id)
                    ->get();
            }

            return response()->json($data);
        }
        return response()->json([]);
    }
}
