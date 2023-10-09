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
        Schema::create('komponen_gajis', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('user_nama')->nullable();
            $table->integer('tunjangan_makan')->nullable();
            $table->integer('tunjangan_transportasi')->nullable();
            $table->integer('potongan_pinjaman')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komponen_gajis');
    }
};
