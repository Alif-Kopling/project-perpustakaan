<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Member;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample members
        Member::create([
            'nama' => 'Budi Santoso',
            'kelas' => 'XII-A',
            'username' => 'siswa1'
        ]);

        Member::create([
            'nama' => 'Ani Lestari',
            'kelas' => 'XI-B',
            'username' => 'ani'
        ]);

        Member::create([
            'nama' => 'Rudi Hartono',
            'kelas' => 'X-A',
            'username' => 'rudi'
        ]);
    }
}