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
        Schema::create('ordinateurs', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 50);
            $table->string('marque', 50);
            $table->string('modele', 50);
            $table->string('numero_serie', 50)->unique();
            $table->string('adresse_mac', 50)->unique();
            $table->string('adresse_ip', 50)->unique();
            $table->string('systeme_exploitation', 50);
            $table->string('version_systeme_exploitation', 50);
            $table->boolean('actif', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordinateurs');
    }
};
