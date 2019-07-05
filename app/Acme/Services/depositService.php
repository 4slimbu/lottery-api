<?php

namespace App\Acme\Services;

use App\Acme\Events\Registration\RoleForgotPasswordEvent;
use App\Acme\Models\Deposit;
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

class DepositService extends ApiServices
{
    use ApiResponseTrait, PermissionTrait;

    public function create()
    {
        return Deposit::create([
            'user_id' => auth()->user()->id,
            'wallet_id' => auth()->user()->wallet->id,
        ]);
    }

    public function update(Deposit $deposit, $input)
    {
        $data = [];
        if (isset($input['amount'])) {
            $data['amount'] = $input['amount'];
        }
        if (isset($input['charge_code'])) {
            $data['charge_code'] = $input['charge_code'];
        }
        if (isset($input['status'])) {
            $data['status'] = $input['status'];
        }
        return $deposit->update($data);
    }
}