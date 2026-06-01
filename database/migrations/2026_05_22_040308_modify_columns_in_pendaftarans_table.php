<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->string('id_paket', 5)->change();
            $table->string('alamat', 255)->change();
            $table->string('path_gambar', 255)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->string('id_paket', 3)->change();
            $table->string('alamat', 100)->change();
            $table->string('path_gambar', 100)->nullable(false)->change();
        });
    }
};
