<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom name dan email jika belum ada
            if (!Schema::hasColumn('users', 'name')) {
                $table->string('name')->after('id');
            }
            
            if (!Schema::hasColumn('users', 'email')) {
                $table->string('email')->unique()->after('name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['name', 'email']);
        });
    }
};