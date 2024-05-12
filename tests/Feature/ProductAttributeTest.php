<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\ProductAttribute;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductAttributeTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    private $productAttribute;
    private $category;
    public function setup(): void
    {
        parent::setUp();
        $this->category = Category::factory()->create();
        $this->productAttribute = ProductAttribute::factory()->create();
    }
    public function test_fetch_all_product_attribute(): void
    {
        $response = $this->getJson(route('product_attribute.index', ['category' => $this->category->id]));
        $this->assertEquals(1, count($response->json()));
    }
    public function test_fetch_single_product_attribute(): void
    {
        $response = $this->getJson(route('product_attribute.show', ['category' => $this->category->id, 'product_attribute' => $this->productAttribute->id]));
        $this->assertEquals(1, count($response->json()));
    }
    public function test_update_product_attribute(): void
    {
        $this->putJson(
            route(
                'product_attribute.update',
                [
                    'category' => $this->category->id,
                    'product_attribute' => $this->productAttribute->id
                ]
            ),
            [
                'id' => $this->productAttribute->id,
                'name' => 'update name',
                'description' => 'update description',
                'category_id' => $this->category->id
            ]
        );
        $this->assertDatabaseHas('product_attributes', [
            'id' => $this->category->id,
            "name" => "update name"
        ]);
    }

    public function test_delete_product_attribute(): void
    {
        $this->deleteJson(
            route(
                "product_attribute.destroy",
                [
                    'category' => $this->category->id,
                    'product_attribute' => $this->productAttribute->id
                ]
            ),
            [
                "id" => $this->productAttribute->id
            ]
        );
        $this->assertDatabaseMissing("product_attributes", ["id" => $this->productAttribute->id]);
    }

    public function test_store_new_product_attribute(): void
    {
        $category = Category::factory()->make();
        $productAttribute = ProductAttribute::factory()->make();
        $this->postJson(route("product_attribute.store", ['category' => $this->category->id]), [
            'name' => $productAttribute->name,
            'description' => $productAttribute->description,
            'category_id' => $category->id
        ])->json();
        $this->assertDatabaseHas("product_attributes", ['name' => $productAttribute->name]);
    }

    public function test_while_storing_name_is_req(): void
    {
        $this->postJson(
            route(
                "product_attribute.store",
                ['category' => $this->category->id]
            ),
        )
            ->assertJsonValidationErrors(['name'])
            ->json();
    }
    
    public function test_while_storing_name_min_is_3(): void
    {
        $this->postJson(
            route(
                "product_attribute.store",
                ['category' => $this->category->id]
            ),
            [
                'name' => 'mo'
            ]
        )
            ->assertJsonValidationErrors(['name'])
            ->json();
    }

    public function test_while_storing_name_is_max_10(): void
    {
        $this->postJson(
            route(
                "product_attribute.store",
                ['category' => $this->category->id]
            ),
            [
                'name' => 'model nameee '
            ]
        )
            ->assertJsonValidationErrors(['name'])
            ->json();
    }
    public function test_while_storing_descriptin_is_min_5(): void
    {
        $this->postJson(
            route(
                "product_attribute.store",
                ['category' => $this->category->id]
            ),
            [
                'description' => 'mode'
            ]
        )
            ->assertJsonValidationErrors(['description'])
            ->json();
    }
}
