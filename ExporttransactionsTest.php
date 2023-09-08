<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;
use App\Services\Exports\TransactionExport;
use Illuminate\Support\Facades\Excel;

class TransactionControllerExporttransactionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function export_transactions_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/payment/transactions/export?from_date=2020-04-20&to_date=2020-04-22");

        // Assert the response
        $response->assertSuccessful();
        $response->assertHeader('Content-Disposition', 'attachment; filename="TRANSACTIONS2020-04-20.xlsx"');
        $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    /** @test */
    public function export_transactions_fails_on_invalid_date_format()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/payment/transactions/export?from_date=2020/04/20&to_date=2020/04/22");

        // Assert the response
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['from_date', 'to_date']);
    }
}