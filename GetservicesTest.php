<?php
use App\Models\User;
use Tests\TestCase;
class BillsControllerGetservicesTest extends TestCase{

    public function test_success_get_services_for_all_categories(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
                        
        // Call api endpoint
        $response = $this->getJson("/bills/services");
                
        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'mobile_data' => [
                'mtn' => [],
                'glo' => [],
                'airtel' => [],
                '9mobile' => [],
            ],
            'cable_tv' => [
                'dstv' => [],
                'gotv' => [],
                'startimes' => [],
            ],
            'electricity' => [
                'eko' => [],
                'ikeja' => [],
                'ibadan' => [],
                'jos' => [],
                'kano' => [],
                'ph' => [],
                'kaduna' => [],
                'abuja' => [],
                'enugu' => [],
            ],
            'airtime' => [
                'mtn' => [],
                'glo' => [],
                'airtel' => [],
                '9mobile' => [],
            ],
        ]);
    }

    public function test_success_get_services_for_a_specific_category(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
                        
        // Call api endpoint
        $response = $this->getJson("/bills/services?category=mobile_data");
                
        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'mtn' => [],
            'glo' => [],
            'airtel' => [],
            '9mobile' => [],
        ]);
    }

    public function test_success_get_services_for_a_specific_category_and_biller(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
                        
        // Call api endpoint
        $response = $this->getJson("/bills/services?category=airtime&biller=mtn");
                
        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'MTN1GB' => [],
            'MTN2GB' => [],
        ]);
    }

    public function test_failure_get_services_for_invalid_category_and_biller(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
                        
        // Call api endpoint
        $response = $this->getJson("/bills/services?category=internet&biller=mtn");
                
        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(null);
    }

}