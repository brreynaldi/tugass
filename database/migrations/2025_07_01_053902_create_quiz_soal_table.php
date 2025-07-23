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
        Schema::create('quiz_soal', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('quiz_id');
        $table->text('pertanyaan');
        $table->string('opsi_a');
        $table->string('opsi_b');
        $table->string('opsi_c');
        $table->string('opsi_d');
        $table->char('jawaban_benar', 1); // A, B, C, atau D
        $table->timestamps();

        $table->foreign('quiz_id')->references('id')->on('quiz')->onDelete('cascade');
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_soal');
    }
};
