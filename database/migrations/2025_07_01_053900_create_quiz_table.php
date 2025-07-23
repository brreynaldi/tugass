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
        Schema::create('quiz', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('kelas_id');
        $table->unsignedBigInteger('guru_id');
        $table->string('judul');
        $table->date('tanggal_mulai');
        $table->date('tanggal_selesai');
        $table->timestamps();

        $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
        $table->foreign('guru_id')->references('id')->on('users')->onDelete('cascade');
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz');
    }
};
