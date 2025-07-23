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
        Schema::create('bimbingan_chats', function (Blueprint $t) {
        $t->id();
        $t->foreignId('bimbingan_id')->constrained('bimbingan')->cascadeOnDelete();
        $t->foreignId('sender_id')->constrained('users');
        $t->text('message');
        $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bimbingan_chats');
    }
};
