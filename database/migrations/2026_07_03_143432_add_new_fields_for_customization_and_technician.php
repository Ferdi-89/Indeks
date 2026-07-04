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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 30)->default('pengguna')->after('password');
        });

        Schema::table('company_settings', function (Blueprint $table) {
            $table->string('primary_color', 10)->nullable()->after('buka_minggu');
            $table->string('secondary_color', 10)->nullable()->after('primary_color');
            $table->string('accent_color', 10)->nullable()->after('secondary_color');
            $table->integer('biaya_pasang')->default(350000)->after('accent_color');
            $table->string('estimasi_pasang', 50)->default('1-3 Hari Kerja')->after('biaya_pasang');
            $table->text('kelengkapan_pasang')->nullable()->after('estimasi_pasang');
            $table->text('langkah_pasang')->nullable()->after('kelengkapan_pasang');
        });

        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->string('pon_sn', 100)->nullable()->after('status');
            $table->string('wifi_name', 100)->nullable()->after('pon_sn');
            $table->string('wifi_password', 100)->nullable()->after('wifi_name');
            $table->foreignId('installed_by')->nullable()->after('wifi_password')->constrained('users')->onDelete('set null');
            $table->timestamp('installed_at')->nullable()->after('installed_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });

        Schema::table('company_settings', function (Blueprint $table) {
            $table->dropColumn([
                'primary_color',
                'secondary_color',
                'accent_color',
                'biaya_pasang',
                'estimasi_pasang',
                'kelengkapan_pasang',
                'langkah_pasang'
            ]);
        });

        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->dropForeign(['installed_by']);
            $table->dropColumn([
                'pon_sn',
                'wifi_name',
                'wifi_password',
                'installed_by',
                'installed_at'
            ]);
        });
    }
};
