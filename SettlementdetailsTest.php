<?php
use App\Models\User;
use Tests\TestCase;
class SplitLogicControllerSettlementdetailsTest extends TestCase{
    public function test_success(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/api/v1/payment/settlement/admin/settlement-details?trans_id=1");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'data' => [
                [
                    'id',
                    'amount',
                    'status',
                    'date_paid'
                ]
            ]
        ]);
    }

    public function test_failure(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/api/v1/payment/settlement/admin/settlement-details?trans_id=");

        // Assert the response
        $response->assertStatus(400);
        $response->assertJsonStructure([
            'status',
            'message',
        ]);
    }

    public function test_bad_validation(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/api/v1/payment/settlement/admin/settlement-details", ['foo' => 'bar']);

        // Assert the response
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'status',
            'message',
            'errors'
        ]);
    }
}