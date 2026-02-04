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
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel assets
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
            $table->string('nama_peminjam');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->nullable();
            
            // Tambahkan 'pending', 'disetujui', dan 'ditolak' agar sistem peminjaman lengkap
            $table->enum('status_peminjaman', ['pending', 'disetujui', 'ditolak', 'selesai'])
                  ->default('pending');
                  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};