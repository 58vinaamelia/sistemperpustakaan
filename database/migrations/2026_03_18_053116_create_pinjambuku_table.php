<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pinjambuku', function (Blueprint $table) {
            $table->id();

            // 🔹 opsional (boleh dihapus kalau pakai user->name)
            $table->string('nama')->nullable();

            // 🔹 relasi user
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // 🔹 relasi buku
            $table->foreignId('buku_id')
                  ->constrained('buku')
                  ->onDelete('cascade');

            // 🔹 tanggal
            $table->date('tanggal_pinjam');
            $table->date('tanggal_jatuh_tempo');
            $table->date('tanggal_kembali')->nullable();

            // 🔹 denda
            $table->integer('denda')->default(0);

            // 🔥 STATUS FINAL (DISERAGAMKAN)
            $table->enum('status', [
                'pending',     // belum dikonfirmasi
                'dipinjam',    // sudah disetujui & dipinjam
                'ditolak',     // ditolak
                'selesai',     // sudah dikembalikan
                'telat'        // terlambat
            ])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pinjambuku');
    }
};
