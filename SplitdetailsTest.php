<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;

class SettlementAdminControllerSplitdetailsTest extends TestCase
{
    use RefreshDatabase;

    public function test_split_details_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson('/split-details/settlement/merchant');

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'pageType',
            'tabType',
            'data' => [
                'current_page',
                'data' => [
                    0 => [
                        'm_business_name',
                        'm_id',
                        'account_id',
                        'transaction_split_count',
                        'transaction_split_amount',
                        'transaction_count',
                        'transaction_amount',
                        'charges',
                    ]
                ],
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total',
            ],
            'card' => [
                'total_rev',
                'charges',
                'total_settlement',
                'pending',
                'processing',
                'failed',
                'paid',
            ]
        ]);
    }

    public function test_split_details_bad_request()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson('/split-details/');

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson([
            'message' => 'The given data was invalid.'
        ]);
    }

    public function test_split_details_forbidden()
    {
        // Call api endpoint
        $response = $this->getJson('/split-details/settlement/merchant');

        // Assert the response
        $response->assertStatus(403);
        $response->assertJson([
            'message' => 'Unauthorized.'
        ]);
    }

    public function test_split_details_not_found()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson('/split-details/settlement/invalid');

        // Assert the response
        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'Not Found.'
        ]);
    }
}
