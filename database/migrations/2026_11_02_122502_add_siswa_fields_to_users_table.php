<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nis', 20)->nullable()->unique()->after('email');
            $table->string('kelas', 50)->nullable()->after('nis');
            $table->string('foto_profil')->nullable()->after('kelas');
            $table->timestamp('last_login_at')->nullable()->after('foto_profil');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['nis']);
            $table->dropColumn(['nis', 'kelas', 'foto_profil', 'last_login_at']);
        });
    }
};