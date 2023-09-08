

<?php
use Tests\TestCase;
class ContractControllerDeletesubaccountTest extends TestCase{
    public function deleteSubaccountTest(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Create a Subaccount
        $subaccount = ContractSubaccount::factory()->create();
        
        // Call Delete api endpoint
        $response = $this->deleteJson("/delete-subaccount/{$subaccount->id}");
        
        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['success' => true, 'message' => 'Subaccount Deleted sucessfully']);
        $this->assertDatabaseMissing('contract_subaccounts', ['id' => $subaccount->id]);
    }
    
    public function deleteSubaccountNotFoundTest(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call Delete api endpoint
        $response = $this->deleteJson("/delete-subaccount/{$subaccount->id}");
        
        // Assert the response
        $response->assertStatus(404);
        $response->assertJson(['success' => false, 'message' => 'Subaccount not found']);
    }
}