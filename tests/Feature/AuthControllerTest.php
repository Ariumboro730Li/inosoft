<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthControllerTest extends TestCase
{
    /**
     * Test user registration.
     *
     * @return void
     */
    public function testRegister()
    {
        User::where("email", 'john.doe@example.com')->delete();

        $userData = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'password123',
        ];

        $response = $this->post('/api/register', $userData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', ['email' => $userData['email']]);
    }

    /**
     * Test user login.
     *
     * @return void
     */
    public function testLogin()
    {
        $credentials = [
            'email' => 'john.doe@example.com',
            'password' => 'password123',
        ];

        $response = $this->post('/api/login', $credentials);

        $response->assertStatus(200);
        $response->assertJsonStructure(['access_token', 'token_type', 'expires_in']);
    }

    /**
     * Test user logout.
     *
     * @return void
     */
    public function testLogout()
    {
        $user = User::factory()->create();

        $token = auth()->login($user);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->post('/api/logout');

        $response->assertStatus(200);
        $this->assertGuest();
    }

    /**
     * Test token refresh.
     *
     * @return void
     */
    public function testRefresh()
    {
        $user = User::factory()->create();

        $token = auth()->login($user);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->post('/api/refresh');

        $response->assertStatus(200);
        $response->assertJsonStructure(['access_token', 'token_type', 'expires_in']);
    }
}
