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

class LotteryService extends ApiServices
{
    use ApiResponseTrait, PermissionTrait;

    public function getLotterySlots($input)
    {
        if (! $this->currentUserCan('getLotterySlots')) {
            return $this->respondWithNotAllowed();
        }

        if ($input['with'] && $input['with'] === 'participants') {
            $query = LotterySlot::with('participants')->filter($input);
        } else {
            $query = LotterySlot::filter($input);
        }

        $lotterySlots = $query->paginate($input['limit'] ?? 15);
        return LotterySlotResource::collection($lotterySlots);
    }

    public function showLotterySlot()
    {

    }

    public function updateLotterySlot()
    {

    }

    public function updateMultipleLotterySlot()
    {

    }

    public function destroyLotterySlot()
    {

    }

    public function destroyMultipleLotterySlot()
    {

    }

    public function openLotterySlot($id)
    {
        // Generate and activate the current lottery Slot and deactivate all others
        // Send lottery Slot activate event
    }

    public function closeLotterySlot()
    {
        // generate result
        // if result match any of the participant lottery_number, declare winner
        // if auto generate lottery slot is true then
        // generate another lottery slot with initial amount added from closed lottery slot
        // send email to admin, winners
    }

    public function addParticipantToActiveLotterySlot()
    {
        // Check if user have the entry fee amount in their wallet
        // If yes, add user as participant to lottery and generate/pick lottery_number
        // Send Participant added event
        // Send email to admin, user
    }

    public function getWinners()
    {
        // Get all winners list
    }

    public function generateResult()
    {
        return $this->generateRandomLotteryNumber();
    }

    public function generateRandomLotteryNumber()
    {

    }

}