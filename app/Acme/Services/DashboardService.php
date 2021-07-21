<?php

namespace App\Acme\Services;

use App\Acme\Models\LotterySlot;
use App\Acme\Models\LotterySlotUser;
use App\Acme\Models\Setting;
use App\Acme\Models\User;
use App\Acme\Models\Wallet;
use App\Acme\Resources\SettingResource;
use App\Acme\Traits\ApiResponseTrait;
use App\Acme\Traits\PermissionTrait;

class DashboardService extends ApiServices
{
    use ApiResponseTrait, PermissionTrait;

    public function getStats()
    {
        // User Status
        $realUserCount = User::where('is_bot', 0)->count();
        $totalUserCount = User::count();

        // Games stats
        $totalGames = LotterySlot::count();

        // Total Deposit
        $totalDeposit = Wallet::sum('deposit');

        // Total Income
        $totalIncome = LotterySlotUser::sum('service_charge');

        // Game stats
        $lotterySlots = LotterySlot::limit(10)->orderBy('id', 'DESC')
            ->select('id', 'slot_ref', 'total_participants', 'total_amount')->get();
        $gameStats = [];

        foreach ($lotterySlots as $key => $lotterySlot) {
            $gameStats[] = [
                "slot_ref" => $lotterySlot->slot_ref,
                "participants" => $lotterySlot->total_participants,
                "prize_pool" => $lotterySlot->total_amount,
            ];
        }

        return [
            "user_count" => [
                "real" => $realUserCount,
                "total" => $totalUserCount
            ],
            "total_games" => $totalGames,
            "total_deposit" => $totalDeposit,
            "total_income" => $totalIncome,
            "game_stats" => array_reverse($gameStats)
        ];
    }

}