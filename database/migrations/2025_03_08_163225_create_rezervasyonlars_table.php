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
        Schema::create('rezervasyonlars', function (Blueprint $table) {
            $table->id();
            $table->UnsignedBigInteger('randevu_id');
            $table->enum('rezervasyon_durum' ,['Onaylandı','Beklemede','Başarısız','İptal Edildi' ])->default('Beklemede');
            $table->dateTime('olusturulma_tarihi')->default(Carbon::now());
            $table->dateTime('guncelleme_tarihi')->default(Carbon::now());
            $table->foreign('randevu_id')->references('id')->on('randevus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rezervasyonlars', function (Blueprint $table) {
            $table->dropForeign(['randevu_id']);
        });

        Schema::dropIfExists('rezervasyonlars');
    }
};
