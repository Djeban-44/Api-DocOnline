<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ordonnances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained()->onDelete('cascade');
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('medecin_id')->constrained()->onDelete('cascade');
            $table->date('date_prescription');
            $table->date('date_validite');
            $table->text('instructions')->nullable();
            $table->integer('renouvellements')->default(0);
            
            // Champs pour la validation médicale
            $table->boolean('avec_cachet')->default(true);
            
            // Champs pour l'assurance
            $table->boolean('bon_assurance')->default(false);
            $table->string('numero_carte_assurance')->nullable();
            $table->string('organisme_assurance')->nullable();
            
            $table->enum('statut', ['active', 'expiree', 'annulee'])->default('active');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ordonnances');
    }
};