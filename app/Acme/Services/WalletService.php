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

    public function handleTransaction(Wallet $wallet, $type, $amount)
    {
        switch ($type) {
            case 'top-up':
                // top-up
                // When user top up, amount is added to usable_amount and total_amount is calculated with pending amount
                return $this->handleTopUpTransaction($wallet, $amount);
                break;
            case 'order':
                // order
                // When user buys lottery ticket, amount is deducted from usable_amount and total is recalculated
                return $this->handleOrderTransaction($wallet, $amount);
                break;
            case 'win':
                // win/refer
                // When user wins lottery, amount is added to withdrawable as well as usable and total is calculated
                return $this->handleWinTransaction($wallet, $amount);

                break;
            case 'withdraw':
                // withdraw
                // When user apply for withdraw request amount is deducted from usable and added to pending, total remains same
                // When user withdraw, amount is removed from pending and total is recalculated
                // also if withdrawable amount is greater than usable_amount, it is resynced
                break;
            default:
                break;
        }
    }

    public function handleTopUpTransaction(Wallet $wallet, $amount)
    {
        // Do transaction
        $transaction = WalletTransaction::create([
            'transaction_code' => str_random(18),
            'wallet_id' => $wallet->id,
            'type' => 'top-up',
            'amount' => $amount
        ]);

        if (! $transaction) {
            return $this->setStatusCode(400)->respondWithError('Transaction Failed', 'transactionFailed');
        }

        // Sync Wallet
        // top up should be added to usable amount
        $usable_amount = $wallet->usable_amount + $amount;
        // withdrawable amount is unaffected
        $withdrawable_amount = $wallet->withdrawable_amount;
        // pending withdraw amount is unaffected
        $pending_withdraw_amount = $wallet->pending_withdraw_amount;
        // topup amount is sum of new usable amount plus pending withdraw amount
        $total_amount = $pending_withdraw_amount + $usable_amount;

        $wallet->update([
            'withdrawable_amount' => $withdrawable_amount,
            'pending_withdraw_amount' => $pending_withdraw_amount,
            'usable_amount' => $usable_amount,
            'total_amount' => $total_amount,
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        // Fire wallet transaction event
        event(new WalletTransactionEvent($transaction));
    }

    public function handleWinTransaction($wallet, $amount)
    {

        // Do transaction
        $transaction = WalletTransaction::create([
            'transaction_code' => str_random(18),
            'wallet_id' => $wallet->id,
            'type' => 'win',
            'amount' => $amount
        ]);

        if (! $transaction) {
            return $this->setStatusCode(400)->respondWithError('Transaction Failed', 'transactionFailed');
        }

        // Sync Wallet
        // won amount should be added to usable_amount
        $usable_amount = $wallet->usable_amount + $amount;
        // won amount is available for withdraw
        $withdrawable_amount = $wallet->withdrawable_amount + $amount;
        $pending_withdraw_amount = $wallet->pending_withdraw_amount;
        $total_amount = $pending_withdraw_amount + $usable_amount;

        $wallet->update([
            'withdrawable_amount' => $withdrawable_amount,
            'pending_withdraw_amount' => $pending_withdraw_amount,
            'usable_amount' => $usable_amount,
            'total_amount' => $total_amount,
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        // Fire wallet transaction event
        event(new WalletTransactionEvent($transaction));
    }

    public function handleOrderTransaction(Wallet $wallet, $amount)
    {
        // Check wallet and see if it meets the entry value
        if (! $wallet->usable_amount > $amount) {
            return $this->setStatusCode(400)->respondWithError('Insufficient Fund', 'insufficientFund');
        }

        // Do transaction
        $transaction = WalletTransaction::create([
            'transaction_code' => str_random(18),
            'wallet_id' => $wallet->id,
            'type' => 'order',
            'amount' => $amount
        ]);

        if (! $transaction) {
            return false;
//            return $this->setStatusCode(400)->respondWithError('Transaction Failed', 'transactionFailed');
        }

        // Sync Wallet
        // Entry fee should be deducted from usable amount
        $usable_amount = $wallet->usable_amount - $amount;
        // If usable amount drops below withdrawable amount, it should be synced
        $withdrawable_amount = $wallet->usable_amount >= $wallet->withdrawable_amount ? $wallet->withdrawable_amount : $wallet->usable_amount;
        $pending_withdraw_amount = $wallet->pending_withdraw_amount;
        $total_amount = $pending_withdraw_amount + $usable_amount;

        $wallet->update([
            'withdrawable_amount' => $withdrawable_amount,
            'pending_withdraw_amount' => $pending_withdraw_amount,
            'usable_amount' => $usable_amount,
            'total_amount' => $total_amount,
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        // Fire wallet transaction event
        event(new WalletTransactionEvent($transaction));
        return true;
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