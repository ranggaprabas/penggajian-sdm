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
        Schema::table('entitas', function (Blueprint $table) {
            //
            $table->string('alamat')->nullable()->after('image');
            $table->boolean('deleted')->default(false)->after('alamat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entitas', function (Blueprint $table) {
            //
        });
    }
};
