<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use JustSteveKing\StatusCode\Http;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testHasProductListRouteApi()
    {
        // action
        $response = $this->getJson('api/products');

        $status = Http::OK;

        // assertions
        $response->assertStatus($status->value);

    }

    public function testCanStoreProductApi()
    {
        // preperation
        $user = $this->createUser();
        $product = $this->getProductForUserRaw($user);

        // action
        $response = $this->postJson('api/products', $product);

        $status = Http::CREATED;

        // assertions
        $response->assertStatus($status->value);
    }

    public function testHasShowSingleProductApi()
    {
        // preperation
        $user = $this->createUser();
        $product = $this->createProductForUser($user);

        // action
        $response = $this->getJson("api/products/{$product->id}");

        $this->checkFirstProductData($response, $product);

        $status = Http::OK;

        // assertions
        $response->assertStatus($status->value);
    }

    public function testCanUpdateProductApi()
    {
        // preperation
        $user = $this->createUser();
        $product = $this->createProductForUser($user);

        $data = [
            'title' => 'Updated title',
            'image' => 'https://example-img.test'
        ];

        // action
        $response = $this->putJson("api/products/{$product->id}", $data);

        $status = Http::ACCEPTED;

        // assertions
        $response->assertStatus($status->value);
    }

    public function testCanDestoryProductApi()
    {
        // preperation
        $user = $this->createUser();
        $product = $this->createProductForUser($user);

        // action
        $response = $this->deleteJson("api/products/{$product->id}");

        $status = Http::NO_CONTENT;

        // assertions
        $response->assertStatus($status->value);
    }

    protected function checkFirstProductData($response, Product $product)
    {
        $response->assertJson(fn (AssertableJson $json) =>
            $json->has('0', fn (AssertableJson $json) =>
                $json->where('id', $product->id)
                    ->where('title', $product->title)
                    ->etc()
            )->etc()
        );
    }

    public function createUser(): User
    {
        return User::factory()->create();
    }

    public function createProductForUser(User $user): Product
    {
        return Product::factory()
            ->for($user)
            ->create();
    }

    public function getProductForUserRaw(User $user): array
    {
        return Product::factory()
            ->for($user)
            ->raw();
    }
}
