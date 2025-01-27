<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\Infobox;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Criar 10 categorias
        Category::factory(10)->create()->each(function ($category) {
            // Criar 10 páginas para cada categoria
            Page::factory(10)->create(['category_id' => $category->id])->each(function ($page) {
                // Criar 3 seções para cada página
                PageSection::factory(3)->create(['page_id' => $page->id]);

                // Criar uma infobox para cada página
                Infobox::factory()->create(['page_id' => $page->id]);
            });
        });
    }
}
