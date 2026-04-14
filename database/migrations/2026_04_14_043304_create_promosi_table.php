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
        Schema::table('promosis', function (Blueprint $table) {
            $table->varchar('id_promosi', 5)->primary();
            $table->integer('value_promosi', 10);
            $table->varchar('text_promosi', 255);
            $table->integer('tema', 2);
            $table->dateTime('valid_start');
            $table->dateTime('valid_end');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promosis', function (Blueprint $table) {
            //
        });
    }
};
