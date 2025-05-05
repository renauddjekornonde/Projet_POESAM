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
        Schema::create('ressources', function (Blueprint $table) {
            $table->id();
            $table->string('titre', 100);
            $table->text('contenu');
            $table->date('date_ressource')->nullable();
            $table->string('type_ressource')->nullable();
            $table->string('url_ressource')->nullable();
            $table->unsignedBigInteger('id_organisation');
            $table->foreign('id_organisation')->references('id')->on('organisations')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ressources');
    }
};
