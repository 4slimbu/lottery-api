<?php

namespace Tests\Feature;

use Tests\TestCase;

class CategoryTest extends TestCase
{
    /** @test */
    public function can_get_categories()
    {
        $this->userLogin();

        $response = $this->get('/api/v1/categories');
        $response->assertStatus(200);
    }
}
