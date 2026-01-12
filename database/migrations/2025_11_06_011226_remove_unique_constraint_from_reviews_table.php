<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Supprime d'abord les clés étrangères qui s'appuient sur l'index
            $table->dropForeign(['patient_id']);
            $table->dropForeign(['medecin_id']);

            // Supprime la contrainte unique sur patient_id + medecin_id
            $table->dropUnique(['patient_id', 'medecin_id']);

            // Récrée les clés étrangères individuellement (créera les index nécessaires)
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('medecin_id')->references('id')->on('medecins')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Rétablir la contrainte unique si rollback
            $table->unique(['patient_id', 'medecin_id']);
        });
    }
};
