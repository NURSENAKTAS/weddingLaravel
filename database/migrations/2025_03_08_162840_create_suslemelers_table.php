<?php

use Carbon\Carbon;
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
        Schema::create('suslemelers', function (Blueprint $table) {
            $table->id();
            $table->string('susleme_adi');
            $table->float('fiyat');
            $table->text('aciklama');
            $table->string('resim_url');
            $table->dateTime('olusturulma_tarihi')->default(Carbon::now());
            $table->dateTime('guncelleme_tarihi')->default(Carbon::now());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suslemelers');
    }
};
