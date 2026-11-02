<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->date('tanggal_kejadian')->nullable()->after('isi_laporan');
            $table->string('lokasi')->nullable()->after('tanggal_kejadian');
            $table->enum('urgensi', ['rendah', 'sedang', 'tinggi'])->default('sedang')->after('lokasi');
        });

        // Data lama: anggap tanggal kejadian = tanggal laporan dibuat
        DB::table('pengaduans')->whereNull('tanggal_kejadian')->update([
            'tanggal_kejadian' => DB::raw('DATE(created_at)'),
        ]);
    }

    public function down(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->dropColumn(['tanggal_kejadian', 'lokasi', 'urgensi']);
        });
    }
};