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
        Schema::create('mekanlars', function (Blueprint $table) {
            $table->id();
            $table->string('mekan_adi');
            $table->text('konum');
            $table->float('fiyat');
            $table->text('aciklama');
            $table->string('resim_url');
            $table->dateTime('olusturulma_tarihi')->default(Carbon::now());
            $table->dateTime('guncelleme_tarihi')->default(Carbon::now());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mekanlars');
    }
};
