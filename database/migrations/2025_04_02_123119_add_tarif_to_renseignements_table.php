<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('renseignements', function (Blueprint $table) {
            $table->integer('enfants_5_10')->default(0); // Nouveau champ pour enfants 5-10 ans
            $table->integer('enfants_11_17')->default(0); // Nouveau champ pour enfants 11-17 ans
            $table->integer('tarif')->default(0); // Champ pour stocker le montant calculé
        });
    }

    public function down(): void
    {
        Schema::table('renseignements', function (Blueprint $table) {
            $table->dropColumn(['enfants_5_10', 'enfants_11_17', 'tarif']);
        });
    }
};
