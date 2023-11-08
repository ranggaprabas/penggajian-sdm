<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nama' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123'),
            'is_admin' => true,
            'jenis_kelamin' => 'laki-laki',
            'status' => 1
        ]);

        User::create([
            'nama' => 'rangga',
            'email' => 'ranggaprabaswara1405@gmail.com',
            'password' => bcrypt('123'),
            'is_admin' => true,
            'jenis_kelamin' => 'laki-laki',
            'status' => 0
        ]);
    }
}
