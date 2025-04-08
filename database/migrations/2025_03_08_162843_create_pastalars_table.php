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
        Schema::create('pastalars', function (Blueprint $table) {
            $table->id();
            $table->string('pasta_adi');
            $table->text('aciklama');
            $table->float('fiyat');
            $table->string('resim_url');
            $table->dateTime('olusturulma_tarihi')->default(Carbon::now());
            $table->dateTime('gunceleme_tarihi')->default(Carbon::now());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pastalars');
    }
};
