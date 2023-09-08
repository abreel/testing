<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Contract\Contract;
use App\Models\User;
use App\Models\Contract\ContractSubaccount;
use Tests\TestCase;

class ContractControllerSubaccountsTest extends TestCase
{
    use RefreshDatabase;

    private $contract;

    protected function setUp(): void
    {
        parent::setUp();
        $this->contract = Contract::factory()->create();
    }

    public function test_subaccounts_success()
    {
        $this->actingAs(User::factory()->create());

        $response = $this->getJson("/subaccounts/{$this->contract->id}");

        $response->assertStatus(200);
        $response->assertExactJson(['success' => true, 'data' => ContractSubaccount::with('user')->where('contract_id', $this->contract->id)->getJson()]);
    }

    public function test_subaccounts_failure()
    {
        $this->actingAs(User::factory()->create());

        $response = $this->getJson('/subaccounts/12345');

        $response->assertStatus(404);
        $response->assertExactJson(['success' => false, 'message' => 'Contract not found']);
    }

    public function test_subaccounts_bad_validation()
    {
        $this->actingAs(User::factory()->create());

        $response = $this->postJson('/subaccounts/12345');

        $response->assertStatus(405);
        $response->assertExactJson(['message' => 'Method Not Allowed']);
    }
}