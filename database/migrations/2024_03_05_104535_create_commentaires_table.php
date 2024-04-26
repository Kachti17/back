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
        Schema::create('commentaires', function (Blueprint $table) {
            $table->id('id');
            $table->text('contenu_comm');
            $table->dateTime('date_comm');
            $table->foreignId('pub_id')->constrained('publications');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps(); // Cette ligne ajoutera les colonnes "created_at" et "updated_at"

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commentaires');
    }
};
