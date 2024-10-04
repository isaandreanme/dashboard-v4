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
        Schema::table('proses_cpmis', function (Blueprint $table) {
            $table->unsignedBigInteger('pendaftaran_id')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proses_cpmis', function (Blueprint $table) {
            $table->dropColumn('pendaftaran_id');

        });
    }
};
