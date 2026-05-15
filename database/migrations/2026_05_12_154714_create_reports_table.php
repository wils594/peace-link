<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {

            $table->id();

            // Type de conflit
            $table->string('type');

            // Description
            $table->text('description');

            // Niveau de danger en %
            $table->integer('danger_level');

            // Ville / zone
            $table->string('zone');

            // Quartier
            $table->string('district');

            // Coordonnées GPS
            $table->double('latitude');

            $table->double('longitude');

            // Signalement anonyme
            $table->boolean('anonymous')->default(true);

            // Statut admin
            $table->string('status')->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};