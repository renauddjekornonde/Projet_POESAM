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
        Schema::create('posseders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_role');
            $table->foreign('id_role')->references('id')->on('droits')->onDelete('cascade');
            $table->unsignedBigInteger('id_droit');
            $table->foreign('id_droit')->references('id')->on('droits')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posseders');
    }
};
