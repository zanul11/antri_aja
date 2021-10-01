<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ReminderPagi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:pagi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data = DB::select('select * from antri where tgl >= DATE_ADD(CURRENT_DATE, INTERVAL - 2 DAY) group by dokter');
        foreach ($data as $dt) {
            $dokter = Dokter::where('id', $dt->dokter)->first();
            if (isset($dokter['pagi'])) {
                $daftar_antrian = Antri::where('tgl', '>=', DB::raw('DATE_ADD(CURRENT_DATE, INTERVAL - 2 DAY)'))->where('dokter', $dokter['id'])->get();
                foreach ($daftar_antrian as $ant) {
                    //kirim notif
                    Notif::create([
                        "user" => $ant['no_hp'],
                        "type" => 1,
                        "dari" => $dokter['name'],
                        "isi" => 'Hallo ' . $ant['pasien'] . ', ' . $dokter['pagi'],
                        'judul' => 'Reminder'
                    ]);
                    $url = 'https://fcm.googleapis.com/fcm/send';
                    $msg = [
                        'title' => 'Reminder',
                        'body' => 'Hallo ' . $ant['pasien'] . ', ' . $dokter['pagi'],
                    ];
                    $extra = ["message" => $msg];
                    $fcm = [
                        "to" => $ant['notif_id'],
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
                }
            }
        }
        return 0;
    }
}
