<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Permissões
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'create pages']);
        Permission::create(['name' => 'edit pages']);
        Permission::create(['name' => 'delete pages']);
        Permission::create(['name' => 'create categories']);
        Permission::create(['name' => 'edit categories']);
        Permission::create(['name' => 'delete categories']);
        Permission::create(['name' => 'view pages']);

        // Papéis
        $admin = Role::create(['name' => 'admin']);
        $writer = Role::create(['name' => 'writer']);
        $reader = Role::create(['name' => 'reader']);

        // Atribuir Permissões aos Papéis
        $admin->givePermissionTo(Permission::all());

        $writer->givePermissionTo([
            'create pages',
            'edit pages',
            'view pages',
            'create categories',
            'edit categories',
        ]);

        $reader->givePermissionTo('view pages');
    }
}
