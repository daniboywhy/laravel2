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
        DB::table('pages')->truncate();
        DB::table('categories')->truncate();

        // Reativa restrições de chave estrangeira
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
