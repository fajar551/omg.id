<?php

namespace App\Console\Commands;

use App\Src\Services\Eloquent\ContentSubscribeService;
use App\Src\Services\Eloquent\SupportService;
use App\Src\Services\Eloquent\UpdatePendingBalanceService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CronBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:amountactivate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Amount Activated!';

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
        $this->info('Starting activate amount balance!');
        
        // Log::info("Cron amount activate working! ");
        UpdatePendingBalanceService::getInstance()->updatebalance();
        SupportService::getInstance()->updateexpiredpayment();
        ContentSubscribeService::getInstance()->updatestatus();
        // Log::info("Cron content subscribe working! ");

        $this->info('Activate amount balance finish!');
    }
}
