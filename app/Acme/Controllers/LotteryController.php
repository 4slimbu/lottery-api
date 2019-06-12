<?php

namespace App\Acme\Controllers;

use App\Acme\Models\LotterySlot;
use App\Acme\Requests\LotterySlotGetRequest;
use App\Acme\Requests\LotteryWinnerGetRequest;
use App\Acme\Requests\RoleCreateRequest;
use App\Acme\Requests\RoleDestroyMultipleRequest;
use App\Acme\Requests\RoleGetRequest;
use App\Acme\Requests\RoleUpdateRequest;
use App\Acme\Services\LotteryService;
use Illuminate\Http\Request;

class LotteryController extends ApiController
{
    private $lotteryService;
    public function __construct(LotteryService $lotteryService)
    {
        $this->middleware('auth:api');
        $this->lotteryService = $lotteryService;
    }

    public function index(LotterySlotGetRequest $request)
    {
        $input = $request->getFilter();
        return $this->lotteryService->getLotterySlots($input);
    }

    public function create()
    {
        return $this->lotteryService->createLotterySlot();
    }

    public function close()
    {
        return $this->lotteryService->closeLotterySlot();
    }

    public function addParticipant(Request $request)
    {
        $userId = $request->get('user_id');

        return $this->lotteryService->addParticipantToActiveLotterySlot($userId);
    }

    public function getWinners(LotteryWinnerGetRequest $request)
    {
        $input = $request->getFilter();
        return $this->lotteryService->getWinners($input);
    }

    public function showLotterySlot(Request $request, $lotterySlotId)
    {
        $input['lottery_slot_id'] = $lotterySlotId;

        if ($request->get('with')) {
            $input['with'] = $request->get('with');
        }

        return $this->lotteryService->showLotterySlot($input);
    }

    public function update(RoleUpdateRequest $request, $roleId)
    {
        $input = $request->getInput();
        $input['role_id'] = $roleId;
        return $this->lotteryService->updateRole($input);
    }

    public function destroy($roleId)
    {
        $input['role_id'] = $roleId;
        return $this->lotteryService->destroyRole($input);
    }

    public function destroyMultiple(RoleDestroyMultipleRequest $request)
    {
        $input = $request->getInput();
        return $this->lotteryService->destroyMultipleRole($input);
    }

}