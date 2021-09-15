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

        info('called every minute');
        $url = 'https://fcm.googleapis.com/fcm/send';
        $msg = [
            'title' => 'Update Antrian!',
            'body' => 'ini dari Job',

        ];
        $extra = ["message" => $msg];
        $fcm = [
            "to" => 'cly3n-KZTzmWaarbZf_8ar:APA91bFyZSdzzhz1mwlQYDKM6Xn623VdIboaEFW2qGyDLqcJmBTk-SA9D-nO12_rwGc9wflVTnDy5NRPl31hmJfMloWd73BaihkzTqyGsqshDqiGbq4WU1fbMXAsCtI1QnSm3VHzwhU6',
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
