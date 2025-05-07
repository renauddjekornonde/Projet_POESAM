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
        Schema::create('signalements', function (Blueprint $table) {
            $table->id();
            $table->text('raison');
            $table->dateTime('date_signalement');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('publication_id')->nullable()->constrained('publications')->onDelete('cascade');
            $table->foreignId('commentaire_id')->nullable()->constrained('commentaires')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('signalements');
    }
};
