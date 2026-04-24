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
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->string('id_pendataran', 5)->primary();
            $table->string('nama', 50);
            $table->string('alamat', 100);
            $table->string('id_paket', 3);
            $table->decimal('latitude', 10, 8);
            $table->decimal('longtitude', 11, 8);
            $table->string('email', 100);
            $table->string('nomor_tlpn', 20);
            $table->string('path_gambar', 100);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftarans');
    }
};
