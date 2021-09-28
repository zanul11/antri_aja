<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class HelloWorldCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hello:world';

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
        // $daftar_antrian = Antri::select('notif_id')->get()->pluck('notif_id');
        $data = DB::select('select * from antri where tgl >= DATE_ADD(CURRENT_DATE, INTERVAL - 2 DAY) group by dokter');
        foreach ($data as $dt) {
            $dokter = Dokter::where('id', $dt->dokter)->first();
            if (isset($dokter['pagi'])) {
                $antrian = Antri::where('tgl', '>=', DB::raw('DATE_ADD(CURRENT_DATE, INTERVAL - 2 DAY)'))->where('dokter', $dokter['id'])->pluck('notif_id');
                //kirim notif
            }
        }

        info('called every jam 12');
        $url = 'https://fcm.googleapis.com/fcm/send';
        $msg = [
            'title' => 'Update Antrian!',
            'body' => 'ini dari Job setiap jam 12',

        ];
        $extra = ["message" => $msg];
        $fcm = [
            "to" => 'fHUx8fKZQ7WDDdG7MQEgeN:APA91bGRu2FrXdHlibKZ2vToWECWIV9jVEjjmYS4jwdGFC7JNz_crybK5bCzLzGn9jclyMWpeP0LKUXQpim7Ahz2C2ovxJNA915m33guRLGJ5xB8UlDzoMQveUZIVTbsRVH6StD3ESmW',
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
        return 0;
    }
}
