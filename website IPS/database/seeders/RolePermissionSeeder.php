<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'tambah-pengguna']);
        Permission::create(['name' => 'edit-pengguna']);
        Permission::create(['name' => 'hapus-pengguna']);
        Permission::create(['name' => 'lihat-pengguna']);

        Permission::create(['name' => 'tambah-perangkat']);
        Permission::create(['name' => 'edit-perangkat']);
        Permission::create(['name' => 'hapus-perangkat']);
        Permission::create(['name' => 'lihat-perangkat']);

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'pengguna']);

        $roleAdmin = Role::findByName('admin');
        $roleAdmin->givePermissionTo('tambah-pengguna');
        $roleAdmin->givePermissionTo('edit-pengguna');
        $roleAdmin->givePermissionTo('hapus-pengguna');
        $roleAdmin->givePermissionTo('lihat-pengguna');

        $rolePengguna = Role::findByName('pengguna');
        $rolePengguna->givePermissionTo('edit-pengguna');
        $rolePengguna->givePermissionTo('lihat-pengguna');
    }
}
