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
        Schema::table('borrowings', function (Blueprint $table) {
            // Menambahkan kolom user_id sebagai foreign key yang terhubung ke tabel users
            // Kita letakkan setelah kolom 'id' agar struktur tabel tetap rapi
            $table->foreignId('user_id')
                  ->nullable() 
                  ->after('id')
                  ->constrained('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {
            // Menghapus constraint foreign key dan kolomnya jika di-rollback
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};