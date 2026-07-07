<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('offres', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description');
            $table->string('destination');
            $table->string('pays');
            $table->decimal('prix', 10, 2);
            $table->integer('duree_jours');
            $table->date('date_depart');
            $table->date('date_retour');
            $table->integer('places_totales');
            $table->integer('places_disponibles');
            $table->string('image_principale')->nullable();
            $table->enum('type', ['voyage', 'circuit', 'sejour', 'aventure'])->default('voyage');
            $table->enum('statut', ['active', 'inactive', 'complete'])->default('active');
            $table->boolean('featured')->default(false);
            $table->decimal('prix_promo', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offres');
    }
};