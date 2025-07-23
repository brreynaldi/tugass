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
        Schema::create('quiz_jawaban', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('quiz_id');
        $table->unsignedBigInteger('siswa_id');
        $table->integer('nilai')->nullable(); // nilai akhir dari semua jawaban
        $table->timestamps();

        $table->foreign('quiz_id')->references('id')->on('quiz')->onDelete('cascade');
        $table->foreign('siswa_id')->references('id')->on('users')->onDelete('cascade');
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_jawaban');
    }
};
