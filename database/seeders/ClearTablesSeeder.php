<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClearTablesSeeder extends Seeder
{
    public function run(): void
    {
        // Desativa restrições de chave estrangeira
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Limpa as tabelas
        DB::table('infoboxes')->truncate();
        DB::table('page_sections')->truncate();
        DB::table('pages')->truncate();
        DB::table('categories')->truncate();
        DB::table('users')->truncate();

        // Reativa restrições de chave estrangeira
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
