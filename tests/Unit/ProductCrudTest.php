<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductCrudTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_product_add(): void
    {
        $request = [
            'title' => "Apple Macbook Pro 2023",
            'category_ids' => [1,2],
            'description' => "It's a greate Product",
            'purchase_price' => 150000,
            'rent_price' => 1200,
            'rent_option' => "day",
        ];

        $product = new Product;
        $product->title = $request['title'];
        $product->slug = $product->generateSlug($request['title']);
        $product->description = $request['description'];
        $product->purchase_price = (float) $request['purchase_price'];
        $product->rent_price = (float) $request['rent_price'];
        $product->rent_option = $request['rent_option'];
        $product->save();

        $data = [
            "product_id" => $product->id,
            "category_id" => 5
        ];

        $productCategory = ProductCategory::insert($data);

        $this->assertEquals($request['title'], $product->title);
        $this->assertEquals($request['description'], $product->description);
        $this->assertEquals($request['purchase_price'], $product->purchase_price);
        $this->assertEquals($request['rent_price'], $product->rent_price);
        $this->assertEquals($request['rent_option'], $product->rent_option);
        
        $this->assertTrue($product->save());
    }

    public function test_product_not_found() : void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer 1|8HfAoFxuUbyphAM0NNEbMKTKoX0i5VKTfyLNbJOf'
        ])->get('http://127.0.0.1:8000/api/v1/product/iphone-13-pro-max');

        $response->assertStatus(404);
    }

    public function test_product_found() : void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer 1|8HfAoFxuUbyphAM0NNEbMKTKoX0i5VKTfyLNbJOf'
        ])->get('http://127.0.0.1:8000/api/v1/product/iphone-13-pro');

        $response->assertStatus(200);
    }

    public function test_product_update(): void
    {
        $request = [
            'purchase_price' => 130000,
            'rent_price' => 1200
        ];

        $product = Product::where('slug', 'apple-macbook-pro-2023')->first();
        $product->purchase_price = (float) $request['purchase_price'];
        $product->rent_price = (float) $request['rent_price'];
        $product->save();
        
        $this->assertTrue($product->save());
    }

    public function test_product_delete() : void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer 1|8HfAoFxuUbyphAM0NNEbMKTKoX0i5VKTfyLNbJOf'
        ])->delete('http://127.0.0.1:8000/api/v1/product/iphone-13-pro');

        $response->assertStatus(200);
    }
    
}
