<?php

namespace App\Acme\Services;

use App\Events\ParticipantAddedEvent;
use App\Events\LotterySlotClosedEvent;
use App\Events\LotterySlotCreatedEvent;
use App\Events\LotterySlotResultGeneratedEvent;
use App\Events\WalletTransactionEvent;
use App\Acme\Models\LotterySlot;
use App\Acme\Models\LotterySlotUser;
use App\Acme\Models\Setting;
use App\Acme\Models\User;
use App\Acme\Models\Wallet;
use App\Acme\Models\WalletTransaction;
use App\Acme\Resources\LotterySlotResource;
use App\Acme\Resources\LotterySlotUserResource;
use App\Acme\Traits\ApiResponseTrait;
use App\Acme\Traits\PermissionTrait;

class LotteryService extends ApiServices
{
    use ApiResponseTrait, PermissionTrait;

    protected $walletService;

    /**
     * Get lottery slots along with participants if with field is provided
     *
     * @param $input
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getLotterySlots($input)
    {
        if (! $this->currentUserCan('getLotterySlots')) {
            return $this->respondWithNotAllowed();
        }

        // If with=participants is present in request then load participants
        if ($input['with'] && $input['with'] === 'participants') {
            $query = LotterySlot::with('participants')->filter($input);
        } else {
            $query = LotterySlot::filter($input);
        }

        $lotterySlots = $query->paginate($input['limit'] ?? 15);
        return LotterySlotResource::collection($lotterySlots);
    }

    /**
     * Get single lottery slot
     *
     * Can get participants related to lottery slot if with field is present
     *
     * @param $input
     * @return LotterySlotResource|\Illuminate\Http\JsonResponse
     */
    public function showLotterySlot($input)
    {
        if (!$this->currentUserCan('getLotterySlots')) {
            return $this->respondWithNotAllowed();
        }

        // If user can get Participants
        if ($this->currentUserCan('getParticipants')) {
            // If with=participants is present in request then load participants
            if (isset($input['with']) && $input['with'] === 'participants') {
                $lotterySlot = LotterySlot::with('participants')->findOrFail($input['lottery_slot_id']);
            } else {
                $lotterySlot = LotterySlot::findOrFail($input['lottery_slot_id']);
            }
        } else {
            $lotterySlot = LotterySlot::findOrFail($input['lottery_slot_id']);
        }

        return new LotterySlotResource($lotterySlot);
    }

    public function updateLotterySlot()
    {
        if (!$this->currentUserCan('updateLotterySlot')) {
            return $this->respondWithNotAllowed();
        }
    }

    public function updateMultipleLotterySlot()
    {
        if (!$this->currentUserCan('updateMultipleLotterySlot')) {
            return $this->respondWithNotAllowed();
        }
    }

    public function destroyLotterySlot()
    {
        if (!$this->currentUserCan('destroyLotterySlot')) {
            return $this->respondWithNotAllowed();
        }
    }

    public function destroyMultipleLotterySlot()
    {
        if (!$this->currentUserCan('destroyMultipleLotterySlot')) {
            return $this->respondWithNotAllowed();
        }
    }

    /**
     * Create Lottery Slot
     *
     * Create only if all previous lottery slots are closed
     * Transfer amount from previous lottery if no winner was selected
     * Fire Lottery Slot Created Event
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createLotterySlot()
    {
        if (!$this->currentUserCan('createLotterySlot')) {
            return $this->respondWithNotAllowed();
        }

        // Run only if no active lottery is present
        $activeLotterySlot = LotterySlot::where('status', 1)->count();
        if ($activeLotterySlot > 0) {
            return $this->setStatusCode(400)->respondWithError('Only one slot can be active', 'activeSlotPresent');
        }

        // Check if previous lottery slot has winner
        // If not, then transfer the amount to current lottery slot
        $previousLotterySlot = LotterySlot::orderBy('id', 'DESC')->first();
        $previousBalance = 0;
        if (! $previousLotterySlot->has_winner) {
            $previousBalance = $previousLotterySlot->total_amount;
        }

        // Get config
        $entryFee = Setting::where('key', 'lottery_slot_entry_fee')->first();

        // Create new lottery slot
        LotterySlot::create([
            'slot_ref' => str_random(18),
            'start_time' => date("Y-m-d H:i:s", time()),
            'end_time' => date("Y-m-d H:i:s", time() + 5 * 60),
            'entry_fee' => $entryFee->value,
            'total_amount' => $previousBalance,
            'status' => 1,
        ]);

        // Fire lottery slot created event
        event(new LotterySlotCreatedEvent());

        // Return response;
        return $this->respondWithSuccess();
    }

    public function closeLotterySlot()
    {
        if (!$this->currentUserCan('closeLotterySlot')) {
            return $this->respondWithNotAllowed();
        }

        // Return if no open lottery slot is present
        $activeLotterySlot = LotterySlot::where('status', 1)->orderBy('id', 'DESC')->first();
        if (! $activeLotterySlot) {
            return $this->setStatusCode(400)->respondWithError('No open lottery slot', 'noOpenLotterySlot');
        }

        // check if winners exist
        // We are only checking for whole match
        $winners = LotterySlotUser::where('lottery_slot_id', $activeLotterySlot->id)->where('lottery_number', json_encode($activeLotterySlot->result))->get();
        $winnersCount = count($winners);

        if ($winnersCount > 0) {
            // Get config
            $serviceChargePercent = Setting::where('key', 'lottery_slot_service_charge')->first();
            $lotteryAmount = $activeLotterySlot->total_amount;
            $wonAmount = ($lotteryAmount / $winnersCount) * ((100 - $serviceChargePercent->value) / 100);
            $serviceCharge = ($lotteryAmount / $winnersCount) * ($serviceChargePercent->value / 100);

            foreach ($winners as $winner) {
                $winner->fill([
                    'lottery_winner_type_id' => 1,
                    'won_amount' => $wonAmount,
                    'service_charge' => $serviceCharge
                ])->save();

                $wallet = Wallet::where('user_id', $winner->id)->findOrFail();
                (new WalletService)->handleTransaction($wallet, 'win', $wonAmount);
            }
        }

        // generate result
        $result = $this->generateResult();
        $activeLotterySlot->update([
            'result' => $result,
            'status' => 0,
            'has_winner' => $winnersCount > 0 ? 1 : 0
        ]);
        // Fire lottery slot result generated event
        event(new LotterySlotResultGeneratedEvent());

        // Fire lottery closed event
        event(new LotterySlotClosedEvent());

        // Return closed lottery slot
        return $this->setStatusCode(200)->respondWithSuccess();
    }

    public function addParticipantToActiveLotterySlot($userId)
    {
        if (!$this->currentUserCan('addParticipants')) {
            return $this->respondWithNotAllowed();
        }

        // Check if user already is in the lottery slot
        $user = User::where('id', $userId)->first();

        // Check is user has role: player
        if (! $user->hasRole('player')) {
            return $this->setStatusCode(400)->respondWithError('User is not a player', 'userNotPlayer');
        }

        // Check if user already exist in the slot
        $activeLotterySlot = LotterySlot::where('status', 1)->orderBy('id', 'DESC')->first();
        $currentUserAsParticipant = LotterySlotUser::where('lottery_slot_id', $activeLotterySlot->id)->where('user_id', $user->id)->count();

        if ($currentUserAsParticipant > 0) {
            return $this->setStatusCode(400)->respondWithError('Duplicate Entry not allowed', 'duplicateEntry');
        }

        // Handle Wallet Transaction
        $entryFee = Setting::where('key', 'lottery_slot_entry_fee')->first();
        (new WalletService)->handleTransaction($user->wallet, 'order', $entryFee->value);

        // Add participant
        LotterySlotUser::create([
            'lottery_slot_id' => $activeLotterySlot->id,
            'user_id' => $user->id,
            'lottery_number' => $this->generateRandomLotteryNumber(),
        ]);

        // Update Lottery Slot participants count and total amount
        $participantsCount = $activeLotterySlot->participants()->count();
        $totalAmount = $activeLotterySlot->total_amount + $entryFee->value;

        $activeLotterySlot->update([
            'total_participants' => $participantsCount,
            'total_amount' => $totalAmount
        ]);

        // trigger participant added event
        event(new ParticipantAddedEvent());

        return new LotterySlotResource($activeLotterySlot);
    }

    public function getWinners($input)
    {
        if (!$this->currentUserCan('getWinners')) {
            return $this->respondWithNotAllowed();
        }

        // Get all winners list
        $query = LotterySlotUser::where('lottery_winner_type_id', '!=', null);

        $winners = $query->paginate($input['limit'] ?? 15);
        return LotterySlotUserResource::collection($winners);
    }

    public function generateResult()
    {
        if (!$this->currentUserCan('generateResult')) {
            return $this->respondWithNotAllowed();
        }
        return $this->generateRandomLotteryNumber();
    }

    /**
     * Generate lottery with 6 numbers
     *
     * [12, 14, 15, 42, 52, 62]
     *
     * @return array
     */
    public function generateRandomLotteryNumber()
    {
        // initialize empty lottery number
        $lotteryNumber = [];

        // keep generating until the length of the lottery number is 6
        while (count($lotteryNumber) < 6) {
            $element = mt_rand(1, 100);

            // only unique number are eligible for lottery number
            if (! in_array($element, $lotteryNumber)) {
                $lotteryNumber[] = $element;
            }
        }

        return $lotteryNumber;
    }

    /**
     * Check if active lottery slot is present
     * @return bool
     */
    public function isLotterySlotActive()
    {
        // Check if lottery slot is active
        $activeLotterySlot = LotterySlot::where('status', 1)->orderBy('id', 'DESC')->first();

        return !! $activeLotterySlot;
    }

    public function isActiveLotterySlotExpired()
    {
        // Check if lottery slot is active and expired
        $expiredActiveLotterySlot = LotterySlot::where('status', 1)->where('end_time', '<', date(now()) )->orderBy('id', 'DESC')->first();

        return !! $expiredActiveLotterySlot;
    }

    public function runLottery()
    {
        // Check if lottery slot is already active
        if ($this->isLotterySlotActive()) {
            // If end_date is expired, close the lottery slot
            if ($this->isActiveLotterySlotExpired()) {
                $this->closeLotterySlot();
            }
            // Else, If auto generate is on,
        } else {
            $isAutoGenerateLotterySlot = Setting::where('key', 'lottery_slot_auto_generate')->first();

            if ($isAutoGenerateLotterySlot) {
                $this->createLotterySlot();
            }
        }
    }

    public function addFakeParticipants()
    {
        // Check if user already exist in the slot
        $activeLotterySlot = LotterySlot::where('status', 1)->where('end_time', '>', date(now()))->orderBy('id', 'DESC')->first();

        // If no active lottery slot then return
        if (!$activeLotterySlot) {
            return;
        }

        // Get active lottery slot participants count
        $maxFakeUsers = Setting::where('key', 'lottery_slot_max_fake_users')->first();
        $countOfUsersToCreate = mt_rand(1, 5);

        $fakeParticipantsCount = LotterySlotUser::leftJoin('core_users', 'core_users.id', '=', 'lottery_slot_user.user_id')
            ->where('core_users.is_bot', 1)
            ->where('lottery_slot_user.lottery_slot_id', $activeLotterySlot->id)->count();

        $totalFakeUsers = User::where('is_bot', 1)->count();

        // If total fake users is already used, return
        if ($totalFakeUsers <= $fakeParticipantsCount) {
            return;
        }

        // If max fake users exceed then return
        if ($fakeParticipantsCount + $countOfUsersToCreate >= $maxFakeUsers->value) {
            return;
        }

        // Generate fake users equal to $countOfUsersToCreate
        $newFakeUsers = User::where('is_bot', 1)->select('id')->limit($countOfUsersToCreate)->inRandomOrder()->get();

        foreach ($newFakeUsers as $newFakeUser) {
            $this->addParticipantToActiveLotterySlot($newFakeUser->id);
        }

    }

}