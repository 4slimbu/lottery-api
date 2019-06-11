<?php

namespace App\Acme\Services;

use App\Acme\Events\Registration\RoleForgotPasswordEvent;
use App\Acme\Exceptions\ServerErrorException;
use App\Acme\Models\LotterySlot;
use App\Acme\Models\LotterySlotUser;
use App\Acme\Models\PasswordReset;
use App\Acme\Models\Role;
use App\Acme\Models\RoleEmailReset;
use App\Acme\Models\Setting;
use App\Acme\Resources\LotterySlotResource;
use App\Acme\Resources\Core\RoleResource;
use App\Acme\Traits\ApiResponseTrait;
use App\Acme\Traits\PermissionTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;

class LotteryService extends ApiServices
{
    use ApiResponseTrait, PermissionTrait;

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
            return $this->respondWithNotAllowed();
        }

        // Check if previous lottery slot has winner
        // If not, then transfer the amount to current lottery slot
        $previousLotterySlot = LotterySlot::orderBy('id', 'DESC')->first();
        $previousBalance = 0;
        if (! $previousLotterySlot->has_winner) {
            $previousBalance = $previousLotterySlot->total_amount;
        }

        // Get config
        $currency = Setting::where('key', 'app_currency')->first();
        $entryFee = Setting::where('key', 'lottery_slot_entry_fee')->first();

        // Create new lottery slot
        LotterySlot::create([
            'slot_ref' => str_random(18),
            'start_time' => date("Y-m-d H:i:s", time()),
            'end_time' => date("Y-m-d H:i:s", time() + 5 * 60),
            'currency' => $currency->value,
            'entry_fee' => $entryFee->value,
            'total_amount' => $previousBalance,
            'status' => 1,
        ]);

        // Send lottery Slot create event
        return $this->respondWithSuccess();
//        event(new LotterySlotCreated);
    }

    public function closeLotterySlot()
    {
        if (!$this->currentUserCan('closeLotterySlot')) {
            return $this->respondWithNotAllowed();
        }

        // Return if no open lottery slot is present
//        $activeLotterySlot = LotterySlot::where('status', 1)->orderBy('id', 'DESC')->first();
        $activeLotterySlot = LotterySlot::where('id', 20)->orderBy('id', 'DESC')->first();
        if (! $activeLotterySlot) {
            return $this->setStatusCode(400)->respondWithError('No open lottery slot', 'noOpenLotterySlot');
        }

        // check if winners exist
        // We are only checking for whole match
        $winners = LotterySlotUser::where('lottery_slot_id', $activeLotterySlot->id)->where('lottery_number', json_encode($activeLotterySlot->result))->get();
        $winnersCount = count($winners);

        if ($winnersCount > 0) {
            // Get config
            $currency = Setting::where('key', 'app_currency')->first();
            $serviceChargePercent = Setting::where('key', 'lottery_slot_service_charge')->first();
            $lotteryAmount = $activeLotterySlot->total_amount;
            $wonAmount = ($lotteryAmount / $winnersCount) * ((100 - $serviceChargePercent->value) / 100);
            $serviceCharge = ($lotteryAmount / $winnersCount) * ($serviceChargePercent->value / 100);

            foreach ($winners as $winner) {
                $winner->fill([
                    'lottery_winner_type_id' => 1,
                    'currency' => $currency->value,
                    'won_amount' => $wonAmount,
                    'service_charge' => $serviceCharge
                ])->save();
            }
        }

        // generate result
        $result = $this->generateResult();
        $activeLotterySlot->update([
            'result' => $result,
            'status' => 0,
            'has_winner' => $winnersCount > 0 ? 1 : 0
        ]);

        // if result match any of the participant lottery_number, declare winner
        // if auto generate lottery slot is true then
        // generate another lottery slot with initial amount added from closed lottery slot
        // send email to admin, winners
    }

    public function addParticipantToActiveLotterySlot()
    {
        if (!$this->currentUserCan('addParticipants')) {
            return $this->respondWithNotAllowed();
        }
        // Check if user have the entry fee amount in their wallet
        // If yes, add user as participant to lottery and generate/pick lottery_number
        // Send Participant added event
        // Send email to admin, user
    }

    public function getWinners()
    {
        if (!$this->currentUserCan('getWinners')) {
            return $this->respondWithNotAllowed();
        }
        // Get all winners list
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

}