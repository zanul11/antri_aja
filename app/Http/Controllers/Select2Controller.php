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
            $data = Dokter::query()
                ->whereRaw("concat(name,' ',username) like '%" . $cari . "%'")
                ->where('id', '!=', Auth::user()->id)
                ->get();
            return response()->json($data);
        }
        return response()->json([]);
    }
}
