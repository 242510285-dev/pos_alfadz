<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menjalankan migration.
     */
    public function up(): void
    {
        // Mengecek apakah kolom 'deskripsi' belum ada di tabel 'jenis'
        if (!Schema::hasColumn('jenis', 'deskripsi')) {
            Schema::table('jenis', function (Blueprint $table) {
                $table->text('deskripsi')->nullable()->after('nama_jenis');
            });
        }
    }

    /**
     * Membatalkan migration.
     */
    public function down(): void
    {
        if (Schema::hasColumn('jenis', 'deskripsi')) {
            Schema::table('jenis', function (Blueprint $table) {
                $table->dropColumn('deskripsi');
            });
        }
    }
};