<?php

namespace App\Acme\Services;

use App\Acme\Events\Registration\RoleForgotPasswordEvent;
use App\Acme\Exceptions\ServerErrorException;
use App\Acme\Models\LotterySlot;
use App\Acme\Models\PasswordReset;
use App\Acme\Models\Role;
use App\Acme\Models\RoleEmailReset;
use App\Acme\Resources\LotterySlotResource;
use App\Acme\Resources\Core\RoleResource;
use App\Acme\Traits\ApiResponseTrait;
use App\Acme\Traits\PermissionTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;

class WalletService extends ApiServices
{
    use ApiResponseTrait, PermissionTrait;

    /*
     * ========================================
     * Wallets
     * ========================================
     */

    public function getWallets()
    {

    }

    public function showWallet()
    {

    }

    public function createWallet()
    {

    }

    public function updateWallet()
    {

    }

    public function destroyWallet()
    {

    }

    /*
     * =======================================
     * Transactions
     * =======================================
     */

    public function getTotalAmount($input)
    {
    }

    public function getUsableAmount()
    {

    }

    public function getWithdrawableAmount()
    {

    }

    public function getPendingWithdrawAmount()
    {

    }

    public function handleTransaction($type, $amount)
    {
        // top-up
        // When user top up, amount is added to usable_amount and total_amount is calculated with pending amount

        // order
        // When user buys lottery ticket, amount is deducted from usable_amount and total is recalculated

        // win/refer
        // When user wins lottery, amount is added to withdrawable as well as usable and total is calculated

        // withdraw
        // When user apply for withdraw request amount is deducted from usable and added to pending, total remains same
        // When user withdraw, amount is removed from pending and total is recalculated
        // also if withdrawable amount is greater than usable_amount, it is resynced
    }

    public function handleTopUpTransaction()
    {

    }

    public function handleWinTransaction()
    {

    }

    public function handleOrderTransaction()
    {

    }

    public function handleReferTransaction()
    {

    }

    public function handleRefundTransaction()
    {

    }

    public function handleWithdrawTransaction()
    {

    }


    /*
     * ==============================================
     * Withdraw
     * ==============================================
     */

    public function getWithdrawRequests()
    {

    }

    public function showWithdrawRequest()
    {

    }

    public function createWithdrawRequest($amount, $user)
    {

    }

    public function updateWithdrawRequest()
    {

    }

    public function updateMultipleWithdrawRequest()
    {

    }

    public function destroyWithdrawRequest()
    {

    }

    public function destroyMultipleWithdrawRequest()
    {

    }

}