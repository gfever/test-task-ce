<?php

namespace App\Console\Commands;

use App\Models\Cash;
use App\Prizes\Prize;
use Illuminate\Console\Command;

class SendAcceptedCashPrizes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prize:cash:withdrawal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Withdrawal cah prizes';

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
        resolve(Cash::class)->where('status', '=', Prize::PRIZE_STATUS_ACCEPTED)->orderBy('id')
            ->chunk(10, function ($prizes) {
                /** @var Cash $prize */
                foreach ($prizes as $prize) {
                    $this->info("Process prize id {$prize->id}");
                    $prize->updateStatus(Prize::PRIZE_STATUS_WITHDRAWAL);
                }
            });
    }
}
