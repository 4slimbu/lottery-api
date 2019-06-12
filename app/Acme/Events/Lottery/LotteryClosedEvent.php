<?php

namespace App\Acme\Events\Registration;

use App\Acme\Models\LotterySlot;
use App\Acme\Models\User;
use App\Acme\Resources\LotterySlotResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class LotteryClosedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $lotterySlot;

    /**
     * Create a new event instance.
     *
     * @param LotterySlot $lotterySlot
     */
    public function __construct(LotterySlot $lotterySlot)
    {
        $this->lotterySlot = $lotterySlot;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('lottery');
    }

    public function broadcastWith()
    {
        // return lottery slot info
        return [
            'data' => new LotterySlotResource($this->lotterySlot)
        ];
    }
}
