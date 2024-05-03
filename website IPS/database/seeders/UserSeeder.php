<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pengguna;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin1234'),
        ]);

        $admin->assignRole('admin');

        $pengguna = User::create([
            'name' => 'Ahmad Rafif',
            'email' => 'rafif@gmail.com',
            'password' => bcrypt('pengguna1234'),
        ]);

        $pengguna->assignRole('pengguna');

        Pengguna::create([
            'user_id' => $pengguna->id,
            'perangkat_id' => NULL,
            'kode' => '2041720230',
            'jabatan' => 'mahasiswa',
        ]);

        $pengguna2 = User::create([
            'name' => 'Azizi Shafa Asadel',
            'email' => 'azizi@gmail.com',
            'password' => bcrypt('pengguna1234'),
        ]);

        $pengguna2->assignRole('pengguna');

        Pengguna::create([
            'user_id' => $pengguna2->id,
            'perangkat_id' => NULL,
            'kode' => '2041720233',
            'jabatan' => 'mahasiswa',
        ]);
    }
}
