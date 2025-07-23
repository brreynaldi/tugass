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
        Schema::create('quiz_jawaban_siswa', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('quiz_id');
        $table->unsignedBigInteger('siswa_id');
        $table->unsignedBigInteger('quiz_soal_id');
        $table->char('jawaban', 1); // A, B, C, D
        $table->timestamps();

        $table->foreign('quiz_id')->references('id')->on('quiz')->onDelete('cascade');
        $table->foreign('siswa_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('quiz_soal_id')->references('id')->on('quiz_soal')->onDelete('cascade');
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_jawaban_siswa');
    }
};
