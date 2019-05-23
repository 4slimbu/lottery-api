<?php

namespace Tests\Feature;

use App\Acme\Models\Account;
use App\Acme\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function can_get_users()
    {
        $this->userLogin();

        $response = $this->get('/api/v1/users');
        $response->assertStatus(200);
    }

    /** @test */
    public function can_create_user()
    {
        $this->userLogin();

        $account = factory(Account::class)->create();
        $user = factory(User::class)->make([
            'account_id' => $account->id,
        ]);

        $data = [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'account_id' => $account->id,
        ];

        $response = $this->postJson('/api/v1/users', $data);
        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
            ]
        ]);
    }

    /** @test */
    public function can_get_user()
    {
        $this->userLogin();

        $account = factory(Account::class)->create();
        $user = factory(User::class)->create([
            'account_id' => $account->id,
        ]);

        $response = $this->get('/api/v1/users/' . $user->id);
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
            ]
        ]);
    }

    /** @test */
    public function can_update_user()
    {
        $this->userLogin();

        $account = factory(Account::class)->create();
        $user = factory(User::class)->create([
            'account_id' => $account->id,
        ]);
        $userFake = factory(User::class)->make();

        $data = [
            'first_name' => $userFake->first_name,
            'last_name' => $userFake->last_name,
            'email' => $userFake->email,
            'account_id' => $account->id,
        ];

        $response = $this->putJson('/api/v1/users/' . $user->id, $data);
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $user->id,
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
            ]
        ]);
    }


    /** @test */
    public function public_can_check_users_email()
    {
        $user = factory(User::class)->create();
        $response = $this->get('/api/v1/users/check-email?email=' . $user->email);
        $response->assertStatus(200);
    }
}
