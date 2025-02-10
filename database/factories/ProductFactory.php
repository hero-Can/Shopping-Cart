<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(), // Generates a random word for the product name
            'description' => $this->faker->sentence(10), // Generates a sentence for the product description
            'price' => $this->faker->randomFloat(2, 1, 1000), // Generates a random float for the price (2 decimal points)
            'image' => $this->faker->imageUrl(), // Generates a random image URL
            'stock' => $this->faker->numberBetween(1, 100), // Generates a random number for the stock count
        ];
    }
}
