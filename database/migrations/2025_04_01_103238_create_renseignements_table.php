<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
    public function up(): void
    {
        Schema::create('renseignements', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenoms');
            $table->integer('nb_enfants_0_5')->default(0);
            $table->integer('nb_enfants_6_plus')->default(0);
            $table->string('numero_whatsapp');
            $table->string('numero_enregistrement')->unique(); // Généré après l'inscription
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('renseignements');
    }
};
