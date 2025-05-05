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
        Schema::create('reactions', function (Blueprint $table) {
            $table->id();
            $table->string('type', 50); // Type de réaction (like, love, etc.)
            $table->unsignedBigInteger('id_publication'); // ID de la publication qui a réagi
            $table->foreign('id_publication')->references('id')->on('publications')->onDelete('cascade');
            $table->unsignedBigInteger('id_commentaire'); // ID de commentire qui a réagi
            $table->foreign('id_commentaire')->references('id')->on('commentaires')->onDelete('cascade');
            $table->unsignedBigInteger('id_user'); // ID de l'utilisateur qui a réagi
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    // Note: The down method should drop the reactions table
    // and not the publications or commentaires tables.
    // This is important to avoid foreign key constraint errors.
    // The down method should be the reverse of the up method.
    // It should drop the reactions table and remove any foreign key constraints.
    public function down(): void
    {
        Schema::dropIfExists('reactions');
    }
};
