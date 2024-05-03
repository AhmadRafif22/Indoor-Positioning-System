<?php

namespace Database\Seeders;

use App\Models\Perangkat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PerangkatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $perangkats = [
            ['mac' => 'E8:DB:84:86:3B:DA'],
            ['mac' => 'B4:E6:2D:3A:22:1A'],
        ];

        foreach ($perangkats as $perangkat) {
            Perangkat::create($perangkat);
        }
    }
}
