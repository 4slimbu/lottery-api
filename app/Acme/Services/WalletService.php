<?php

namespace App\Acme\Services;

use App\Acme\Events\Registration\RoleForgotPasswordEvent;
use App\Acme\Resources\WalletResource;
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

    public function getWallets($input)
    {
        if (! $this->currentUserCan('getWallets')) {
            return $this->respondWithNotAllowed();
        }

        $query = Wallet::filter($input);

        $lotterySlots = $query->paginate($input['limit'] ?? 15);
        return WalletResource::collection($lotterySlots);
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
        $wallet->update([
            'deposit' => $wallet->deposit * 1 + $amount * 1,
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
        $wallet->update([
            'won' => $wallet->won * 1 + $amount * 1,
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        // Fire wallet transaction event
        event(new WalletTransactionEvent($transaction));
    }

    public function handleOrderTransaction(Wallet $wallet, $amount)
    {
        // Check wallet and see if it meets the entry value
        if (! $wallet->deposit > $amount) {
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
        $wallet->update([
            'deposit' => $wallet->deposit * 1 - $amount,
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