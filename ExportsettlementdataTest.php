<?php
use App\Models\User;
use Tests\TestCase;
class SettlementControllerExportsettlementdataTest extends TestCase{

    /**
    * Test for successful data export
    *
    * @return void
    */
    public function testSuccessfulDataExport()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/export-settlement", [
            'date' => Carbon::now()->format('Y-m-d')
        ]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertHeader('content-disposition', 'attachment; filename="SETTLEMENT_2020-08-14.xlsx"');
    }

    /**
    * Test for failed data export due to bad request
    *
    * @return void
    */
    public function testFailedDataExportBadRequest()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/export-settlement", [
            'start_date' => Carbon::now()->format('Y-m-d')
        ]);

        // Assert the response
        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'date'
        ]);
    }

    /**
    * Test for failed data export due to unauthorized user
    *
    * @return void
    */
    public function testFailedDataExportUnauthorized()
    {
        // Call api endpoint
        $response = $this->postJson("/export-settlement", [
            'date' => Carbon::now()->format('Y-m-d')
        ]);

        // Assert the response
        $response->assertStatus(401);
    }
}