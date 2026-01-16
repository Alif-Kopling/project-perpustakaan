<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('nit')->nullable()->after('nama'); // Nomor Induk Siswa/Teknis
            $table->string('jurusan')->nullable()->after('kelas'); // Jurusan
        });

        // Isi data dummy untuk data lama
        DB::table('members')->update([
            'nit' => DB::raw('CONCAT("NIT", id)'),
            'jurusan' => 'Teknik Informatika'
        ]);

        // Buat kolom nit menjadi unique
        Schema::table('members', function (Blueprint $table) {
            $table->unique('nit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn(['nit', 'jurusan']);
        });
    }
};
