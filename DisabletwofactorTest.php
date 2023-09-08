<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;

class TwoFAControllerDisabletwofactorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_disables_2fa_for_authenticated_user()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/2fa/disable");

        // Assert the response
        $response->assertStatus(201);
        $response->assertExactJson([
            'success' => true,
            'message' => '2FA settings has been disabled'
        ]);
    }

    /** @test */
    public function it_responds_with_unauthorized_when_not_authenticated_user_try_to_disable_2fa()
    {
        // Call api endpoint
        $response = $this->postJson("/2fa/disable");

        // Assert the response
        $response->assertStatus(401);
        $response->assertExactJson([
            'success' => false,
            'message' => 'Unauthenticated.'
        ]);
    }
}
