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
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nama')->nullable();
            $table->string('nomor_ktp')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('nomor_telp')->nullable();
            $table->string('nomor_kk')->nullable();
            $table->string('nama_wali')->nullable();
            $table->string('nomor_ktp_wali')->nullable();
            $table->string('alamat')->nullable();
            $table->string('rtrw')->nullable();
            $table->date('tanggal_pra_medical')->nullable();
            $table->string('pra_medical')->nullable();
            $table->string('file_medical')->nullable();
            $table->string('file_ktp')->nullable();
            $table->string('file_ktp_wali')->nullable();
            $table->string('file_kk')->nullable();
            $table->string('file_akta_lahir')->nullable();
            $table->string('file_surat_nikah')->nullable();
            $table->string('file_surat_ijin')->nullable();
            $table->string('file_ijazah')->nullable();
            $table->string('file_tambahan')->nullable();
            $table->boolean('data_lengkap')->default(false);
            $table->string('kantor')->nullable();
            $table->string('tujuan')->nullable();
            $table->string('pengalaman')->nullable();
            $table->date('tanggal_pra_bpjs')->nullable();
            $table->string('email_siapkerja')->nullable();
            $table->date('tglsiapkerja')->nullable();
            $table->string('password_siapkerja')->nullable();
            $table->date('tgl_bp2mi')->nullable();
            $table->string('no_id_pmi')->nullable();
            $table->string('file_pp')->nullable();
            $table->date('tanggal_medical_full')->nullable();
            $table->date('tanggal_ec')->nullable();
            $table->date('tanggal_visa')->nullable();
            $table->date('tanggal_bpjs_purna')->nullable();
            $table->date('tanggal_teto')->nullable();
            $table->date('tanggal_pap')->nullable();
            $table->date('tanggal_penerbangan')->nullable();
            $table->date('tanggal_in_toyo')->nullable();
            $table->date('tanggal_in_agency')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftarans');
    }
};
