<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductAttributeValueTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    private $productAttributeValue;
    private $product;
    private $productAttribute;
    private $category;
    public function setup(): void
    {
        parent::setUp();
        $this->category = Category::factory()->create();
        $this->product = Product::factory()->create();
        $this->productAttribute = ProductAttribute::factory()->create();
        $this->productAttributeValue = ProductAttributeValue::factory()->create();
    }
    public function test_update_product_attribute_value(): void
    {
        $this->putJson(
            route(
                'product_attribute_value.update',
                [
                    'product' => $this->product->id,
                ]
            ),
            [
                'id' => $this->productAttributeValue->id,
                'value' => 'update name',
                'product_attribute_id' => $this->productAttribute->id,
                'product_id' => $this->product->id,
            ]
        );
        $this->assertDatabaseHas('product_attribute_values', [
            'id' => $this->productAttributeValue->id,
            "value" => "update name"
        ]);
    }

    public function test_delete_product_attribute(): void
    {
        $this->deleteJson(
            route(
                "product_attribute_value.destroy",
                [
                    'product' => $this->product->id,
                ]
            ),
            [
                "id" => $this->productAttributeValue->id
            ]
        );
        $this->assertDatabaseMissing("product_attribute_values", ["id" => $this->productAttributeValue->id]);
    }
}
