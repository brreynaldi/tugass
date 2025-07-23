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
        Schema::create('tugas', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('kelas_id');
        $table->unsignedBigInteger('guru_id'); // user yang role-nya guru
        $table->string('judul');
        $table->text('deskripsi');
        $table->date('tanggal_deadline');
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
        Schema::dropIfExists('tugas');
    }
};
