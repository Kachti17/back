<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantsTable extends Migration
{
    /**
     * Exécuter la migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('evenement_id');
            $table->timestamp('inscription_date')->useCurrent(); // Ajout de la date d'inscription
            // Ajoutez d'autres colonnes si nécessaire

            $table->timestamps();

            // Clés étrangères
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('evenement_id')->references('id')->on('evenements')->onDelete('cascade');
        });
    }

    /**
     * Revenir en arrière la migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participants');
    }
}