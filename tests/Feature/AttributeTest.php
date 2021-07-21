<?php

namespace Tests\Feature;

use Tests\TestCase;

class AttributeTest extends TestCase
{
    /** @test */
    public function can_get_attributes()
    {
        $this->userLogin();

        $response = $this->get('/api/v1/job-attributes');
        $response->assertStatus(200);
    }
}
