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
        Schema::create('m_doctors', function (Blueprint $table) {
            $table->id();
            $table->string('doctor_name');
            $table->string('doctor_specialist');
            $table->string('doctor_phone');
            $table->string('doctor_email');
            $table->string('doctor_photo')->nullable();
            $table->string('doctor_address');
            $table->string('doctor_sip');
            $table->string('doctor_nik')->nullable();
            $table->string('id_ihs')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_doctors');
    }
};
