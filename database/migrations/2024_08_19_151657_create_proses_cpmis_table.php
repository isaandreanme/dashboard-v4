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
        Schema::create('proses_cpmis', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_pra_bpjs')->nullable();
            $table->date('tanggal_ujk')->nullable();
            $table->date('tglsiapkerja')->nullable();
            $table->string('email_siapkerja')->nullable();
            $table->string('password_siapkerja')->nullable();
            $table->date('tgl_bp2mi')->nullable();
            $table->string('no_id_pmi')->nullable();
            $table->string('file_pp')->nullable(); // Path to the file
            $table->date('tanggal_medical_full')->nullable();
            $table->date('tanggal_ec')->nullable();
            $table->date('tanggal_visa')->nullable();
            $table->date('tanggal_bpjs_purna')->nullable();
            $table->date('tanggal_teto')->nullable();
            $table->date('tanggal_pap')->nullable();
            $table->date('tanggal_penerbangan')->nullable();
            $table->date('tanggal_in_toyo')->nullable();
            $table->date('tanggal_in_agency')->nullable();

            $table->string('file_medical_full')->nullable();
            $table->string('file_ec')->nullable();
            $table->string('file_visa')->nullable();
            $table->string('file_bpjs_purna')->nullable();
            $table->string('file_teto')->nullable();
            $table->string('file_pap')->nullable();
            $table->string('file_penerbangan')->nullable();
            $table->string('file_in_toyo')->nullable();
            $table->string('file_in_agency')->nullable();

            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proses_cpmis');
    }
};
