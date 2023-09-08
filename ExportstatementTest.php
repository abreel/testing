<?php
use App\Models\User;
use Tests\TestCase;
class TransactionControllerExportstatementTest extends TestCase
{
    public function test_export_statement_with_valid_data()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/payment/transactions/export-statement", [
            'from_date' => '2020-01-01',
            'to_date' => '2020-02-01'
        ]);

        // Assert the response
        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->assertHeader('Content-Disposition', 'attachment; filename="STATEMENT2020-02-20.xlsx"');
    }

    public function test_export_statement_with_invalid_data()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/payment/transactions/export-statement", [
            'from_date' => '2020-02-10',
            'to_date' => '2020-01-01'
        ]);

        // Assert the response
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['to_date']);
    }

    public function test_export_statement_without_authentication()
    {
        // Call api endpoint
        $response = $this->postJson("/payment/transactions/export-statement", [
            'from_date' => '2020-01-01',
            'to_date' => '2020-02-01'
        ]);

        // Assert the response
        $response->assertUnauthorized();
    }
}