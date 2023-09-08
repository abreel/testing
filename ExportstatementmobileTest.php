<?php
use App\Models\User;
use Tests\TestCase;
class TransactionControllerExportstatementmobileTest extends TestCase{

    //Test to check if the statement is downloaded
    public function test_export_statement_mobile_download()
    {
        // Create and authenticate a user
        $user = User::factory()->create();
        $this->actingAs($user);

        //Call the api endpoint
        $response = $this->getJson("/payment/transactions/mobile/export-statement");

        //Assert the response
        $response->assertOk();
        $this->assertTrue($response->headers->contains('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'));
    }

    //Test to check if the statement is sent to email
    public function test_export_statement_mobile_email_success()
    {
        // Create and authenticate a user
        $user = User::factory()->create();
        $this->actingAs($user);

        //Call the api endpoint
        $response = $this->postJson("/payment/transactions/mobile/export-statement", [
            'email' => 'example@example.com',
        ]);

        //Assert the response
        $response->assertSuccessful();
        $response->assertJson([
            'success' => true,
            'message' => 'Statement has been sent to mail',
        ]);
    }

    //Test to check if the statement is sent to email with wrong email
    public function test_export_statement_mobile_email_failure()
    {
        // Create and authenticate a user
        $user = User::factory()->create();
        $this->actingAs($user);

        //Call the api endpoint
        $response = $this->postJson("/payment/transactions/mobile/export-statement", [
            'email' => 'example@example',
        ]);

        //Assert the response
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
    }

}