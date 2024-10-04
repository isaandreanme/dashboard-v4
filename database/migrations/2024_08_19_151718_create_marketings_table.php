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
        Schema::create('marketings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->softDeletes();
            $table->string('foto')->nullable();
            $table->string('code_hk')->nullable();
            $table->string('code_tw')->nullable();
            $table->string('code_sgp')->nullable();
            $table->string('code_my')->nullable();

            $table->string('nomor_hp')->nullable();
            $table->boolean('get_job')->default(false);
            $table->date('tgl_job')->nullable();



            //---------------------------------------------------------------- Applicants Information Sheet 申請人資料

            $table->string('nama')->nullable();
            $table->string('national')->nullable();
            $table->enum('kelamin', ['MALE', 'FEMALE'])->nullable();
            $table->enum('lulusan', ['Elementary School', 'Junior High School', 'Senior Highschool', 'University'])->nullable();
            $table->enum('agama', ['MOESLIM', 'CRISTIAN', 'HINDU', 'BOEDHA'])->nullable();
            $table->unsignedSmallInteger('anakke')->nullable();
            $table->unsignedSmallInteger('brother')->nullable();
            $table->unsignedSmallInteger('sister')->nullable();
            $table->unsignedSmallInteger('usia')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('status_nikah', ['SINGLE', 'MARRIED', 'DIVORCED', 'WIDOW'])->nullable();
            $table->unsignedSmallInteger('tinggi_badan')->nullable();
            $table->unsignedSmallInteger('berat_badan')->nullable();
            $table->string('son')->nullable();
            $table->string('daughter')->nullable();

            //---------------------------------------------------------------- Working Experience 工作經驗

            $table->enum('careofbabies', ['YES', 'NO'])->nullable();
            $table->enum('careoftoddler', ['YES', 'NO'])->nullable();
            $table->enum('careofchildren', ['YES', 'NO'])->nullable();
            $table->enum('careofelderly', ['YES', 'NO'])->nullable();
            $table->enum('careofdisabled', ['YES', 'NO'])->nullable();
            $table->enum('careofbedridden', ['YES', 'NO'])->nullable();
            $table->enum('careofpet', ['YES', 'NO'])->nullable();
            $table->enum('householdworks', ['YES', 'NO'])->nullable();
            $table->enum('carwashing', ['YES', 'NO'])->nullable();
            $table->enum('gardening', ['YES', 'NO'])->nullable();
            $table->enum('cooking', ['YES', 'NO'])->nullable();
            $table->enum('driving', ['YES', 'NO'])->nullable();


            //---------------------------------------------------------------- Overseas Experience 海外工作經驗


            $table->string('hongkong')->nullable();
            $table->string('singapore')->nullable();
            $table->string('taiwan')->nullable();
            $table->string('malaysia')->nullable();
            $table->string('macau')->nullable();
            $table->string('middleeast')->nullable();
            $table->string('other')->nullable();
            $table->string('homecountry')->nullable();

            //---------------------------------------------------------------- Language Skills 語言能力

            $table->enum('spokenenglish', ['POOR', 'FAIR', 'GOOD'])->nullable();
            $table->enum('spokencantonese', ['POOR', 'FAIR', 'GOOD'])->nullable();
            $table->enum('spokenmandarin', ['POOR', 'FAIR', 'GOOD'])->nullable();


            //---------------------------------------------------------------- Remark 備註

            $table->text('remark')->nullable();

            //---------------------------------------------------------------- Previous Duties 過往工作

            $table->json('pengalaman')->nullable();

            //---------------------------------------------------------------- Other Question 其他問題

            $table->enum('babi', ['YES', 'NO'])->nullable();
            $table->enum('liburbukanhariminggu', ['YES', 'NO'])->nullable();
            $table->enum('berbagikamar', ['YES', 'NO'])->nullable();
            $table->enum('takutanjing', ['YES', 'NO'])->nullable();
            $table->enum('merokok', ['YES', 'NO'])->nullable();
            $table->enum('alkohol', ['YES', 'NO'])->nullable();
            $table->enum('pernahsakit', ['YES', 'NO'])->nullable();
            $table->string('ketsakit')->nullable();



            //----------------------------------------------------------------RELASI

            $table->unsignedBigInteger('tujuan_id')->nullable();
            $table->unsignedBigInteger('kantor_id')->nullable();
            $table->unsignedBigInteger('marketing_id')->nullable();
            // $table->unsignedBigInteger('agency_id')->nullable();
            // $table->unsignedBigInteger('sales_id')->nullable();
            $table->unsignedBigInteger('pengalaman_id')->nullable();
            $table->enum('dapatjob', ['YES', 'NO'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marketings');
    }
};
