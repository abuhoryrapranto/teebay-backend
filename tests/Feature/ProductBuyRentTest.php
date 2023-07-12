<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductBuyRentTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    public function test_add_product_buy(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer 1|8HfAoFxuUbyphAM0NNEbMKTKoX0i5VKTfyLNbJOf'
        ])->post('http://127.0.0.1:8000/api/v1/order', [
            
            "slug" => "iphone-13-pro",
            "type" => "buy"
        ]);

        $response->assertStatus(201);
    }

    public function test_add_product_rent(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer 1|8HfAoFxuUbyphAM0NNEbMKTKoX0i5VKTfyLNbJOf'
        ])->post('http://127.0.0.1:8000/api/v1/order', [
            
            "slug" => "iphone-13-pro",
            "type" => "rent",
            "rent_from" => "2023-07-13",
            "rent_to" => "2023-07-15"
        ]);

        $response->assertStatus(201);
    }

    public function test_get_product_buy(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer 1|8HfAoFxuUbyphAM0NNEbMKTKoX0i5VKTfyLNbJOf'
        ])->get('http://127.0.0.1:8000/api/v1/order/buy');

        $response->assertStatus(200);
    }

    public function test_get_product_rent(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer 1|8HfAoFxuUbyphAM0NNEbMKTKoX0i5VKTfyLNbJOf'
        ])->get('http://127.0.0.1:8000/api/v1/order/rent');

        $response->assertStatus(200);
    }
}
