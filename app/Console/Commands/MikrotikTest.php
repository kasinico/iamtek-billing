<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use RouterOS\Client;
use RouterOS\Query;



class MikrotikTest extends Command
{
    protected $signature = 'mikrotik:test';
    protected $description = 'Test MikroTik Router API connection';

    public function handle()
    {
        $client = new Client([
            'host' => '192.168.100.1',
            'user' => 'iamtek',
            'pass' => 'admin',
            'port' => 8728,
            'legacy' => true
        ]);

        $query = new Query('/system/identity/print');

        $response = $client->query($query)->read();

        print_r($response);
    }
}



// ======================================================================
// #[Signature('app:mikrotik-test')]
// #[Description('Command description')]

// #[Signature('mikrotik:test')]
// #[Description('Test MikroTik Router API connection')]
// class MikrotikTest extends Command
// {
//     /**
//      * Execute the console command.
//      */
//     public function handle()
    
//         //
//     {
//         $client = new Client([
//             'host' => '192.168.100.1',
//             'user' => 'admin',
//             'pass' => 'fROsw@Ve8Is&A6&trUWR',
//             'port' => 8728,
//         ]);

//         $query = new Query('/system/identity/print');

//         $response = $client->query($query)->read();

//         print_r($response);
//     }
// }
