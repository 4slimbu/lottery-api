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
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
     * @param bool $isSystem
     * @return LotterySlotResource|\Illuminate\Http\JsonResponse
     */
    public function showLotterySlot($input, $isSystem = false)
    {
        if (!$isSystem && !$this->currentUserCan('getLotterySlots')) {
            return $this->respondWithNotAllowed();
        }

        if (! isset($input['lottery_slot_id'])) {
            return $this->respondNotFound();
        }
        // If user can get Participants
        if ($isSystem || $this->currentUserCan('getParticipants')) {
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
     * @param bool $isSystem
     * @return \Illuminate\Http\JsonResponse
     */
    public function createLotterySlot($isSystem = false)
    {
        if (!$isSystem && !$this->currentUserCan('createLotterySlot')) {
            return $this->respondWithNotAllowed();
        }
        // Run only if no active lottery is present
        $activeLotterySlot = LotterySlot::where('status', 1)->count();
        if ($activeLotterySlot > 0) {
            return $this->setStatusCode(400)->respondWithError('Only one slot can be active', 'activeSlotPresent');
        }

        // Carry over amount from previous slot
        $previousLotterySlot = LotterySlot::orderBy('id', 'DESC')->first();
        $previousBalance = $previousLotterySlot->carry_amount;

        // Get config
        $entryFee = Setting::where('key', 'lottery_slot_entry_fee')->first();
        $runDuration = Setting::where('key', 'lottery_slot_run_duration')->first();

        // Create new lottery slot
        $lotterySlot = LotterySlot::create([
            'slot_ref' => str_random(18),
            'start_time' => date("Y-m-d H:i:s", time()),
            'end_time' => date("Y-m-d H:i:s", time() + $runDuration->value * 60),
            'entry_fee' => $entryFee->value,
            'total_amount' => $previousBalance,
            'status' => 1,
        ]);

        // Fire lottery slot created event
        event(new LotterySlotCreatedEvent($lotterySlot));

        // Return response;
        return $this->respondWithSuccess();
    }

    public function closeLotterySlot($isSystem = true)
    {
        if (!$isSystem && !$this->currentUserCan('closeLotterySlot')) {
            return $this->respondWithNotAllowed();
        }

        // Return if no open lottery slot is present
//        $activeLotterySlot = LotterySlot::where('id', 46)->orderBy('id', 'DESC')->first();
        $activeLotterySlot = LotterySlot::where('status', 1)->orderBy('id', 'DESC')->first();
        if (! $activeLotterySlot) {
            return $this->setStatusCode(400)->respondWithError('No open lottery slot', 'noOpenLotterySlot');
        }

        // generate result
        $result = $this->generateResult($isSystem);

        // Handle winners
        $winners = $this->handleWinners($activeLotterySlot, $result);

        $winnersCount = count($winners);

        // Update Lottery slot with new info
        $activeLotterySlot->update([
            'result' => $result,
            'status' => 0,
            'has_winner' => $winnersCount > 0 ? 1 : 0
        ]);

        $activeLotterySlot->load('winners');
        $data = [
            'lastSlot' => $activeLotterySlot,
            ];

        if ($winnersCount > 0) {
            // Get all winners list
            $winners = LotterySlotUser::where('lottery_winner_type_id', '!=', null)
                ->orderBy('lottery_slot_id', 'DESC')->paginate(15);
            $data['winners'] = LotterySlotUserResource::collection($winners);
        }

        // Fire lottery closed event
        event(new LotterySlotClosedEvent($data));

        // Return closed lottery slot
        return $this->setStatusCode(200)->respondWithSuccess();
    }

    public function addParticipantToActiveLotterySlot($userId, $isSystem = false, $inputs = [])
    {
        if (! $userId) {
            return $this->respondWithNotAllowed();
        }

        if (!$isSystem && !$this->currentUserCan('addParticipants')) {
            return $this->respondWithNotAllowed();
        }
        // Check if user already is in the lottery slot
        $user = User::where('id', $userId)->first();

        // Check is user has role: player
        if (! $user->hasRole('player')) {
            return $this->setStatusCode(400)->respondWithError('User is not a player', 'userNotPlayer');
        }

        // Check if user already exist in the slot and the slot is active/not-expired
        $activeLotterySlot = LotterySlot::where('status', 1)->where('end_time', '>', date(now()))->orderBy('id', 'DESC')->first();

        if (! $activeLotterySlot) {
            return $this->respondWithNotAllowed();
        }

        $currentUserAsParticipant = LotterySlotUser::where('lottery_slot_id', $activeLotterySlot->id)->where('user_id', $user->id)->count();

        if ($currentUserAsParticipant > 0) {
            return $this->setStatusCode(400)->respondWithError('Duplicate Entry not allowed', 'duplicateEntry');
        }

        $entryFee = Setting::where('key', 'lottery_slot_entry_fee')->first();

        // Skip wallet transaction for bots and user with free_games
        if (!$user->is_bot && !$user->free_games > 0) {
            // Handle Wallet Transaction
            $transaction = (new WalletService)->handleTransaction($user->wallet, 'order', $entryFee->value);

            if (! $transaction) {
                return $this->setStatusCode(400)->respondWithError('Transaction Failed', 'transactionFailed');
            }
        }

        // Decrease free games count
        if ($user->free_games > 0) {
            $user->free_games = $user->free_games - 1;
            $user->save();
        }

        // get lottery number
        if (isset($inputs['lottery_number'])) {
            $lotteryNumber = $inputs['lottery_number'];
        } else {
            $lotteryNumber = $this->generateRandomLotteryNumber();
        }

        // Check if user has bypass unique number validation and put repeating same number thus trying to trick the winning logic
        // into thinking them as winner
        if (count($lotteryNumber) !== count(array_unique($lotteryNumber))) {
            return $this->setStatusCode(400)->respondWithError('Invalid Lottery Number', 'invalidLotteryNumber');
        }

        // Add participant
        $lotterySlotUser = LotterySlotUser::create([
            'lottery_slot_id' => $activeLotterySlot->id,
            'user_id' => $user->id,
            'lottery_number' => $lotteryNumber,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        // Update Lottery Slot participants count and total amount
        $participantsCount = $activeLotterySlot->participants()->count();

        // Add entry fee to lottery amount only for paid users
        if (!$user->is_bot && !$user->free_games > 0) {
            $totalAmount = $activeLotterySlot->total_amount + $entryFee->value;
        } else {
            $totalAmount = $activeLotterySlot->total_amount;
        }

        $activeLotterySlot->update([
            'total_participants' => $participantsCount,
            'total_amount' => $totalAmount
        ]);

        $participant = [
            'id' => $lotterySlotUser->id,
            'full_name' => $lotterySlotUser->user->full_name,
            'nickname' => $lotterySlotUser->user->nickname,
            'username' => $lotterySlotUser->user->username,
        ];

        // trigger participant added event
        event(new ParticipantAddedEvent($activeLotterySlot, $participant));

        return new LotterySlotResource($activeLotterySlot);
    }

    public function getWinners($input, $isSystem = false)
    {
        if (!$isSystem && !$this->currentUserCan('getWinners')) {
            return $this->respondWithNotAllowed();
        }

        // Get all winners list
        $query = LotterySlotUser::where('lottery_winner_type_id', '!=', null)->orderBy('lottery_slot_id', 'DESC');

        $winners = $query->paginate($input['limit'] ?? 15);
        return LotterySlotUserResource::collection($winners);
    }

    public function getActiveSlot()
    {
        // Get Active Lottery Slot
        $activeSlot = LotterySlot::where('status', 1)->first();

        if (! $activeSlot) {
            return $this->respondNotFound();
        }

        return new LotterySlotResource($activeSlot);
    }

    public function generateResult($isSystem = false)
    {
        if (!$isSystem && !$this->currentUserCan('generateResult')) {
            return $this->respondWithNotAllowed();
        }

//        return [1, 2, 3, 4, 5, 6];

        // Fake winner every 33%
        $fakeWinner = null;
//        $fakeWinner = mt_rand(1, 2);
        if ($fakeWinner) {
            // Get user from latest list:
            $lotterySlotUser = LotterySlotUser::orderBy('lottery_slot_id', 'DESC')->first();
            return $lotterySlotUser->lottery_number;
        } else {
            return $this->generateRandomLotteryNumber();
        }
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
        $maxNumber = 56;

        // keep generating until the length of the lottery number is 6
        while (count($lotteryNumber) < 6) {
            $element = mt_rand(1, $maxNumber);

            // only unique number are eligible for lottery number
            if (! in_array($element, $lotteryNumber) && $element < ($maxNumber + 1)) {
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

    public function runLottery($isSystem = false)
    {
        // Check if lottery slot is already active
        if ($this->isLotterySlotActive()) {
            // If end_date is expired, close the lottery slot
            if ($this->isActiveLotterySlotExpired()) {
                $this->closeLotterySlot($isSystem);
            }
            // Else, If auto generate is on,
        } else {
            $isAutoGenerateLotterySlot = Setting::where('key', 'lottery_slot_auto_generate')->first();

            if ($isAutoGenerateLotterySlot) {
                $this->createLotterySlot($isSystem);
            }
        }
    }

    public function addFakeParticipants($isSystem = false)
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
            $this->addParticipantToActiveLotterySlot($newFakeUser->id, $isSystem);
        }

    }

    public function getLastResult($isSystem = false)
    {
        // Get last lottery slot
        $lastLotterySlot = null;
        $winners = null;
        $lastTwoLotterySlot = LotterySlot::orderBy('id', 'DESC')->limit(2)->get();
        $lastLotterySlot = $lastTwoLotterySlot->last();

        $lastLotterySlot->load('winners');
        return [
            "data" => $lastLotterySlot
        ];
    }

    public function handleWinners($activeLotterySlot, $result)
    {
        // getWinners
        $winners = $this->getCurrentWinners($activeLotterySlot, $result);
        $totalAmount = $activeLotterySlot->total_amount;
        $lotteryAmount = 0;
        $carryAmount = $totalAmount;

        // Handle transactions and data update
        if ($winners) {
            foreach ($winners as $typeWinners) {
                if ($typeWinners['type'] === 'jackpot' && $typeWinners['count'] > 0) {
                    $winnersCount = $typeWinners['count'];
                    $lotteryAmount = $totalAmount;
                    $carryAmount = $carryAmount - $lotteryAmount;
                    $lotteryWinnerTypeId = 1;
                } else {
                    if ($typeWinners['type'] === 'fiveDigit' && $typeWinners['count'] > 0) {
                        $winnersCount = $typeWinners['count'];
                        // only 10% is distributed to fiveDigit winners
                        $lotteryAmount = $activeLotterySlot->total_amount * 10 / 100;
                        $carryAmount = $carryAmount  - $lotteryAmount;
                        $lotteryWinnerTypeId = 2;
                    }

                    if ($typeWinners['type'] === 'fourDigit' && $typeWinners['count'] > 0) {
                        $winnersCount = $typeWinners['count'];
                        // only 3% is distributed to fiveDigit winners
                        $lotteryAmount = $activeLotterySlot->total_amount * 3 / 100;
                        $carryAmount = $carryAmount - $lotteryAmount;
                        $lotteryWinnerTypeId = 3;
                    }
                }

                if (isset($winnersCount) && $winnersCount > 0 && isset($lotteryWinnerTypeId) && $lotteryWinnerTypeId > 0) {
                    // Get config
                    $serviceChargePercent = Setting::where('key', 'lottery_slot_service_charge')->first();

                    $wonAmount = ($lotteryAmount / $winnersCount) * ((100 - $serviceChargePercent->value) / 100);
                    $serviceCharge = ($lotteryAmount / $winnersCount) * ($serviceChargePercent->value / 100);
                    foreach ($typeWinners['winners'] as $winner) {
                        $winner->fill([
                            'lottery_winner_type_id' => $lotteryWinnerTypeId,
                            'won_amount' => $wonAmount,
                            'service_charge' => $serviceCharge,
                            'updated_at' => Carbon::now()
                        ])->save();

                        $wallet = Wallet::where('user_id', $winner->user_id)->first();
                        (new WalletService)->handleTransaction($wallet, 'win', $wonAmount);
                    }
                }

            }
        }

        // Update the carry amount for active lottery slot
        $activeLotterySlot->carry_amount = $carryAmount;
        $activeLotterySlot->save();

        return $winners;
    }

    public function getCurrentWinners($activeLotterySlot, $result)
    {
        $winners = [];

        // Get jackpot Winners
        $jackpotWinners = $this->getJackpotWinners($activeLotterySlot, $result);
        if ($jackpotWinners['count'] > 0) {
            $winners[] = ['type' => 'jackpot'] + $jackpotWinners;

            // If jackpot winner, then no need to distribute prize to other type of winner.
            return $winners;
        }

        // Get five digit Winners
        $fiveDigitWinners = $this->getFiveDigitWinners($activeLotterySlot, $result, $jackpotWinners['winnerIds']);

        if ($fiveDigitWinners) {
            $winners[] = ['type' => 'fiveDigit'] + $fiveDigitWinners;
        }

        // Get four digit Winners
        $fourDigitWinners = $this->getFourDigitWinners($activeLotterySlot, $result, $jackpotWinners['winnerIds']->merge($fiveDigitWinners['winnerIds']));
        if ($fourDigitWinners) {
            $winners[] = ['type' => 'fourDigit'] + $fourDigitWinners;
        }

        return $winners;

    }

    public function getJackpotWinners($activeLotterySlot, $result)
    {
        $response = [
            'count' => 0,
            'winners' => collect([]),
            'winnerIds' => collect([])
        ];

        $winners = LotterySlotUser::where('lottery_slot_id', $activeLotterySlot->id);

        foreach ($result as $number) {
            $winners->where(function($q) use ($number) {
                $q->where('lottery_number', 'LIKE', '%[' . $number . ',%')
                    ->orWhere('lottery_number', 'LIKE', '%,' . $number . ',%')
                    ->orWhere('lottery_number', 'LIKE', '%,' . $number . ']%');
            });
        };

        $winnersCount = $winners->count();
        if ($winnersCount > 0) {
            $response['count'] = $winnersCount;
            $response['winners'] = $winners->get();
            $response['winnerIds'] = $winners->pluck('user_id');
        }

        return $response;
    }


    public function getFiveDigitWinners($activeLotterySlot, $result, $excludeUserIds)
    {
        // These are the possible five indexes in result that can be matched.
        $possibleFiveDigitCombinations = [
            [0, 1, 2, 3, 4],
            [0, 1, 2, 3, 5],
            [0, 1, 2, 4, 5],
            [0, 1, 3, 4, 5],
            [0, 2, 3, 4, 5],
            [1, 2, 3, 4, 5],
        ];

        return $this->combinationWinners($activeLotterySlot, $possibleFiveDigitCombinations, $result, $excludeUserIds);
    }

    public function getFourDigitWinners($activeLotterySlot, $result, $excludeUserIds)
    {
        $possibleFourDigitCombinations = [
            [0, 1, 2, 3],
            [0, 1, 2, 4],
            [0, 1, 2, 5],
            [0, 1, 3, 4],
            [0, 1, 3, 5],
            [0, 1, 4, 5],
            [0, 2, 3, 4],
            [0, 2, 3, 5],
            [0, 2, 4, 5],
            [0, 3, 4, 5],
            [1, 2, 3, 4],
            [1, 2, 3, 5],
            [1, 2, 4, 5],
            [1, 3, 4, 5],
            [2, 3, 4, 5],
        ];

        return $this->combinationWinners($activeLotterySlot, $possibleFourDigitCombinations, $result, $excludeUserIds);
    }

    private function combinationWinners($activeLotterySlot, $possibleCombinations, $result, $excludeUserIds)
    {
        $response = [
            'count' => 0,
            'winners' => collect([]),
            'winnerIds' => collect([])
        ];

        $winners = LotterySlotUser::where('lottery_slot_id', $activeLotterySlot->id);
        foreach ($possibleCombinations as $index => $currentCombination) {
            if ($index === 0) {
                $winners->where(function($query) use ($currentCombination, $result, $excludeUserIds) {
                    foreach ($currentCombination as $index) {
                        $query->where(function($q) use ($result, $index) {
                            $q->where('lottery_number', 'LIKE', '%[' . $result[$index] . ',%')
                                ->orWhere('lottery_number', 'LIKE', '%,' . $result[$index] . ',%')
                                ->orWhere('lottery_number', 'LIKE', '%,' . $result[$index] . ']%');
                        });

                        $query->whereNotIn('user_id', $excludeUserIds);
                    };
                });
            } else {
                $winners->orWhere(function($query) use ($currentCombination, $result, $excludeUserIds) {
                    foreach ($currentCombination as $index) {
                        $query->where(function($q) use ($result, $index) {
                            $q->where('lottery_number', 'LIKE', '%[' . $result[$index] . ',%')
                                ->orWhere('lottery_number', 'LIKE', '%,' . $result[$index] . ',%')
                                ->orWhere('lottery_number', 'LIKE', '%,' . $result[$index] . ']%');
                        });

                        $query->whereNotIn('user_id', $excludeUserIds);
                    };
                });
            }

        }

        $winnersCount = $winners->count();
        if ($winnersCount > 0) {
            $response['count'] = $winnersCount;
            $response['winners'] = $winners->get();
            $response['winnerIds'] = $winners->pluck('user_id');
        }

        return $response;
    }

    // Todo: make this subarray combination calculator work
    private function getSubArray($arr, $r) {
        // A temporary array to
        // store all combination
        // one by one
        $data = array();
        $n = count($arr);

        // Print all combination
        // using temporary array 'data[]'
        return $this->combinationUtil($arr, $data, 0, $n - 1, 0, $r);
    }

    private function combinationUtil($arr, $data, $start, $end, $index, $r) {
        // Current combination is ready
        // to be printed, print it
        if ($index == $r)
        {
            for ($j = 0; $j < $r; $j++) {
                echo $data[$j];
            }

            echo " ";
            return;
        }

        for ($i = $start; $i <= $end && $end - $i + 1 >= $r - $index; $i++) {
            $data[$index] = $arr[$i];
            $this->combinationUtil($arr, $data, $i + 1, $end, $index + 1, $r);
        }

    }
}