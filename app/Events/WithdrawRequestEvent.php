<?php

namespace App\Events;

use App\Acme\Models\WalletTransaction;
use App\Acme\Models\WithdrawRequest;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;

class WithdrawRequestEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $withdraw_request;
    public $user;
    /**
     * Create a new event instance.
     * @param WithdrawRequest $withdraw_request
     */
    public function __construct(WithdrawRequest $withdraw_request)
    {
        $this->withdraw_request = $withdraw_request;
        $this->user = $withdraw_request->user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
//        return new PrivateChannel('App.User.' . $this->withdraw_request->user_id);
    }

    public function broadcastWith()
    {
        return [
            'data' => 'Withdraw Event'
        ];
    }
}
