<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class ListenForReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:listen-for-reservations';
    // protected $signature = 'reservations:listen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Listen for new reservations via Redis channel';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Listening for reservations on channel: Rereservation.crerated...');
        Redis::connection()->subscribe(['Rereservation.crerated'], function ($message) {
            $this->info("📢 پیام جدید از Redis: {$message}");
        });
    }
}
