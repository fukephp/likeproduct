<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JustSteveKing\StatusCode\Http;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testCanUserLogin()
    {
        $this->withoutExceptionHandling();

        $user = $this->createUser();

        $data = [
            'email' => $user->email,
            'password' => 'password'
        ];

        $response = $this->postJson('/api/login', $data);

        $status = Http::OK;

        $response->assertStatus($status->value);
    }

    public function testCanUserRegister()
    {
        $this->withoutExceptionHandling();

        $user = $this->createUserRaw();

        $data = [
            'email' => $user['email'],
            'name' => $user['name'],
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->postJson('/api/register', $data);

        $status = Http::OK;

        $response->assertStatus($status->value);
    }

    public function testCanTokenCreate()
    {
        $user = $this->createUser();

        $data = [
            'email' => $user->email,
            'password' => 'password'
        ];

        $response = $this->postJson('/api/token/create', $data);

        $status = Http::OK;

        $response->assertStatus($status->value);
    }

    /**
     * Test if user can login with email that is not used
     */
    public function testCanNonUserLogin()
    {
        $data = [
            'email' => 'example@email.com',
            'password' => 'password'
        ];

        $response = $this->postJson('/api/login', $data);

        $status = Http::UNPROCESSABLE_ENTITY;

        $response->assertJsonValidationErrors('email')->assertStatus($status->value);
    }
}
