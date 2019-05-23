<?php

namespace Tests\Feature;

use App\Acme\Models\Account;
use App\Acme\Models\Campaign;
use App\Acme\Models\CampaignJobConsumption;
use App\Acme\Models\Rate;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CampaignJobConsumptionTest extends TestCase
{
    /** @test */
    public function can_get_campaign_histories()
    {
        $this->userLogin();

        $job = DB::table('smartfeed_hopper_jobs')->first();

        $account = factory(Account::class)->create();
        $rate = factory(Rate::class)->create();
        $campaign = $account->campaigns()->save(factory(Campaign::class)->make([
            'rate_version_code' => $rate->version_code,
        ]));
        $campaign->jobConsumptions()->save(factory(CampaignJobConsumption::class)->make([
            'job_id' => $job->id,
        ]));

        $response = $this->get('/api/v1/campaigns/' . $campaign->id . '/job-consumptions');
        $response->assertStatus(200);
    }
}
