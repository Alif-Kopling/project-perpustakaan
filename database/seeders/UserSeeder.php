<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'username' => 'admin',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create student user
        User::create([
            'username' => 'siswa1',
            'password' => Hash::make('password'),
            'role' => 'siswa',
        ]);

        // Create additional test user
        User::create([
            'username' => 'test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
    }
}
