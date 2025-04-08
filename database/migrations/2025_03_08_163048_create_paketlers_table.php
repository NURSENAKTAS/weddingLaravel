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
        Schema::create('paketlers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mekan_id');
            $table->unsignedBigInteger('susleme_id');
            $table->unsignedBigInteger('menu_ogeleri_id');
            $table->unsignedBigInteger('pasta_id');
            $table->unsignedBigInteger('organizasyon_id');

            $table->string('paket_adi');
            $table->decimal('temel_fiyat');
            $table->integer('ekstra_fiyat');
            $table->dateTime('olusturulma_tarihi')->default(Carbon::now());
            $table->dateTime('guncellenme_tarihi')->default(Carbon::now());

            $table->foreign('mekan_id')->references('id')->on('mekanlars');
            $table->foreign('susleme_id')->references('id')->on('suslemelers');
            $table->foreign('menu_ogeleri_id')->references('id')->on('menu_ogeleris');
            $table->foreign('pasta_id')->references('id')->on('pastalars');
            $table->foreign('organizasyon_id')->references('id')->on('organizasyonlars');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paketlers');
    }
};
