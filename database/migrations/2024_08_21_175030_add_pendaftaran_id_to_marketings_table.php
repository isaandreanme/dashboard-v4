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
        $table->unsignedBigInteger('pendaftaran_id')->nullable(); // Anda dapat menyesuaikan apakah nullable atau tidak
        $table->foreign('pendaftaran_id')->references('id')->on('pendaftarans')->onDelete('cascade'); // Sesuaikan dengan nama tabel pendaftaran Anda
    });
}

public function down(): void
{
    Schema::table('marketings', function (Blueprint $table) {
        $table->dropForeign(['pendaftaran_id']);
        $table->dropColumn('pendaftaran_id');
    });
}

};
