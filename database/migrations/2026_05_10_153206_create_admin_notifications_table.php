<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type', 50)->default('info');        // info | success | warning | danger
            $table->string('title', 150);
            $table->text('body')->nullable();
            $table->string('icon', 50)->default('bell');        // bell | user-plus | alert
            $table->string('link_tab', 50)->nullable();         // tab SPA tujuan saat diklik
            $table->string('ref_id', 50)->nullable();           // ID referensi (id_pendaftaran, dll)
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_notifications');
    }
};
