<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengembalian', function (Blueprint $table) {
            if (!Schema::hasColumn('pengembalian', 'status')) {
                $table->string('status')->default('menunggu');
            }

            if (!Schema::hasColumn('pengembalian', 'kondisi_buku')) {
                $table->string('kondisi_buku')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('pengembalian', function (Blueprint $table) {
            if (Schema::hasColumn('pengembalian', 'kondisi_buku')) {
                $table->dropColumn('kondisi_buku');
            }

            if (Schema::hasColumn('pengembalian', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
