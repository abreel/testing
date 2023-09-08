<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;
class ReportControllerGetsettlementreportTest extends TestCase{
    use RefreshDatabase;
    public function test_get_settlement_report_success(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->getJson("/reports/settlement");
            
        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [[
            'id',
            'revname',
            'business_name',
            'settlement_bank_name',
            'account_name',
            'account_no',
            'total_transaction_count',
            'settlement_count',
            'transfer_count',
            'card_count',
            'transfer_total',
            'card_total',
            'collection',
            'total_transaction',
            'total_settlement',
            'balance',
            ]],
            'links',
            'meta'
        ]);
    }
    
    public function test_get_settlement_report_failure(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->getJson("/reports/settlement?perPage=string");
            
        // Assert the response
        $response->assertStatus(400);
        $response->assertJsonFragment([
            'message' => 'The given data was invalid',
            'errors' => [
                'perPage' => [
                    'The per page must be an integer.'
                ],
            ],
        ]);
    }
    
    public function test_get_settlement_report_unauthorized(){
        // Call api endpoint
        $response = $this->getJson("/reports/settlement");
            
        // Assert the response
        $response->assertStatus(401);
        $response->assertJsonFragment([
            'message' => 'Unauthenticated.',
        ]);
    }
    
    public function test_get_settlement_report_with_merchant_id_success(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->getJson("/reports/settlement?merchant_id=1");
            
        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [[
            'id',
            'revname',
            'business_name',
            'settlement_bank_name',
            'account_name',
            'account_no',
            'total_transaction_count',
            'settlement_count',
            'transfer_count',
            'card_count',
            'transfer_total',
            'card_total',
            'collection',
            'total_transaction',
            'total_settlement',
            'balance',
            ]],
            'links',
            'meta'
        ]);
    }
}