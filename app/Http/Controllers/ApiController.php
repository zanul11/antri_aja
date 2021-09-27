<?php

namespace App\Http\Controllers;

use App\Models\Antri;
use App\Models\Dokter;
use App\Models\Jadwal;
use App\Models\Kecamatan;
use App\Models\Provinsi;
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
        return $antri = Antri::with('dokter_detail')->with('waktu_detail')->where('no_hp', $r->user_id)->where('status', 0)->orderby('tgl', 'desc')->get();
    }

    public function getAntriUserDitangani(Request $r)
    {
        return $antri = Antri::with('dokter_detail')->with('waktu_detail')->where('no_hp', $r->user_id)->where('status', 1)->orderby('tgl', 'desc')->get();
    }

    public function getSpesialis()
    {
        return Spesialis::all();
    }

    public function getDokterSpesialis(Request $r)
    {
        $dokter = Dokter::where('role', 5)->with(['jadwal' => function ($q) { }])->where('spesialis', $r->spesialis)->withCount(['antri' => function ($q) {
            $q->where('status', 1);
        }])->with('spesialis_detail')->with('provinsi')->with('kota')->with('kecamatan')->orderBy('antri_count', 'desc')->get();
        return $dokter;
    }

    public function getDokterSpesialisWilayah(Request $r)
    {
        if (isset($r->kecamatan)) {
            $dokter = Dokter::with(['jadwal' => function ($q) { }])
                ->where('role', 5)
                ->where('id_province', $r->provinsi)
                ->where('id_city', $r->kota)
                ->where('id_subdistrict', $r->kecamatan)
                ->where('spesialis', $r->spesialis)->withCount(['antri' => function ($q) {
                    $q->where('status', 1);
                }])->with('spesialis_detail')->with('provinsi')->with('kota')->with('kecamatan')->orderBy('antri_count', 'desc')->get();
        } else {
            $dokter = Dokter::with(['jadwal' => function ($q) { }])->where('role', 5)
                ->where('id_province', $r->provinsi)
                ->where('id_city', $r->kota)
                ->where('spesialis', $r->spesialis)->withCount(['antri' => function ($q) {
                    $q->where('status', 1);
                }])->with('spesialis_detail')->with('provinsi')->with('kota')->with('kecamatan')->orderBy('antri_count', 'desc')->get();
        }

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
        }])->with(['jadwal' => function ($q) { }])->with('spesialis_detail')->with('provinsi')->with('kota')->with('kecamatan')->orderBy('antri_count', 'desc')->take(5)->get();
    }

    public function getDokterTernamaWilayah(Request $r)
    {
        if (isset($r->kecamatan)) {
            return $antri = Dokter::where('role', 5)
                ->where('id_province', $r->provinsi)
                ->where('id_city', $r->kota)
                ->where('id_subdistrict', $r->kecamatan)
                ->with('spesialis_detail')->withCount(['antri' => function ($q) {
                    $q->where('status', 1);
                }])->with(['jadwal' => function ($q) { }])->with('spesialis_detail')->with('provinsi')->with('kota')->with('kecamatan')->orderBy('antri_count', 'desc')->take(5)->get();
        } else {
            return $antri = Dokter::where('role', 5)
                ->where('id_province', $r->provinsi)
                ->where('id_city', $r->kota)
                ->with('spesialis_detail')->withCount(['antri' => function ($q) {
                    $q->where('status', 1);
                }])->with(['jadwal' => function ($q) { }])->with('spesialis_detail')->with('provinsi')->with('kota')->with('kecamatan')->orderBy('antri_count', 'desc')->take(5)->get();
        }
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
        }])->with(['jadwal' => function ($q) { }])->with('spesialis_detail')->with('provinsi')->with('kota')->with('kecamatan')->orderBy('antri_count', 'desc')->where('name', 'like', '%' . $request->key . '%')->where('spesialis', $request->spesialis)->get();
    }

    public function searchDokterWilayah(Request $request)
    {
        if (isset($request->kecamatan)) {
            return $antri = Dokter::where('role', 5)
                ->where('id_province', $request->provinsi)
                ->where('id_city', $request->kota)
                ->where('id_subdistrict', $request->kecamatan)
                ->with('spesialis_detail')->withCount(['antri' => function ($q) {
                    $q->where('status', 1);
                }])->with(['jadwal' => function ($q) { }])->with('spesialis_detail')->with('provinsi')->with('kota')->with('kecamatan')->orderBy('antri_count', 'desc')->where('name', 'like', '%' . $request->key . '%')->where('spesialis', $request->spesialis)->get();
        } else {
            return $antri = Dokter::where('role', 5)
                ->where('id_province', $request->provinsi)
                ->where('id_city', $request->kota)
                ->with('spesialis_detail')->withCount(['antri' => function ($q) {
                    $q->where('status', 1);
                }])->with(['jadwal' => function ($q) { }])->with('spesialis_detail')->with('provinsi')->with('kota')->with('kecamatan')->orderBy('antri_count', 'desc')->where('name', 'like', '%' . $request->key . '%')->where('spesialis', $request->spesialis)->get();
        }
    }

    public function searchSpesialis(Request $request)
    {
        return Spesialis::where('spesialis', 'like', '%' . $request->key . '%')->get();
    }

    public function getFaskesTernama()
    {
        return  DB::select("select a.*, (select count(*) from `users` where email=a.email) as `akun` from `users` a where `role` = 3  ORDER BY akun DESC limit 5");
    }

    public function getFaskesTernamaWilayah(Request $r)
    {
        if (isset($r->kecamatan)) {
            return  DB::select("select a.*, (select count(*) from `users` where email=a.email) as `akun` from `users` a where `role` = 3 AND `id_province` = '$r->provinsi' AND `id_city` = '$r->kota' AND `id_subdistrict` = '$r->kecamatan'  ORDER BY akun DESC limit 5");
        } else {
            return  DB::select("select a.*, (select count(*) from `users` where email=a.email) as `akun` from `users` a where `role` = 3 AND `id_province` = '$r->provinsi' AND `id_city` = '$r->kota' ORDER BY akun DESC limit 5");
        }
    }

    public function getFaskesAll()
    {
        return  DB::select("select a.*, (select count(*) from `users` where email=a.email) as `akun` from `users` a where `role` = 3  ORDER BY a.nama_faskes ");
    }

    public function getFaskesAllWilayah(Request $r)
    {
        if (isset($r->kecamatan)) {
            return  DB::select("select a.*, (select count(*) from `users` where email=a.email) as `akun` from `users` a where `role` = 3 AND `id_province` = '$r->provinsi' AND `id_city` = '$r->kota' AND `id_subdistrict` = '$r->kecamatan'  ORDER BY a.nama_faskes ");
        } else {
            return  DB::select("select a.*, (select count(*) from `users` where email=a.email) as `akun` from `users` a where `role` = 3 AND `id_province` = '$r->provinsi' AND `id_city` = '$r->kota' ORDER BY a.nama_faskes ");
        }
    }

    public function searchFaskes(Request $r)
    {
        return  DB::select("select a.*, (select count(*) from `users` where email=a.email) as `akun` from `users` a where `role` = 3 and nama_faskes like '%$r->key%'   ORDER BY a.nama_faskes ");
    }

    public function searchFaskesWilayah(Request $r)
    {
        if (isset($r->kecamatan)) {
            return  DB::select("select a.*, (select count(*) from `users` where email=a.email) as `akun` from `users` a where `role` = 3 and nama_faskes like '%$r->key%' AND `id_province` = '$r->provinsi' AND `id_city` = '$r->kota' AND `id_subdistrict` = '$r->kecamatan' ORDER BY a.nama_faskes ");
        } else {
            return  DB::select("select a.*, (select count(*) from `users` where email=a.email) as `akun` from `users` a where `role` = 3 and nama_faskes like '%$r->key%' AND `id_province` = '$r->provinsi' AND `id_city` = '$r->kota' ORDER BY a.nama_faskes ");
        }
    }

    public function getDokterFaskes(Request $r)
    {
        $dokter = Dokter::with(['jadwal' => function ($q) { }])->where('email', $r->email)->where('username', '!=', $r->email)->withCount(['antri' => function ($q) {
            $q->where('status', 1);
        }])->with('spesialis_detail')->with('provinsi')->with('kota')->with('kecamatan')->orderBy('antri_count', 'desc')->get();
        return $dokter;
    }

    public function searchDokterFaskes(Request $request)
    {
        return $antri = Dokter::where('role', 5)->with('spesialis_detail')->withCount(['antri' => function ($q) {
            $q->where('status', 1);
        }])->with(['jadwal' => function ($q) { }])->with('spesialis_detail')->with('provinsi')->with('kota')->with('kecamatan')->orderBy('antri_count', 'desc')->where('name', 'like', '%' . $request->key . '%')
            ->where('email', $request->email)->where('username', '!=', $request->email)->get();
    }

    public function broadcast()
    {
        $bc = DB::select(DB::raw("SELECT *, concat('http://antriaja.com/uploads/',foto) as link_gambar FROM broadcast where jenis IN (0,2) order by created_at desc limit 5"));
        return $bc;
    }


    public function getProvinsi()
    {
        return Provinsi::all();
    }
    public function cariProvinsi($cari)
    {
        if ($cari != '')
            return Provinsi::where('province', 'like', '%' . $cari . '%')->get();
        else
            return Provinsi::all();
    }

    public function getkota(Provinsi $provinsi)
    {
        return $provinsi->kota;
    }

    public function getkec($kota)
    {
        return Kecamatan::where('city_id', $kota)->get();
    }

    public function getDokterWilayah(Request $r)
    {
        if (isset($r->kecamatan)) {
            $dokter = Dokter::with(['jadwal' => function ($q) { }])
                ->where('id_province', $r->provinsi)
                ->where('id_city', $r->kota)
                ->where('id_subdistrict', $r->kecamatan)
                ->where('role', 5)->withCount(['antri' => function ($q) {
                    $q->where('status', 1);
                }])->with('spesialis_detail')->with('provinsi')->with('kota')->with('kecamatan')->orderBy('antri_count', 'desc')->get();
        } else {
            $dokter = Dokter::with(['jadwal' => function ($q) { }])
                ->where('id_province', $r->provinsi)
                ->where('id_city', $r->kota)
                ->where('role', 5)->withCount(['antri' => function ($q) {
                    $q->where('status', 1);
                }])->with('spesialis_detail')->with('provinsi')->with('kota')->with('kecamatan')->orderBy('antri_count', 'desc')->get();
        }

        return $dokter;
    }
    public function cariDokterWilayah(Request $r)
    {
        if (isset($r->kecamatan)) {
            $dokter = Dokter::with(['jadwal' => function ($q) { }])
                ->where('id_province', $r->provinsi)
                ->where('id_city', $r->kota)
                ->where('id_subdistrict', $r->kecamatan)
                ->where('name', 'like', '%' . $r->key . '%')
                ->where('role', 5)->withCount(['antri' => function ($q) {
                    $q->where('status', 1);
                }])->with('spesialis_detail')->with('provinsi')->with('kota')->with('kecamatan')->orderBy('antri_count', 'desc')->get();
        } else {
            $dokter = Dokter::with(['jadwal' => function ($q) { }])
                ->where('id_province', $r->provinsi)
                ->where('id_city', $r->kota)
                ->where('name', 'like', '%' . $r->key . '%')
                ->where('role', 5)->withCount(['antri' => function ($q) {
                    $q->where('status', 1);
                }])->with('spesialis_detail')->with('provinsi')->with('kota')->with('kecamatan')->orderBy('antri_count', 'desc')->get();
        }

        return $dokter;
    }
}
