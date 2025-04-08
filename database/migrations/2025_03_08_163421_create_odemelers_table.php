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
        Schema::create('odemelers', function (Blueprint $table) {
            $table->id();
            $table->UnsignedBigInteger('rezervasyon_id');
            $table->float('tutar');
            $table->dateTime('odeme_tarihi')->default(Carbon::now());
            $table->string('odeme_yontemi');
            $table->enum('odeme_durumu' ,['Onaylandı','Beklemede','Başarısız','İptal Edildi' ])->default('Beklemede');
            $table->dateTime('olusturulma_tarihi')->default(Carbon::now());
            $table->dateTime('guncelleme_tarihi')->default(Carbon::now());

            $table->foreign('rezervasyon_id')->references('id')->on('rezervasyonlars');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('odemelers', function (Blueprint $table) {
            $table->dropForeign(['rezervasyon_id']);
        });
        
        Schema::dropIfExists('odemelers');
    }
};
