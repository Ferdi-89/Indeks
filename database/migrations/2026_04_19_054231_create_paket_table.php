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
        Schema::create('pakets', function (Blueprint $table) {
            $table->string('id_paket', 5)->primary();
            $table->string('title_paket', 50);
            $table->integer('harga_paket');
            $table->string('id_promosi', 5)->nullable();
            $table->string('nama_tema')->nullable();
            $table->string('warna_bg')->nullable();
            $table->string('warna_font')->nullable();
            $table->string('font_family')->nullable();
            $table->string('warna_border')->nullable();
            $table->string('warna_button')->nullable();
            $table->string('badge_text')->nullable();
            $table->text('point_keunggulan')->nullable();
            $table->timestamps();

            $table->foreign('id_promosi')->references('id_promosi')->on('promosis')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pakets');
    }
};
