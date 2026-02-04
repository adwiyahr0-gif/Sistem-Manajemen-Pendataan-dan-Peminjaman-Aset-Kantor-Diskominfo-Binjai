<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Tambahkan ini

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            // 1. Tambah kolom kondisi setelah kolom status
            if (!Schema::hasColumn('assets', 'kondisi')) {
                $table->enum('kondisi', ['baik', 'rusak_ringan', 'rusak_berat'])
                      ->default('baik')
                      ->after('status');
            }
        });

        // 2. Update kolom status agar menerima 'perbaikan' 
        // Kita gunakan SQL mentah karena mengubah ENUM lewat Schema Builder sering bermasalah di MariaDB/MySQL
        DB::statement("ALTER TABLE assets MODIFY COLUMN status ENUM('tersedia', 'dipinjam', 'perbaikan') DEFAULT 'tersedia'");
    }

    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            if (Schema::hasColumn('assets', 'kondisi')) {
                $table->dropColumn('kondisi');
            }
        });
        
        // Kembalikan status ke semula jika rollback
        DB::statement("ALTER TABLE assets MODIFY COLUMN status ENUM('tersedia', 'dipinjam') DEFAULT 'tersedia'");
    }
};