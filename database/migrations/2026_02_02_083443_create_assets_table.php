<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('nama_aset');
            $table->string('kode_aset')->unique();
            
            // Tambahkan 'perbaikan' ke dalam list agar tidak error Data Truncated
            $table->enum('status', ['tersedia', 'dipinjam', 'perbaikan'])->default('tersedia');
            
            // Tambahkan kolom kondisi karena di form kita membutuhkannya
            $table->enum('kondisi', ['baik', 'rusak_ringan', 'rusak_berat'])->default('baik');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};