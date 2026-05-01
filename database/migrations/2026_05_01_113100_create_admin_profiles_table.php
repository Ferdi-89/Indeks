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
        Schema::create('admin_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('nama_lengkap', 100);
            $table->string('username', 50)->unique();
            $table->string('email', 100);
            $table->string('phone', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->string('avatar_path', 255)->nullable();
            $table->string('role', 30)->default('admin');
            $table->timestamp('last_login_at')->nullable();
            $table->boolean('dark_mode')->default(false);
            $table->boolean('email_notif')->default(true);
            $table->boolean('sound_notif')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_profiles');
    }
};
