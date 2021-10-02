<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $user = User::factory()->create();
        $this->user = $user;
    }
    /**
     * A login successful test
     *
     * @return void
     */
    public function test_login()
    {
        $payload = [
            'email' => $this->user->email,
            'password' => 'password'
        ];

        $response = $this->post('/api/login', $payload);
        $response->assertOk();

        $response->assertJsonStructure([
            'success',
            'data' => [
                'token'
            ],
        ]);
    }

    /**
     * A basic login test.
     *
     * @return void
     */
    public function test_login_api_has_wrong_response()
    {
        $payload = [
            'email' => $this->user->email,
            'password' => 'password123'
        ];

        $response = $this->post('/api/login', $payload);
        $response->assertJsonStructure([
            'success',
            'error' => [
                'message',
            ],
        ]);

        $response->assertStatus(HttpResponse::HTTP_UNAUTHORIZED);
    }


    /**
     * A basic register test.
     *
     * @return void
     */
    public function test_register_is_successful()
    {
        $user = User::factory()->make();

        $payload = [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        $response = $this->post('/api/register', $payload);
        $response->assertStatus(HttpResponse::HTTP_OK);

        $registered = User::query()->where('email', $user->email)->firstOrFail();
        $this->assertModelExists($registered);

    }
}
