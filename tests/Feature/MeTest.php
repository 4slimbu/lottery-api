<?php

namespace Tests\Feature;

use Tests\TestCase;

class MeTest extends TestCase
{
    /** @test */
    public function authenticated_users_can_get_their_details()
    {
        $this->userLogin();

        $response = $this->get('/api/v1/me');
        $response->assertStatus(200);
    }
}
