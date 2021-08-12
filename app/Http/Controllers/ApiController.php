<?php

namespace App\Http\Controllers;

use App\Models\Antri;
use App\Models\Dokter;
use App\Models\Jadwal;
use App\Models\Spesialis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    public function login(Request $r)
    {
        $res = [
            'status' => false,
            'data' => null
        ];
        $credentials = request(['email', 'password']);
        $email = $r->email;
        $pass = $r->password;
        $user = Dokter::where('email', $email)->first();
        if (!$user) {
            return response()->json(['status' => false, 'data' => 'Email atau password salah.']);
        }
        if (!Hash::check($pass, $user->password)) {
            return response()->json(['status' => false, 'data' => 'Email atau password salah.']);
        }
        if (!Auth::attempt($credentials)) {
            return response()->json(['status' => false, 'data' => 'Email atau password salah.', 'token' => null]);
        }

        return response()->json(['status' => true, 'data' => $r->user()]);
    }

    public function getAntriUser(Request $r)
    {
        return $antri = Antri::with('dokter_detail')->with('waktu_detail')->where('user_id', $r->user_id)->where('status', 0)->get();
    }

    public function getAntriUserDitangani(Request $r)
    {
        return $antri = Antri::with('dokter_detail')->with('waktu_detail')->where('user_id', $r->user_id)->where('status', 1)->get();
    }

    public function getSpesialis()
    {
        return Spesialis::all();
    }

    public function getDokterSpesialis(Request $r)
    {
        $dokter = Dokter::with(['jadwal' => function ($q) {
            $q->groupBy('hari');
        }])->where('spesialis', $r->spesialis)->withCount(['antri' => function ($q) {
            $q->where('status', 1);
        }])->with('spesialis_detail')->orderBy('antri_count', 'desc')->get();
        return $dokter;
    }

    public function getJam(Request $r)
    {
        $jam = Jadwal::where('hari', $r->hari)->where('id_user', $r->dokter)->orderBy('hari')->orderBy('dJam')->get();
        return $jam;
    }

    public function getJumAntrian(Request $r)
    {
        $jum = Antri::where('dokter', $r->dokter)->whereDate('tgl', $r->tgl)->where('waktu', $r->jam)->count();
        return response()->json(['status' => true, 'data' =>  $jum]);
    }

    public function saveAntrian(Request $r)
    {
        $jum = Antri::where('dokter', $r->dokter)->whereDate('tgl', $r->tgl)->where('waktu', $r->jam)->count();
        $jam = Jadwal::where('id', $r->jam)->first();
        Antri::create([
            'no_antrian' => $jum + 1,
            'user_id' => $r->user_id,
            'pasien' => $r->pasien,
            'umur' => $r->umur,
            'tgl' => $r->tgl,
            'dokter' => $r->dokter,
            'waktu' => $r->jam,
            'dJam' => $jam['dJam'],
            'sJam' => $jam['sJam'],
            'catatan' => $r->catatan,
            'no_hp' => $r->no_hp,
            'user_name' => $r->username,
            'notif_id' => $r->notif_id,
        ]);
        return response()->json(['status' => true, 'data' =>  'Sukses']);
    }

    public function deleteAntrian(Request $r)
    {
        Antri::where('id', $r->id)->delete();
        return response()->json(['status' => true, 'data' =>  'Sukses']);
    }

    public function detailAntrian(Request $r)
    {
        return Antri::with('dokter_detail')->with('waktu_detail')->where('id', $r->id)->get();
    }

    public function getDokterTernama()
    {
        return $antri = Dokter::where('role', 5)->with('spesialis_detail')->withCount(['antri' => function ($q) {
            $q->where('status', 1);
        }])->with(['jadwal' => function ($q) {
            $q->groupBy('hari');
        }])->with('spesialis_detail')->orderBy('antri_count', 'desc')->take(5)->get();
    }

    public function getSpesialisTernama()
    {
        return $antri = Dokter::where('role', 5)->with('spesialis_detail')->withCount(['antri' => function ($q) {
            $q->where('status', 1);
        }])->orderBy('antri_count', 'desc')->groupBy('spesialis')->limit(5)
            ->get();
    }

    public function searchDokter(Request $request)
    {
        return $antri = Dokter::where('role', 5)->with('spesialis_detail')->withCount(['antri' => function ($q) {
            $q->where('status', 1);
        }])->with(['jadwal' => function ($q) {
            $q->groupBy('hari');
        }])->with('spesialis_detail')->orderBy('antri_count', 'desc')->where('name', 'like', '%' . $request->key . '%')->where('spesialis', $request->spesialis)->get();
    }

    public function searchSpesialis(Request $request)
    {
        return Spesialis::where('spesialis', 'like', '%' . $request->key . '%')->get();
    }

    public function getFaskesTernama()
    {
        return  DB::select("select a.*, (select count(*) from `users` where email=a.email) as `akun` from `users` a where `role` = 3  ORDER BY akun DESC limit 5");
    }
    public function getFaskesAll()
    {
        return  DB::select("select a.*, (select count(*) from `users` where email=a.email) as `akun` from `users` a where `role` = 3  ORDER BY a.nama_faskes ");
    }
    public function searchFaskes(Request $r)
    {
        return  DB::select("select a.*, (select count(*) from `users` where email=a.email) as `akun` from `users` a where `role` = 3 and nama_faskes like '%$r->key%'   ORDER BY a.nama_faskes ");
    }

    public function getDokterFaskes(Request $r)
    {
        $dokter = Dokter::with(['jadwal' => function ($q) {
            $q->groupBy('hari');
        }])->where('email', $r->email)->where('username', '!=', $r->email)->withCount(['antri' => function ($q) {
            $q->where('status', 1);
        }])->with('spesialis_detail')->orderBy('antri_count', 'desc')->get();
        return $dokter;
    }

    public function searchDokterFaskes(Request $request)
    {
        return $antri = Dokter::where('role', 5)->with('spesialis_detail')->withCount(['antri' => function ($q) {
            $q->where('status', 1);
        }])->with(['jadwal' => function ($q) {
            $q->groupBy('hari');
        }])->with('spesialis_detail')->orderBy('antri_count', 'desc')->where('name', 'like', '%' . $request->key . '%')
            ->where('email', $request->email)->where('username', '!=', $request->email)->get();
    }
}
