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
        Schema::create('iletisims', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('kullanici_id')->nullable();
            $table->string('ad_soyad');
            $table->string('email');
            $table->text('konu');
            $table->text('mesaj');
            $table->enum('durum',['beklemede','yanıtlandı','kapatıldı'])->default('beklemede');
            $table->date('olusturulma_tarihi')->default(Carbon::now());

            $table->foreign('kullanici_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iletisims');
    }
};
