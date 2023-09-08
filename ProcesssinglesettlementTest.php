<?php
use App\Models\User;
use App\Models\TransactionSplit;
use Tests\TestCase;
class SettlementAdminControllerProcesssinglesettlementTest extends TestCase{

    public function test_processSingleSettlement_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a settlement
        $settlement = TransactionSplit::factory()->create([
            'status' => 'PENDING'
        ]);

        // Call api endpoint
        $response = $this->postJson("/process-single/{$settlement->settlement_id}");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Settlement processed successfully']);
    }

    public function test_processSingleSettlement_failure()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a settlement
        $settlement = TransactionSplit::factory()->create([
            'status' => 'COMPLETED'
        ]);

        // Call api endpoint
        $response = $this->postJson("/process-single/{$settlement->settlement_id}");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['message' => 'No Settlement for processing']);
    }

}