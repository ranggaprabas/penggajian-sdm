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
        Schema::create('pinjaman', function (Blueprint $table) {
            $table->id();
            $table->integer('sdm_id')->nullable();
            $table->string('nama')->nullable();
            $table->string('nik')->nullable();
            $table->string('entitas')->nullable();
            $table->string('divisi')->nullable();
            $table->string('jabatan')->nullable();
            $table->integer('nilai_pinjaman')->nullable();
            $table->string('keterangan')->nullable();
            $table->enum('status', ['diproses', 'diterima', 'ditolak'])->default('diproses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pinjamen');
    }
};
