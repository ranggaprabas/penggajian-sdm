<?php

namespace Database\Seeders;

use App\Models\Entitas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EntitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                "nama" => "Crocodic",
            ],
            [
                "nama" => "Eventy",
            ],
            [
                "nama" => "Reprime",
            ],
            [
                "nama" => "Ta'aruf",
            ],
        ];

        foreach($data as $entitas) {
            Entitas::create($entitas);
        }

    }
}
