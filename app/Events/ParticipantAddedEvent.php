<?php

namespace App\Events;

use App\Acme\Models\LotterySlot;
use App\Acme\Models\User;
use App\Acme\Resources\LotterySlotResource;
use App\Acme\Resources\LotterySlotUserResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ParticipantAddedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $lotterySlot;

    /**
     * Create a new event instance.
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
        return [
            "data" => [
                'id' => (integer)$this->lotterySlot->id,
                'slot_ref' => (string)$this->lotterySlot->slot_ref,
                'start_time' => (string)$this->lotterySlot->start_time,
                'end_time' => (string)$this->lotterySlot->end_time,
                'has_winner' => (string)$this->lotterySlot->has_winner,
                'total_participants' => (string)$this->lotterySlot->total_participants,
                'total_amount' => (string)$this->lotterySlot->total_amount,
                'result' => (array)$this->lotterySlot->result,
                'status' => (string)$this->lotterySlot->status,
            ]
        ];
    }
}
