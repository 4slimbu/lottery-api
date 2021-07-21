<?php

namespace Tests\Feature;

use App\Acme\Models\Account;
use App\Acme\Models\Campaign;
use App\Acme\Models\CampaignHistory;
use App\Acme\Models\Rate;
use Tests\TestCase;

class CampaignHistoryTest extends TestCase
{
    /** @test */
    public function can_get_campaign_histories()
    {
        $this->userLogin();

        $account = factory(Account::class)->create();
        $rate = factory(Rate::class)->create();
        $campaign = $account->campaigns()->save(factory(Campaign::class)->make([
            'rate_version_code' => $rate->version_code,
        ]));
        $campaign->histories()->save(factory(CampaignHistory::class)->make([
            'rate_version_code' => $rate->version_code,
        ]));

        $response = $this->get('/api/v1/campaigns/' . $campaign->id . '/histories');
        $response->assertStatus(200);
    }
}
