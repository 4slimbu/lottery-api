<?php

namespace App\Acme\Services;

use App\Acme\Events\Registration\RoleForgotPasswordEvent;
use App\Events\WalletTransactionEvent;
use App\Acme\Exceptions\ServerErrorException;
use App\Acme\Models\LotterySlot;
use App\Acme\Models\PasswordReset;
use App\Acme\Models\Role;
use App\Acme\Models\RoleEmailReset;
use App\Acme\Models\Setting;
use App\Acme\Models\Wallet;
use App\Acme\Models\WalletTransaction;
use App\Acme\Resources\LotterySlotResource;
use App\Acme\Resources\Core\RoleResource;
use App\Acme\Traits\ApiResponseTrait;
use App\Acme\Traits\PermissionTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Shakurov\Coinbase\Facades\Coinbase;

class CoinbaseService extends ApiServices
{
    use ApiResponseTrait, PermissionTrait;

    public $depositService;

    public function __construct(DepositService $depositService)
    {
        $this->depositService = $depositService;
    }

    public function createCharge()
    {
        $deposit = $this->depositService->create();

        $charge = Coinbase::createCharge([
            'name' => 'Deposit',
            'description' => 'Deposit amount to your Kryptto.io Wallet',
            'metadata' => [
                'deposit_id' => $deposit->id,
            ],
            'pricing_type' => 'no_price',
        ]);

        if ($charge) {
            $deposit->fill(['charge_code' => $charge['data']['code']])->save();
        }

        return $charge;
    }
}