<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageSectionFactory extends Factory
{
    public function definition()
    {
        return [
            'page_id' => Page::factory(), // Relaciona a uma página
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraph(3),
        ];
    }
}
