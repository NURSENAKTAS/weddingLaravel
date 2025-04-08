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
        Schema::create('mekan_randevus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mekan_id');
            $table->unsignedBigInteger('randevus_id');

            $table->foreign('mekan_id')->references('id')->on('mekanlars');
            $table->foreign('randevus_id')->references('id')->on('randevus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mekan_randevus');
    }
};
