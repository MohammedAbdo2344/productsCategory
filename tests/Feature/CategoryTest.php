<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    private $category;

    public function setup(): void
    {
        parent::setUp();
        $this->category = Category::factory()->create();
    }

    public function test_fetch_all_categories(): void
    {
        $response = $this->getJson(route("category.index"));
        $this->assertEquals(3, count($response->json()));
    }

    public function test_fetch_single_category(): void
    {
        $response = $this->getJson(route('category.show', ['category' => $this->category->id]));
        $this->assertEquals(1, count($response->json()));
    }

    public function test_update_category() : void {
        $this->putJson(
            route("category.update"),
            [
                'id' => $this->category->id,
                'name' => 'update name'
            ]
        );
        $this->assertDatabaseHas('categories', [
            'id' => $this->category->id,
            "name" => "update name"
        ]);
    }

    public function test_destroy_category() : void {
        $this->deleteJson(route("category.destroy"), ["id" => $this->category->id]);
        $this->assertDatabaseMissing("categories", ["id" => $this->category->id]);
    }

    public function test_store_new_category() : void {
        $category = Category::factory()->make();
        $this->postJson(route("category.store"), [
            'name' => $category->name,
            'description' => $category->description
        ])->json();
        $this->assertDatabaseHas("categories", ['name' => $category->name]);
    }

    public function test_while_store_new_category_name_is_required() : void {
        $this->postJson(route("category.store"))
            ->assertJsonValidationErrors(['name'])
            ->json();
    }

    public function test_while_store_new_category_max_name_is_10() : void {
        $this->postJson(route("category.store", ['name' => 'category max is ten']))
            ->assertJsonValidationErrors(['name'])
            ->json();
    }

    public function test_while_store_new_category_min_name_is_3() : void {
        $this->postJson(route("category.store", ['name' => 'ca']))
            ->assertJsonValidationErrors(['name'])
            ->json();
    }

    public function test_while_store_new_category_name_is_unique() : void {
        $this->category = Category::factory()->create(['name' => "fashion"]);
        $this->postJson(route("category.store", ['name' => 'fashion']))
            ->assertJsonValidationErrors(['name'])
            ->json();
    }

    public function test_while_store_new_category_min_description_is_5() : void {
        $this->postJson(route("category.store", ['description' => 'test']))
            ->assertJsonValidationErrors(['description'])
            ->json();
    }
}
