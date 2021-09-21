<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Antri;
use App\Models\Dokter;
use App\Models\Persen;
use App\Models\TopUp;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    use ApiResponser;
    public function login(Request $request)
    {
        try {
            $credentials['username'] = $request->input('username');
            $credentials['password'] = $request->input('password');
            if (!Auth::attempt($credentials))
                return $this->error('Unauthorized', 401);
            return $this->success(
                Dokter::where('username', $request->input('username'))->first()
            );
        } catch (\Exception $error) {

            return $this->error($error->getMessage(), 500);
        }
    }

    public function antrianNakes($id, $tgl)
    {
        $antri = Antri::where('dokter', $id)->where('tgl', $tgl)->with(['waktu_detail'])->orderBy('tgl', 'desc')->orderBy('dJam')->orderBy('no_antrian')->orderBy('status')->get();
        return $this->success(
            $antri
        );
    }

    public function antrianSelesai(Request $request)
    {
        $idantri = $request->id_antri;
        $iddokter = $request->id_dokter;
        $catatan = $request->catatan;

        $dokter = Dokter::where('id', $iddokter)->first();
        $persen = Persen::first();
        $antri =  Antri::where('id',  $idantri)->first();

        Antri::where('id', $idantri)
            ->update(["status" => 1, "catatan_dokter" => $catatan, "selesai_at" => date('Y-m-d H:i:s')]);

        //input potongan dokter
        TopUp::create([
            // "session_id" => $res['Data']['SessionID'],
            "trx_id" => '-',
            "dokter" => $iddokter,
            "jumlah" => $persen['nilai'],
            "jumlah_admin" => $persen['nilai'] - (($persen['dokter'] / 100) * $persen['nilai']),
            "status" => 1,
            "jenis" => 0,
            "ket" => 'Menangani pasien',
            "pasien_id" => $idantri
        ]);

        //bonus parent to saldo add
        TopUp::create([
            // "session_id" => $res['Data']['SessionID'],
            "trx_id" => '-',
            "dokter" => $dokter['parent'],
            "jumlah" => ($persen['dokter'] / 100) * $persen['nilai'],
            "status" => 1,
            "jenis" => 1,
            "ket" => 'Bonus',
            "dari" => $dokter['username'],
            "pasien_id" => $idantri
        ]);

        $url = 'https://fcm.googleapis.com/fcm/send';
        $msg = [
            'title' => 'Pasien Selesai Ditangani!',
            'body' => $catatan,

        ];
        $extra = ["message" => $msg];
        $fcm = [
            // "to" => "dGQo-iteRVuwxFQ2aOyLmZ:APA91bFfbNGXvG98oSk--xn5NvqbfV8BGt5AlaYB-XayaVJpyldjYI1s_dPRYlYOnae0-JAZrr58PlN5YqggcPe8s5nrWFYWVN_39QpOHhddOxZ3UqIyPw9FoggjsmrI3tlsS548qC06",
            // "registration_ids" => $antri['notif_id'],
            "to" => $antri['notif_id'],
            "notification" => $msg,
            "data" => $extra
        ];
        $headers = [
            'Authorization: key=AAAAJjWldH0:APA91bH3gGJvWDe3U6DkR8P5hnqhc9h7xqM3LSY8q8vfzjDJNMPnbGqk-91KRZfpWmF4XvA89GEzht8NvNyN-MJVjnz9x9il8tyZpCTPd_f7AjdsoMqtjkWQbtwJ9WLr55VfuiXizDXY',
            'Content-Type: application/json'
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcm));
        $result = curl_exec($ch);
        curl_close($ch);

        return $this->success(
            'berhasil simpan'
        );
    }
}
