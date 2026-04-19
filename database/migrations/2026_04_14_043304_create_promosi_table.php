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
        Schema::create('promosis', function (Blueprint $table) {
            $table->string('id_promosi', 5)->primary();
            $table->integer('value_promosi');
            $table->string('text_promosi', 255);
            $table->integer('tema');
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
        Schema::dropIfExists('promosis');
    }
};
