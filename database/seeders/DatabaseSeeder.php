<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Page;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(AdminUserSeeder::class);

        // Cria 10 categorias
        $categories = Category::factory(10)->create();

        // Cria 50 páginas associadas às categorias
        Page::factory(50)->create();
    }
}
