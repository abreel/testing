<?php
use App\Models\User;
use Tests\TestCase;
class SettlementControllerExportsettlementTest extends TestCase{

    public function testExportSettlement_success(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/export_settlement");
        
        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['*' => ['id', 'settlementBank']]]);
    }

    public function testExportSettlement_failure(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint with wrong parameters
        $response = $this->getJson("/export_settlement?wrong_parameter=1");
        
        // Assert the response
        $response->assertStatus(400);
    }

    public function testExportSettlement_badValidation(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint with wrong parameters
        $response = $this->postJson("/export_settlement", ['wrong_param' => 1]);
        
        // Assert the response
        $response->assertStatus(422);
    }
}