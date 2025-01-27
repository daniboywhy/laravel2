<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

class InfoboxFactory extends Factory
{
    public function definition()
    {
        return [
            'page_id' => Page::factory(), // Relaciona a uma página
            'image_path' => 'infobox_images/default.jpg', // Caminho fixo ou imagem aleatória
            'fields' => [
                'Campo 1' => $this->faker->word(),
                'Campo 2' => $this->faker->word(),
                'Campo 3' => $this->faker->word(),
            ],
        ];
    }
}
