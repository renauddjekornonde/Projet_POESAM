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
        Schema::create('cases', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('status', ['en_cours', 'résolu', 'en_attente']);
            $table->enum('type', ['harcèlement', 'agression', 'discrimination', 'autre']);
            $table->unsignedBigInteger('organisation_id');
            $table->unsignedBigInteger('victim_id')->nullable();
            $table->timestamps();

            $table->foreign('organisation_id')->references('id')->on('users');
            $table->foreign('victim_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cases');
    }
};
