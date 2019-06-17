<?php

namespace App\Jobs;

use App\Acme\Models\User;
use App\Acme\Services\LotteryService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class AddParticipant implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $lotteryService;
    protected $user;

    /**
     * Create a new job instance.
     * @param LotteryService $lotteryService
     * @param User $user
     */
    public function __construct(LotteryService $lotteryService, User $user)
    {
        $this->lotteryService = $lotteryService;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->lotteryService->addParticipantToActiveLotterySlot($this->user->id);
    }
}
