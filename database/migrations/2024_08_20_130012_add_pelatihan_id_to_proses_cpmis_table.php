<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('proses_cpmis', function (Blueprint $table) {
            $table->unsignedBigInteger('pelatihan_id')->nullable()->after('id'); // Menambahkan kolom user_id
            $table->foreign('pelatihan_id')->references('id')->on('users')->onDelete('set null'); // Menambahkan foreign key
        });
    }

    public function down(): void
    {
        Schema::table('proses_cpmis', function (Blueprint $table) {
            $table->dropForeign(['pelatihan_id']);
            $table->dropColumn('pelatihan_id');
        });
    }
};
