<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Resetea el caché de roles y permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crea permisos
        Permission::create(['name' => 'usar api admin']);
        Permission::create(['name' => 'usar api general']);

        // Al Rol admin le daremos todos los permisos
        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());

        // Creamos un rol 'user' y le asignamos sólo un permiso
        $role = Role::create(['name' => 'user']);
        $role->givePermissionTo('usar api general');
    }
}
