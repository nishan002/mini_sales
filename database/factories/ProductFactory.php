<?php

namespace Database\Factories;

use Faker\Factory as Faker;
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
    public function definition()
    {
        $status = $this->faker->randomElement(['Good', 'Perfect', 'Bad']);
        $description = $this->faker->text();

        return [
            'name' => $this->faker->word(),
            'quantity' => $this->faker->numberBetween(100, 200),
            'description' => $status,
            'purchase_price' => $this->faker->randomFloat(3, 1, 50),
            'sales_price' => $this->faker->randomFloat(3, 1, 50),
            'image' => $this->faker->imageUrl(640, 480, 'food'),
        ];
    }
}
