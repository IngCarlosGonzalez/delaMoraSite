<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
	           // aqui se definin los roles
	           $role1 = Role::create(['name' => 'superusuario']);
	           $role2 = Role::create(['name' => 'usuariocomun']);
	           $role3 = Role::create(['name' => 'usuariomovil']);

	           // aqui se definen los primeros permisos y se asignan a roles
	           Permission::create(['name' => 'es-super-usuario'])->assignRole($role1);
	           Permission::create(['name' => 'es-usuario-comun'])->assignRole($role2);
	           Permission::create(['name' => 'es-usuario-movil'])->assignRole($role3);
    }
}
