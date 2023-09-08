<?php
use App\Models\User;
use Tests\TestCase;
class SettlementAdminControllerSettlementbatchTest extends TestCase{

    //Successfully Get Settlement Batch
    public function test_successfully_get_settlement_batch(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
                
        // Call api endpoint
        $batchid = 1234;
        $response = $this->getJson("/revsettlements/{$batchid}");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'data' => [
                'statis' => [
                    'total_rev',
                    'pending',
                    'processing',
                    'transaction_split',
                    'failed',
                    'paid',
                    'total',
                    'total_settlement',
                    'charges',
                ],
                'settlement' => [
                    [],
                    []
                ]
            ]
        ]);
    }

    //Failed to Get Settlement Batch
    public function test_failed_to_get_settlement_batch(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
                
        // Call api endpoint
        $batchid = 123;
        $response = $this->getJson("/revsettlements/{$batchid}");

        // Assert the response
        $response->assertStatus(404);
        $response->assertJsonStructure([
            'status',
            'message',
        ]);
    }

}