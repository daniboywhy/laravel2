<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->word(); // Use 'unique()' para garantir que cada palavra seja única
    
        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name), // Slug gerado a partir do nome único
            'description' => $this->faker->sentence(),
        ];
    }
}
