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
        Schema::create('organisations', function (Blueprint $table) {
            $table->id();
            $table->string('nom_organisation', 100)->unique();
            $table->string('description_organisation', 255)->nullable();
            $table->string('adresse_organisation', 255)->nullable();
            $table->string('telephone_organisation', 20)->nullable();
            $table->string('email_organisation', 100)->nullable();
            $table->string('site_web_organisation', 100)->nullable();
            $table->string('logo_organisation')->nullable();
            $table->string('type_organisation', 50)->nullable();
            $table->string('pays_organisation', 50)->nullable();
            $table->string('ville_organisation', 50)->nullable();
            $table->string('date_creation_organisation', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organisations');
    }
};
