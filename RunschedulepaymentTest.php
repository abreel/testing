<?php
use App\Models\User;
                use Tests\TestCase;
                class WalletControllerRunschedulepaymentTest extends TestCase{
                    public function test_run_schedule_payment_success(){
                        // Create a user and authenticate
                        $user = User::factory()->create();
                        $this->actingAs($user);
                        
                        // Call api endpoint
                        $response = $this->postJson("/api/v1/banking/run_schedule_payment");
                
                        // Assert the response
                        $response->assertStatus(200);
                        $response->assertJsonStructure(['success' => ['data']]);
                    }

                    public function test_run_schedule_payment_failure(){
                        // Create a user and authenticate
                        $user = User::factory()->create();
                        $this->actingAs($user);
                        
                        // Call api endpoint
                        $response = $this->postJson("/api/v1/banking/run_schedule_payment");
                
                        // Assert the response
                        $response->assertStatus(400);
                        $response->assertJsonStructure(['error' => ['message']]);
                    }

                    public function test_run_schedule_payment_invalid_data(){
                        // Create a user and authenticate
                        $user = User::factory()->create();
                        $this->actingAs($user);
                        $data = [
                            'invalid_data' => 'invalid_data'
                        ];
                        
                        // Call api endpoint
                        $response = $this->postJson("/api/v1/banking/run_schedule_payment", $data);
                
                        // Assert the response
                        $response->assertStatus(400);
                        $response->assertJsonStructure(['error' => ['message']]);
                    }
                }