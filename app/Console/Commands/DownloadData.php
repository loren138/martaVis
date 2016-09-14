<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DownloadData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'download:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Downloads MARTA Data';

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
     * @return mixed
     */
    public function handle()
    {
        $urls = [
            'bus' => 'http://developer.itsmarta.com/BRDRestService/RestBusRealTimeService/GetAllBus',
            'train' => 'http://developer.itsmarta.com/RealtimeTrain/RestServiceNextTrain/GetRealtimeArrivals?apikey='.env('MARTA_API_KEY')
        ];

        $client = new \GuzzleHttp\Client();
        $dateString = date('Ymd-Hi');

        foreach ($urls as $k => $u) {
            $res = $client->request('GET', $u);
            $name = $k.$dateString.'.json';
            // Sometime later, we'll have to parse this data into a usable format
            \Storage::put($name, $res->getBody());
        }
    }
}
