<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Antri;
use App\Models\Dokter;
use App\Models\Jadwal;
use App\Models\Notif;
use App\Models\Persen;
use App\Models\Pesan;
use App\Models\RequestTable;
use App\Models\Spesialis;
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
            if (!Auth::attempt($credentials)) {
                return $this->error('Unauthorized', 401);
            } else {
                Dokter::where('username', $request->input('username'))->update(['api_key' => $request->input('api_key')]);
                return $this->success(
                    Dokter::where('username', $request->input('username'))->with('spesialis_detail')->with('provinsi')->with('kota')->with('kecamatan')->first()
                );
            }
        } catch (\Exception $error) {

            return $this->error($error->getMessage(), 500);
        }
    }

    public function antrianNakes($id, $tgl)
    {
        $antri = Antri::with('dokter_detail')->where('status', 0)->where('dokter', $id)->where('tgl', $tgl)->with(['waktu_detail'])->orderBy('tgl', 'desc')->orderBy('dJam')->orderBy('no_antrian')->orderBy('status')->get();
        return $this->success(
            $antri
        );
    }

    public function antrianDitanganiNakes($id, $tgl)
    {
        $antri = Antri::with('dokter_detail')->where('status', 1)->where('dokter', $id)->where('tgl', $tgl)->with(['waktu_detail'])->orderBy('tgl', 'desc')->orderBy('dJam')->orderBy('no_antrian')->orderBy('status')->get();
        return $this->success(
            $antri
        );
    }


    public function antrianNotif(Request $request)
    {
        $iddokter = $request->id_dokter;
        $idantri = $request->id_antri;

        $pasien = Antri::where('dokter', $iddokter)->where('status', 1)->count();
        $saldo = TopUp::where('dokter', $iddokter)->where('status', 1)->sum('jumlah');
        $pesan = Pesan::where('dokter', $iddokter)->first();
        $dokter = Dokter::where('id', $request->id_dokter)->first();

        if (($saldo - ($pasien * 2000)) < 2000) {
            return $this->success(
                null,
                'Saldo Kurang!'
            );
        } else {

            $antri = Antri::with('waktu_detail')->where('dokter', $iddokter)->where('id', $idantri)->first();

            Notif::create([
                "user" => $antri['no_hp'],
                "type" => 1,
                "dari" => $dokter['name'],
                "isi" => 'Antrian No. ' . $antri['no_antrian'] .  ', atas nama ' . $antri['pasien'] . ' sedang ditangani. Silahkan bersiap untuk nomor antrian berikutnya!',
                'judul' => 'Update Antrian'
            ]);

            $daftar_antrian = Antri::select('notif_id')->where('dokter', $iddokter)->where('tgl', $antri['tgl'])->where('waktu', $antri['waktu'])->get()->pluck('notif_id');

            $url = 'https://fcm.googleapis.com/fcm/send';
            $msg = [
                'title' => 'Update Antrian!',
                'body' => 'Antrian No. ' . $antri['no_antrian'] .  ', atas nama ' . $antri['pasien'] . ' sedang ditangani. Silahkan bersiap untuk nomor antrian berikutnya!',

            ];
            $extra = ["message" => $msg];
            $fcm = [
                "registration_ids" =>  $daftar_antrian,
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
                null,
                (isset($pesan['pesan'])) ? $pesan['pesan'] : '-'
            );
        }
    }

    public function antrianSelesai(Request $request)
    {
        $idantri = $request->id_antri;
        $iddokter = $request->id_dokter;
        $catatan = $request->catatan;

        $dokter = Dokter::where('id', $iddokter)->first();
        $persen = Persen::first();
        $antri =  Antri::where('id',  $idantri)->first();

        Notif::create([
            "user" => $antri['no_hp'],
            "type" => 1,
            "dari" => $dokter['name'],
            "isi" => 'Pasien Selesai Ditangani! \n' . $catatan,
            'judul' => 'Update Antrian'
        ]);

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

    public function getSaldo($id)
    {
        $kredit = TopUp::where('dokter', $id)->where('status', 1)->where('jenis', 0)->sum('jumlah');
        $saldo = TopUp::where('dokter', $id)->where('status', 1)->where('jenis', 1)->sum('jumlah');
        return $this->success(
            $saldo - $kredit
        );
    }

    public function getHistori($id)
    {
        $his = TopUp::where('dokter', $id)->where('ket', 'Top Up')->get();
        return $this->success(
            $his
        );
    }

    public function generatePembayaran(Request $request)
    {

        $dokter = Dokter::where('id', $request->id_user)->first();
        //production
        // $va           = '1179001227977474';
        // $secret       = 'BE93365D-9A7A-469F-B34D-7B96EA454568';
        //sandbox dev
        $va           = '1179002340758828';
        $secret       = '2BC8D477-98DC-414F-9DC1-8D9B7B9C9CDA';

        // $url          = 'https://sandbox.ipaymu.com/api/v2/payment'; //redirect
        $url          = 'https://sandbox.ipaymu.com/api/v2/payment/direct';
        // $url          = 'https://my.ipaymu.com/api/v2/payment/direct'; //direct
        $method       = 'POST'; //method

        $generateUid =  substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 9);
        //Request Body//
        $body['product']    = array('Top Up Saldo Antri Aja');
        $body['qty']        = array('1');
        $body['price']      = array($request->jumlah);
        // $body['amount']     = $request->jumlah;
        $body['returnUrl']  = url('/') . '/topup-success';
        $body['cancelUrl']  = url('/') . '/saldo';
        $body['notifyUrl']  = url('/') . '/ipaymu-success';
        $body['name']  = $dokter['name'];
        $body['email']  = $dokter['email'];
        $body['phone']  = (isset($dokter['no_hp'])) ? $dokter['no_hp'] : '082242424300';

        //khusus direct
        $body['paymentMethod']  = $request->metode;
        $body['paymentChannel']  = $request->paymentChannel;
        $body['amount']     = $request->jumlah;

        //End Request Body//

        //Generate Signature
        // *Don't change this
        $jsonBody     = json_encode($body, JSON_UNESCAPED_SLASHES);
        $requestBody  = strtolower(hash('sha256', $jsonBody));
        $stringToSign = strtoupper($method) . ':' . $va . ':' . $requestBody . ':' . $secret;
        $signature    = hash_hmac('sha256', $stringToSign, $secret);
        $timestamp    = Date('YmdHis');
        //End Generate Signature

        // return $signature . ' - ' . $timestamp;


        $ch = curl_init($url);

        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
            'va: ' . $va,
            'signature: ' . $signature,
            'timestamp: ' . $timestamp
        );

        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_POST, count($body));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $err = curl_error($ch);
        $ret = curl_exec($ch);
        curl_close($ch);
        // header('Location: https://www.facebook.com/');
        if ($err) {
            // echo $err;
            return $this->error(
                'error',
                400
            );
        } else {
            $res = json_decode($ret, true);
            if ($res['Status'] == 200) {
                TopUp::create([
                    // "session_id" => $res['Data']['SessionID'],
                    "trx_id" => $res['Data']['TransactionId'],
                    "dokter" => $request->id_user,
                    "jumlah" => $request->jumlah,
                    "uid" => $generateUid,
                    "fee" => $res['Data']['Fee'],
                    "metode" => $request->metode,
                    "channel" => $request->paymentChannel
                ]);
                return $this->success(
                    $res
                );
            } else {
                return $this->error(
                    $res['Message'],
                    400
                );
            }
        }
    }


    public function getJadwal($id, $waktu)
    {
        $jadwal = Jadwal::where('id_user', $id)->where('hari', $waktu)->orderBy('dJam')->get();
        return $jadwal;
    }

    public function addJadwal(Request $request)
    {
        Jadwal::create([
            "id_user" => $request->id_dokter,
            "hari" => $request->hari,
            "dJam" => $request->dJam,
            "sJam" => $request->sJam,
            "estimasi" => $request->estimasi,
            "kuota" => $request->kuota
        ]);
        return $this->success(
            'berhasil simpan'
        );
    }


    public function deleteJadwal($id)
    {
        Jadwal::where('id', $id)->delete();
        return $this->success(
            'berhasil hapus'
        );
    }

    public function getNotif($user)
    {
        $notif = Notif::where('user', $user)->orwhere('user', 'Broadcast')->orderBy('created_at', 'desc')->get();
        return $notif;
    }

    public function getSpesialisasi()
    {
        $notif = Spesialis::orderBy('spesialis')->get();
        return $notif;
    }

    public function cariSpesialisasi(Request $r)
    {
        $notif = Spesialis::where('spesialis', 'like', '%' . $r->key . '%')->orderBy('spesialis')->get();
        return $notif;
    }


    public function updateNotif($id)
    {
        $notif = Notif::where('id', $id)->update(['is_read' => 1]);
        return $this->success(
            'berhasil update'
        );
    }

    public function addRequest(Request $request)
    {
        $iddokter = $request->id_dokter;
        $jumlah = $request->jumlah;
        $dokter = Dokter::where('id', $iddokter)->first();
        // return $dokter['email'];
        RequestTable::create([
            "faskes" => $dokter['email'],
            "nakes" => $iddokter,
            "request" => $jumlah,
        ]);
        return $this->success(
            'berhasil tambah'
        );
    }

    public function getRequest($id)
    {
        $req = RequestTable::where('nakes', $id)->orderBy('created_at', 'desc')->get();
        return $req;
    }

    public function detailNakes($id)
    {
        return $antri = Dokter::where('id', $id)->with('faskes')
            ->with('jadwal')->with('spesialis_detail')->with('provinsi')->with('kota')->with('kecamatan')->first();
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $path = public_path() . '/uploads/';
            $foto = $request->nama . '.' . $image->getClientOriginalExtension();

            if (!$image->move($path, $foto)) {
                $success = false;
                $message = "Error while uploading!";
            } else {
                $success = true;
                $message = "Successfully Uploaded";
            }
        } else {
            $success = false;
            $message = "Error while uploading!";
        }
        $response["success"] = $success;
        $response["message"] = $message;
        return $response;
    }

    public function updateProfile(Request $request)
    {
        $iddokter = $request->id_dokter;
        $nama = $request->nama;
        $spesialis = $request->spesialis;
        $deskripsi = $request->deskripsi;
        $alamat = $request->alamat;
        $no_hp = $request->no_hp;
        $pengalaman = $request->pengalaman;
        $foto = $request->foto;

        Dokter::where('id', $iddokter)
            ->update([
                "name" => $nama,
                "spesialis" => $spesialis,
                "deskripsi" => $deskripsi,
                "alamat" => $alamat,
                "no_hp" => $no_hp,
                "pengalaman" => $pengalaman,
                "foto" => $foto,
            ]);
        return $this->success(
            'berhasil update'
        );
    }
    public function updateProfileNoFoto(Request $request)
    {
        $iddokter = $request->id_dokter;
        $nama = $request->nama;
        $spesialis = $request->spesialis;
        $deskripsi = $request->deskripsi;
        $alamat = $request->alamat;
        $no_hp = $request->no_hp;
        $pengalaman = $request->pengalaman;

        Dokter::where('id', $iddokter)
            ->update([
                "name" => $nama,
                "spesialis" => $spesialis,
                "deskripsi" => $deskripsi,
                "alamat" => $alamat,
                "no_hp" => $no_hp,
                "pengalaman" => $pengalaman,

            ]);
        return $this->success(
            'berhasil update'
        );
    }
}
