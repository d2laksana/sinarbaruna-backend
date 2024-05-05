<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create([
            'bagian' => 'cnc'
        ]);
        User::factory(10)->create([
            'bagian' => 'manual'
        ]);

        User::factory()->create([
            'name' => 'Danu Dwiki Laksana',
            'username' => 'd2laksana',
            'password' => 'password',
            'role' => 'admin'
        ]);
        User::factory()->create([
            'name' => 'Aqsha',
            'username' => 'kusumojakti',
            'password' => 'password',
            'role' => 'manajer'
        ]);
        User::factory()->create([
            'name' => 'Fino',
            'username' => 'finoboyy',
            'password' => 'password',
            'bagian' => 'manual',
            'role' => 'kepala bagian'
        ]);
        User::factory()->create([
            'name' => 'Fajar',
            'username' => 'fajarboy',
            'password' => 'password',
            'bagian' => 'cnc',
            'role' => 'kepala bagian'
        ]);
    }
}
