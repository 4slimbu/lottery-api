<?php

namespace Tests\Feature;

use App\Acme\Models\JobHopper;
use Tests\TestCase;

class MeJobTest extends TestCase
{
    /** @test */
    public function i_can_get_my_jobs()
    {
        $this->userLogin();

        $response = $this->get('/api/v1/me/jobs');
        $response->assertStatus(200);
    }

    /** @test */
    public function i_can_get_my_job()
    {
        $this->userLogin();

        $job = factory(JobHopper::class)->create();

//        $job = JobHopper::where('user_id', $this->user->id)
//                        ->where('account_id', $this->user->account_id)->first();
//        dd($job);

        $response = $this->get('/api/v1/me/jobs/' . $job->id);
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $job->id,
            ]
        ]);
    }
}
