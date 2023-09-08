<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;
class WalletControllerStatisticsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void{
        parent::setUp();
        $this->seed();
    }

    /** @test */
    public function test_statistics_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->getJson("/wallets/statistics");
        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'statistics',
            'statistics_two',
            'statistics_three',
            'walletTransaction' => [
                'data' => [
                    '*' => [
                        'id',
                        'wallet_id',
                        'amount',
                        'type',
                        'description',
                        'status',
                        'date',
                    ]
                ],
                'total'
            ],
        ]);
    }

    /** @test */
    public function test_statistics_fail_with_invalid_wallet_id()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/wallets/statistics", [
            'wallet_id' => 999999999
        ]);
        // Assert the response
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['wallet_id']);
    }

    /** @test */
    public function test_statistics_fail_with_invalid_date()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/wallets/statistics", [
            'from' => 'invalid_date'
        ]);
        // Assert the response
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['from']);
    }
}