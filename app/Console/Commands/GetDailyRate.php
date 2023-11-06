<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GetDailyRate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-daily-rate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieve daily currency rates';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        app('App\Http\Controllers\CurrencyController')->getDailyRate();
    }
}
