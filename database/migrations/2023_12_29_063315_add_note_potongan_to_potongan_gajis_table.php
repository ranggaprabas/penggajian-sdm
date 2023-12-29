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
        Schema::table('potongan_gajis', function (Blueprint $table) {
            //
            $table->string('note_potongan')->nullable()->after('nilai_potongan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('potongan_gajis', function (Blueprint $table) {
            //
        });
    }
};
