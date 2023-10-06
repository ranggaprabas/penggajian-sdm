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
        Schema::table('users', function (Blueprint $table) {
            //
            $table->integer('tunjangan_makan')->nullable()->after('jabatan_id');
            $table->integer('tunjangan_transportasi')->nullable()->after('tunjangan_makan');
            $table->integer('potongan_pinjaman')->nullable()->after('tunjangan_transportasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
