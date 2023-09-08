<?php
use App\Models\User;
                use Tests\TestCase;
                class WalletControllerDebitTest extends TestCase{
                    // Test debit request with valid data
                    public function test_debit_with_valid_data(){
                        // Create a user and authenticate
                        $user = User::factory()->create();
                        $this->actingAs($user);

                        // Create data to send
                        $data = [
                            'wallet_id' => $user->wallet->id,
                            'amount' => 500,
                        ];

                        // Call api endpoint
                        $response = $this->postJson("/debit", $data);
                        
                        // Assert the response
                        $response->assertStatus(201)->assertJson([
                            'status' => true,
                            'message' => 'Wallet debited successfully'
                        ]);
                    }

                    // Test debit request with invalid data
                    public function test_debit_with_invalid_data(){
                        // Create a user and authenticate
                        $user = User::factory()->create();
                        $this->actingAs($user);

                        // Call api endpoint
                        $response = $this->postJson("/debit");
                        
                        // Assert the response
                        $response->assertStatus(400)->assertJson([
                            'status' => false,
                            'message' => 'The wallet id field is required.'
                        ]);
                    }

                    // Test debit request with insufficient fund
                    public function test_debit_with_insufficient_fund(){
                        // Create a user and authenticate
                        $user = User::factory()->create();
                        $this->actingAs($user);

                        // Create data to send
                        $data = [
                            'wallet_id' => $user->wallet->id,
                            'amount' => 100000000000,
                        ];

                        // Call api endpoint
                        $response = $this->postJson("/debit", $data);
                        
                        // Assert the response
                        $response->assertStatus(400)->assertJson([
                            'status' => false,
                            'message' => 'Insufficient Fund'
                        ]);
                    }
                }