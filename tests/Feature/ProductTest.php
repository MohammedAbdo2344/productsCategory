<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    private $product;
    private $category;
    public function setup(): void
    {
        parent::setUp();
        $this->category = Category::factory()->create();
        $this->product = Product::factory()->create();
    }

    public function test_fetch_all_products(): void
    {
        
        $response = $this->getJson(route("products.index"));
        $this->assertEquals(3, count($response->json()));
    }

    public function test_fetch_products_in_single_category(): void
    {
        $response = $this->getJson(route("category.product.show", $this->category->id));
        $this->assertEquals(3, count($response->json()));
    }

    public function test_fetch_single_product(): void
    {
        $response = $this->getJson(route("products.show", $this->product->id));
        $this->assertEquals(1, count($response->json()));
    }

    public function test_update_product(): void
    {
        $this->putJson(
            route("product.update"),
            [
                'id' => $this->product->id,
                'name' => 'update name',
                'description' => 'update description',
                'price' => 500.0,
                'quantity' => 5,
                'category_id' => $this->category->id
            ]
        );
        $this->assertDatabaseHas('products', [
            'id' => $this->category->id,
            "name" => "update name"
        ]);
    }

    public function test_destroy_product(): void
    {
        $this->deleteJson(route("product.destroy"), ["id" => $this->product->id]);
        $this->assertDatabaseMissing("products", ["id" => $this->product->id]);
    }

    public function test_store_new_product(): void
    {
        $category = Category::factory()->make();
        $product = Product::factory()->make();
        $this->postJson(route("products.store"), [
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'quantity' => $product->quantity,
            'category_id' => $category->id
        ])->json();
        $this->assertDatabaseHas("products", ['name' => $product->name]);
    }

    public function test_while_storing_new_product_name_is_required(): void
    {
        $this->postJson(route("products.store"))
            ->assertJsonValidationErrors(['name'])
            ->json();
    }

    public function test_while_storing_new_product_name_max_is_10(): void
    {
        $this->postJson(route("products.store"), ['name' => 'Product name '])
            ->assertJsonValidationErrors(['name'])
            ->json();
    }

    public function test_while_storing_new_product_name_min_is_3(): void
    {
        $this->postJson(route("products.store"), ['name' => 'Pr'])
            ->assertJsonValidationErrors(['name'])
            ->json();
    }

    public function test_while_storing_new_product_name_is_unique(): void
    {
        $this->product = Product::factory()->create(['name' => "Iphone"]);
        $this->postJson(route("products.store"), ['name' => 'Iphone'])
            ->assertJsonValidationErrors(['name'])
            ->json();
    }

    public function test_while_storing_new_product_description_min_is_5(): void
    {
        $this->postJson(route("products.store"), ['description' => 'Pr'])
            ->assertJsonValidationErrors(['description'])
            ->json();
    }

    public function test_while_storing_new_product_price_is_required(): void
    {
        $this->postJson(route("products.store"))
            ->assertJsonValidationErrors(['price'])
            ->json();
    }

    public function test_while_storing_new_product_price_is_decimal_2(): void
    {
        $this->postJson(route("products.store"), ['price' => 90000])
            ->assertJsonValidationErrors(['price'])
            ->json();
    }

    public function test_while_storing_new_product_price_is_not_equal_zero(): void
    {
        $this->postJson(route("products.store"), ['price' => 0.0])
            ->assertJsonValidationErrors(['price'])
            ->json();
    }

    public function test_while_storing_new_product_category_id_required(): void
    {
        $this->postJson(route("products.store"))
            ->assertJsonValidationErrors(['category_id'])
            ->json();
    }

    public function test_while_storing_new_product_quantity_required(): void
    {
        $this->postJson(route("products.store"))
            ->assertJsonValidationErrors(['quantity'])
            ->json();
    }

    public function test_while_storing_new_product_quantity_is_integer(): void
    {
        $this->postJson(route("products.store"),['quantity'=>15.5])
            ->assertJsonValidationErrors(['quantity'])
            ->json();
    }
}
