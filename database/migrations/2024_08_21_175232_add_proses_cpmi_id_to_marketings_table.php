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
        Schema::table('marketings', function (Blueprint $table) {
            $table->unsignedBigInteger('proses_cpmi_id')->nullable();
            $table->foreign('proses_cpmi_id')->references('id')->on('proses_cpmis')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('marketings', function (Blueprint $table) {
            $table->dropForeign(['proses_cpmi_id']);
            $table->dropColumn('proses_cpmi_id');
        });
    }
};
