<?php

namespace App\Console\Commands;

use App\Acme\Models\Setting;
use App\Acme\Services\LotteryService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RunLottery extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lottery:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Lottery';

    protected $lotteryService;


    /**
     * Create a new command instance.
     *
     * @param LotteryService $lotteryService
     */
    public function __construct(LotteryService $lotteryService)
    {
        parent::__construct();

        $this->lotteryService = $lotteryService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->lotteryService->runLottery();
    }
}
