<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClientCron extends Command
{
    protected $signature = 'client:cron';
    protected $description = 'Command description';
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        return 0;
    }
}
