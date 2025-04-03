<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('renseignements', function (Blueprint $table) {
            $table->renameColumn('nb_enfants_0_5', 'nb_enfants_5_10');
            $table->renameColumn('nb_enfants_6_plus', 'nb_enfants_11_17');
        });
    }

    public function down(): void
    {
        Schema::table('renseignements', function (Blueprint $table) {
            $table->renameColumn('nb_enfants_0_5', 'nb_enfants_5_10');
            $table->renameColumn('nb_enfants_6_plus', 'nb_enfants_11_17');
        });
    }
};
