<?php

namespace App\Events;

use App\Acme\Models\WalletTransaction;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;

class WalletTransactionEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $walletTransaction;
    public $user;
    /**
     * Create a new event instance.
     * @param WalletTransaction $walletTransaction
     */
    public function __construct(WalletTransaction $walletTransaction)
    {
        $this->walletTransaction = $walletTransaction;
        $this->user = $walletTransaction->wallet->user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
//        return new PrivateChannel('App.User.' . $this->user->id);
    }

    public function broadcastWith()
    {
        return [
            'data' => 'Wallet Transaction Event'
        ];
    }
}
