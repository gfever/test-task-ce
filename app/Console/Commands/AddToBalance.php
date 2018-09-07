<?php

namespace App\Console\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;

class AddToBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'balance:add {amount}';

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
     * @return mixed
     */
    public function handle()
    {
        \assert(is_numeric($this->argument('amount')));
        Setting::where('name', '=', Setting::BALANCE_SETTING_NAME)->update(['value' => Setting::getBalance() + $this->argument('amount')]);

        $this->info('New balance ' . Setting::getBalance());
    }
}
