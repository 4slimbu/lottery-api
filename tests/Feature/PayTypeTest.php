<?php

namespace Tests\Feature;

use Tests\TestCase;

class PayTypeTest extends TestCase
{
    /** @test */
    public function can_get_pay_types()
    {
        $this->userLogin();

        $response = $this->get('/api/v1/pay-types');
        $response->assertStatus(200);
    }
}
