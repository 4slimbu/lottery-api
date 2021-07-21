<?php

namespace Tests\Feature;

use App\Acme\Models\Account;
use App\Acme\Models\Campaign;
use App\Acme\Models\Rate;
use Tests\TestCase;

class CampaignTest extends TestCase
{
    /** @test */
    public function can_get_campaigns()
    {
        $this->userLogin();

        $response = $this->get('/api/v1/campaigns');
        $response->assertStatus(200);
    }

    /** @test */
    public function can_create_campaigns()
    {
        $this->userLogin();

        $account = factory(Account::class)->create();
        $rate = factory(Rate::class)->create();

        $data = [
            'code' => uniqid(),
            'account_id' => $account->id,
            'rate_version_code' => $rate->version_code,
            'budget' => 10,
        ];

        $response = $this->postJson('/api/v1/campaigns', $data);
        $response->assertStatus(201);
    }

    /** @test */
    public function can_get_campaign()
    {
        $this->userLogin();

        $account = factory(Account::class)->create();
        $campaign = factory(Campaign::class)->create([
            'account_id' => $account->id,
        ]);

        $response = $this->get('/api/v1/campaigns/' . $campaign->id);
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $campaign->id,
                'code' => $campaign->code,
                'rate_version_code' => $campaign->rate_version_code,
                'budget' => $campaign->budget,
            ],
        ]);
    }

    /** @test */
    public function can_update_campaigns()
    {
        $this->userLogin();

        $account = factory(Account::class)->create();
        $rate = factory(Rate::class)->create();
        $campaign = factory(Campaign::class)->create([
            'account_id' => $account->id,
            'rate_version_code' => $rate->version_code,
        ]);

        $code = uniqid();
        $budget = 200;
        $data = [
            'code' => $code,
            'account_id' => $campaign->account_id,
            'rate_version_code' => $campaign->rate_version_code,
            'budget' => $budget,
        ];

        $response = $this->putJson('/api/v1/campaigns/' . $campaign->id, $data);
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $campaign->id,
                'code' => $code,
                'rate_version_code' => $campaign->rate_version_code,
                'budget' => $budget,
            ],
        ]);
    }

    /** @test */
    public function can_cancel_campaign()
    {
        $this->userLogin();

        $account = factory(Account::class)->create();
        $campaign = factory(Campaign::class)->create([
            'account_id' => $account->id,
        ]);

        $response = $this->putJson('/api/v1/campaigns/' . $campaign->id . '/cancel');
        $response->assertStatus(200);
    }
}
