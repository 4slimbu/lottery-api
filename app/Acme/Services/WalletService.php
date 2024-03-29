<?php

namespace App\Acme\Services;

use App\Acme\Events\Registration\RoleForgotPasswordEvent;
use App\Acme\Models\WithdrawRequest;
use App\Acme\Resources\WalletResource;
use App\Acme\Resources\WithdrawRequestResource;
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

    public function handleTransaction(Wallet $wallet, $type, $amount, $service_charge = 0)
    {
        switch ($type) {
            case 'top-up':
                // top-up
                // When user top up, amount is added to usable_amount and total_amount is calculated with pending amount
                return $this->handleTopUpTransaction($wallet, $amount, $service_charge);
                break;
            case 'order':
                // order
                // When user buys lottery ticket, amount is deducted from usable_amount and total is recalculated
                return $this->handleOrderTransaction($wallet, $amount, $service_charge);
                break;
            case 'win':
                // win/refer
                // When user wins lottery, amount is added to withdrawable as well as usable and total is calculated
                return $this->handleWinTransaction($wallet, $amount, $service_charge);

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

    public function handleTopUpTransaction(Wallet $wallet, $amount, $service_charge)
    {
        // Do transaction
        $transaction = WalletTransaction::create([
            'transaction_code' => str_random(18),
            'wallet_id' => $wallet->id,
            'type' => 'top-up',
            'amount' => $amount,
            'service_charge' => $service_charge
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

        // return wallet transaction id
        return $transaction->id;
    }

    public function handleWinTransaction($wallet, $amount, $service_charge)
    {

        // Do transaction
        $transaction = WalletTransaction::create([
            'transaction_code' => str_random(18),
            'wallet_id' => $wallet->id,
            'type' => 'win',
            'amount' => $amount,
            'service_charge' => $service_charge
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

        // return wallet transaction id
        return $transaction->id;
    }

    public function handleOrderTransaction(Wallet $wallet, $amount, $service_charge)
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
            'amount' => $amount,
            'service_charge' => $service_charge
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

        // return wallet transaction id
        return $transaction->id;
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

    public function getWithdrawRequests($input)
    {
        if (! $this->currentUserCan('getWithdrawRequests')) {
            return $this->respondWithNotAllowed();
        }

        $query = WithdrawRequest::filter($input);

        $withdrawRequests = $query->paginate($input['limit'] ?? 15);
        return WithdrawRequestResource::collection($withdrawRequests);
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

    public function updateMultipleWithdrawRequest($input)
    {
        if (!$this->currentUserCan('updateWithdrawRequest')) {
            return $this->respondWithNotAllowed();
        }

        $withdrawRequestIds = $input['withdraw_request_ids'];
        unset($input['withdraw_request_ids']);

        WithdrawRequest::whereIn('id', $withdrawRequestIds)->update($input);

        $withdrawRequests = WithdrawRequest::whereIn('id', $withdrawRequestIds)->get();

        foreach ($withdrawRequests as $withdrawRequest) {
            // When withdraw request has been completed
            if ($withdrawRequest->status === 'completed') {
                // Remove pending withdraw amount as it has been withdrawn
                $wallet = $withdrawRequest->user->wallet;
                $wallet->pending_withdraw = 0;
                $wallet->save();

                // Create transaction
                $transaction = WalletTransaction::create([
                    'transaction_code' => str_random(18),
                    'wallet_id' => $wallet->id,
                    'type' => 'withdraw',
                    'amount' => $withdrawRequest->amount,
                    'service_charge' => 0
                ]);

                // notify
                event(new WalletTransactionEvent($transaction));
            }

            // When withdraw request has been completed
            if ($withdrawRequest->status === 'failed') {
                // Remove pending withdraw amount and add it back to won amount
                $wallet = $withdrawRequest->user->wallet;
                $wallet->won = $wallet->won + $wallet->pending_withdraw;
                $wallet->pending_withdraw = 0;
                $wallet->save();
            }
        }
    }

    public function destroyWithdrawRequest()
    {

    }

    public function destroyMultipleWithdrawRequest()
    {

    }

}