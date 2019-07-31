<?php

namespace App\Acme\Services;

use App\Acme\Models\LotterySlotUser;
use App\Acme\Models\User;
use App\Acme\Models\UserEmailReset;
use App\Acme\Models\WalletTransaction;
use App\Acme\Models\WithdrawRequest;
use App\Acme\Resources\Core\UserResource;
use App\Acme\Resources\LotterySlotUserResource;
use App\Acme\Resources\WalletTransactionResource;
use App\Acme\Resources\WithdrawRequestResource;
use App\Acme\Traits\ApiResponseTrait;
use App\Acme\Traits\MediaUploadTrait;
use App\Events\UserUpdateEvent;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class MeService extends ApiServices
{
    use ApiResponseTrait, MediaUploadTrait;

    public function getMyDetails()
    {
        return new UserResource(auth()->user());
    }

    public function updateMyPreferences($input)
    {
        $user = auth()->user();
        $user->fill(["preferences" => $input['preferences']]);
        $user->save();
        return new UserResource($user);
    }

    public function updateMyDetails($input)
    {
        $user = auth()->user();
        $user->fill($input);

        if (!empty($input['password'])) {
            $user->password = bcrypt($input['password']);
        }

        $user->save();

        // Add media to user
        if (isset($input['profile_picture'])) {
            $this->saveProfilePicture($user, $input['profile_picture']);
        }

        return new UserResource($user->fresh());
    }

    public function updateMyEmail($input)
    {
        $user = auth()->user();

        if ($user->email === $input['email']) {
            return $this->respondWithNotAllowed('You can not set your own email', 'OwnEmailNotAllowedException')->setStatusCode(400);
        }

        $checkUser = User::email($input['email'])->first();
        if (!empty($checkUser)) {
            return $this->respondWithError('User already exists.', 'UserExistsException')->setStatusCode(400);
        }

        $token = str_random('60');

        UserEmailReset::where('user_id', $user->id)->delete();

        $user->emailReset()->create([
            'email' => $input['email'],
            'token' => $token,
        ]);

//        event(new UserUpdatedEmailEvent($user, $token, $input['email']));

        return [
            'data' => [
                'token' => $token,
            ],
        ];
    }

    public function resetMyPassword($input)
    {
        $user = auth()->user();
        if (!Hash::check($input['old_password'], $user->password)) {
            return $this->respondWithError('Password does not match', 'PasswordDoesntMatchException')->setStatusCode(400);
        }

        $user->password = bcrypt($input['new_password']);
        $user->save();

        return new UserResource($user);
    }

    public function play($inputs)
    {
        $user = auth()->user();
        $lotteryService = new LotteryService();

        return $lotteryService->addParticipantToActiveLotterySlot($user->id, true, $inputs);
    }

    public function getPlayedGames($inputs)
    {
        $user = auth()->user();

        $playedGames = LotterySlotUser::where('user_id', $user->id)->paginate($inputs['limit'] ?? 15);
        $playedGames->load('lotterySlot');

        return LotterySlotUserResource::collection($playedGames);
    }

    public function getTransactions($inputs)
    {
        $user = auth()->user();

        $walletTransactions = WalletTransaction::where('wallet_id', $user->wallet->id)->paginate($inputs['limit'] ?? 15);

        return WalletTransactionResource::collection($walletTransactions);
    }

    public function createWithdrawRequest($input)
    {
        $user = auth()->user();

        if ($user->wallet->won < $input['amount']) {
            return $this->respondWithError('Insufficient balance', 'InsufficientBalance')->setStatusCode(400);
        };

        $pendingWithdrawRequest = WithdrawRequest::where('user_id', $user->id)
            ->where('status', 'pending')->orWhere('status', 'processing')->first();

        if ($pendingWithdrawRequest) {
            return $this->respondWithError('Pending Withdraw request already exist', 'PendingWithdrawRequestExists')->setStatusCode(400);
        };

        $input['user_id'] = $user->id;

        $withdrawRequest = new WithdrawRequest();
        $withdrawRequest->fill($input);
        $withdrawRequest->save();

        // Deduct withdraw request amount from won amount and put it in withdraw request amount in Wallet
        $wallet = $user->wallet;
        $wallet->won = $wallet->won - $input['amount'];
        $wallet->pending_withdraw = $input['amount'];
        $wallet->save();

        return new WithdrawRequestResource($withdrawRequest);
    }

    public function cancelWithdrawRequest($withdrawRequestId)
    {
        $user = auth()->user();

        $withdrawRequest = WithdrawRequest::where('user_id', $user->id)->where('id', $withdrawRequestId)->first();

        if (! $withdrawRequest) {
            return $this->respondNotFound();
        }

        $withdrawRequest->status = "cancelled";
        $withdrawRequest->save();

        // Restore pending amount to won amount in wallet
        $wallet = $user->wallet;
        $wallet->won = $wallet->won + $wallet->pending_withdraw;
        $wallet->pending_withdraw = 0;
        $wallet->save();

        return new WithdrawRequestResource($withdrawRequest);
    }

    public function getWithdrawRequests($inputs)
    {
        $user = auth()->user();

        $walletTransactions = WithdrawRequest::where('user_id', $user->id)->paginate($inputs['limit'] ?? 15);

        return WithdrawRequestResource::collection($walletTransactions);
    }
}