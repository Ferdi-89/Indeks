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
        Schema::create('company_settings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perusahaan', 100);
            $table->string('email_perusahaan', 100)->nullable();
            $table->string('telepon_perusahaan', 30)->nullable();
            $table->text('alamat_perusahaan')->nullable();
            $table->string('website', 255)->nullable();
            $table->string('npwp', 30)->nullable();
            $table->string('logo_path', 255)->nullable();
            $table->string('facebook', 255)->nullable();
            $table->string('instagram', 100)->nullable();
            $table->string('whatsapp', 20)->nullable();
            $table->time('jam_buka_weekday')->nullable();
            $table->time('jam_tutup_weekday')->nullable();
            $table->time('jam_buka_sabtu')->nullable();
            $table->time('jam_tutup_sabtu')->nullable();
            $table->boolean('buka_minggu')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_settings');
    }
};
