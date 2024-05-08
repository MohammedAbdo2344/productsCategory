<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=>'IPad pro',
            'description'=>$this->faker->sentence(10),
            'price'=>rand(0.99,99),
            'quantity'=>rand(5,20),
            'category_id'=>'1'
        ];
    }
}
