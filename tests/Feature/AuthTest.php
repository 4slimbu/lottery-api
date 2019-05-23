<?php

namespace Tests\Feature;

use App\Acme\Events\Registration\UserForgotPasswordEvent;
use App\Acme\Events\Registration\UserRegisteredEvent;
use App\Acme\Models\User;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    /** @test */
    public function user_registration()
    {
        $this->expectsEvents(UserRegisteredEvent::class);

        $user = factory(User::class)->make();
        $data = $user->toArray();
        $data['password'] = 'Password1';

        $response = $this->postjson('/api/v1/register', $data);
        $response->assertStatus(200);
    }

    /** @test */
    public function registered_users_can_login()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt('Password1'),
        ]);

        $data = [
            'email' => $user->email,
            'password' => 'Password1'
        ];

        $response = $this->postJson('/api/v1/login', $data);
        $response->assertStatus(200);
    }

    /** @test */
    public function forgot_password()
    {
        $this->expectsEvents(UserForgotPasswordEvent::class);

        $user = factory(User::class)->create();
        $data = [
            'email' => $user->email,
        ];

        $response = $this->postJson('/api/v1/forgot-password', $data);
        $response->assertStatus(200);
    }

    /** @test */
    public function reset_password()
    {
        $user = factory(User::class)->create();
        $token = Password::getRepository()->create($user);

        $data = [
            'email' => $user->email,
            'password' => 'Password1',
            'token' => $token,
        ];

        $response = $this->putJson('/api/v1/reset-password', $data);
        $response->assertStatus(200);
    }

    /** @test */
    public function verify_token()
    {
        $user = factory(User::class)->create(['email_token' => str_random()]);

        $response = $this->putJson('/api/v1/verify-email/' . $user->email_token);
        $response->assertStatus(200);
    }
}
