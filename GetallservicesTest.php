<?php
use App\Models\User;
use Tests\TestCase;
class BillsControllerGetallservicesTest extends TestCase
{
    public function testGetAllServicesSuccess()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
       
        // Call api endpoint
        $response = $this->getJson("/bills/services");
        
        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data'
        ]);
    }
    
    public function testGetAllServicesWithCategoryParam()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
       
        // Call api endpoint
        $response = $this->getJson("/bills/services?category=Food");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data'
        ]);
    }
    
    public function testGetAllServicesWithBillerParam()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
       
        // Call api endpoint
        $response = $this->getJson("/bills/services?biller=John");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data'
        ]);
    }
    
    public function testGetAllServicesWithProductParam()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->getJson("/bills/services?product=Bread");
        
        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data'
        ]);
    }
    
    public function testGetAllServicesWithInvalidCategoryParam()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
       
        // Call api endpoint
        $response = $this->getJson("/bills/services?category=test");
        
        // Assert the response
        $response->assertStatus(404);
        $response->assertJsonStructure([
            'success',
            'message',
            'data'
        ]);
    }
    
    public function testGetAllServicesWithInvalidBillerParam()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
       
        // Call api endpoint
        $response = $this->getJson("/bills/services?biller=test");
        
        // Assert the response
        $response->assertStatus(404);
        $response->assertJsonStructure([
            'success',
            'message',
            'data'
        ]);
    }
    
    public function testGetAllServicesWithInvalidProductParam()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->getJson("/bills/services?product=test");
        
        // Assert the response
        $response->assertStatus(404);
        $response->assertJsonStructure([
            'success',
            'message',
            'data'
        ]);
    }
}