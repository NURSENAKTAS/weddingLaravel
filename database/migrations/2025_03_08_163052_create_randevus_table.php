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
        Schema::create('randevus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kullanici_id');
            $table->unsignedBigInteger('paket_id');
            $table->string('randevu_türü');
            $table->dateTime('randevu_tarihi');
            $table->string('ozel_istekler')->nullable();
            $table->dateTime('olusturulma_tarihi')->default(Carbon::now());
            $table->dateTime('guncelleme_tarihi')->default(Carbon::now());

            $table->foreign('kullanici_id')->references('id')->on('users');
            $table->foreign('paket_id')->references('id')->on('paketlers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('randevus', function (Blueprint $table) {
            $table->dropForeign(['kullanici_id']);
        });

        // Ödeme tablosu eğer randevus tablosuna referans veriyorsa
        if (Schema::hasTable('odemelers')) {
            Schema::table('odemelers', function (Blueprint $table) {
                if (Schema::hasColumn('odemelers', 'randevu_id')) {
                    $table->dropForeign(['randevu_id']);
                }
            });
        }

        Schema::dropIfExists('randevus');
    }
};
