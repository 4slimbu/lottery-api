<?php

namespace App\Events;

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

class LotterySlotResultGeneratedEvent implements ShouldBroadcast
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
        $winners = $this->whenLoaded('winners', function (){
            return $this->winners()->select('id', 'first_name', 'last_name', 'profile_pic')->get();
        });

        $data =  [
            'id' => (integer)$this->id,
            'slot_ref' => (string)$this->slot_ref,
            'start_time' => (string)$this->start_time,
            'end_time' => (string)$this->end_time,
            'has_winner' => (string)$this->has_winner,
            'total_participants' => (string)$this->total_participants,
            'total_amount' => (string)$this->total_amount,
            'result' => (array)$this->result,
            'status' => (string)$this->status,
            'winners' => $winners
        ];

        return [
            'result' => $data
        ];
    }
}
