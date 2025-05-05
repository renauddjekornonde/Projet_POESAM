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
        Schema::create('disposers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_evenement');
            $table->foreign('id_evenement')->references('id')->on('evenements')->onDelete('cascade');
            $table->unsignedBigInteger('id_evenement_categorie');
            $table->foreign('id_evenement_categorie')->references('id')->on('evenement_categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disposers');
    }
};
