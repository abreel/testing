<?php
use App\Models\User;
use Tests\TestCase;
class SettlementControllerExportsettlementtransactiondataTest extends TestCase
{
    /** @test */
    public function it_correctly_responds_with_correct_status_code_and_data_when_required_parameters_are_given()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson('/transaction/export', [
            'start_date' => '2020-05-01',
            'end_date' => '2020-05-31'
        ]);
        
        // Assert the response
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    /** @test */
    public function it_correctly_responds_with_valid_error_when_missing_required_parameters()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson('/transaction/export');
        
        // Assert the response
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['start_date', 'end_date']);
    }

    /** @test */
    public function it_correctly_responds_with_unauthorized_error_when_not_authenticated()
    {
        // Call api endpoint
        $response = $this->postJson('/transaction/export');
        
        // Assert the response
        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Unauthenticated.'
        ]);
    }
}