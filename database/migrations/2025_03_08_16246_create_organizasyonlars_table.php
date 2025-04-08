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
        Schema::create('organizasyonlars', function (Blueprint $table) {
            $table->id();
            $table->string('organizasyon_türü');
            $table->text('aciklama');
            $table->float('fiyat');
            $table->string('resim_url');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizasyonlars');
    }
};
