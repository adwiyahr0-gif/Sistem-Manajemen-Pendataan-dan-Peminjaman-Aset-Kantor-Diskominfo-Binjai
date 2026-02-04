<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('borrowings', function (Blueprint $blueprint) {
            // Kita tambah kolom alasan setelah kolom status_peminjaman
            // nullable() artinya boleh kosong jika pegawai tidak isi alasan
            $blueprint->text('alasan')->nullable()->after('status_peminjaman');
        });
    }

    public function down(): void
    {
        Schema::table('borrowings', function (Blueprint $blueprint) {
            $blueprint->dropColumn('alasan');
        });
    }
};