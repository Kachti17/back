<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('publications', function (Blueprint $table) {
            $table->id('id');
            $table->timestamp('date_pub')->useCurrent();
            $table->boolean('isApproved');
            $table->unsignedBigInteger('nbr_comm');
            $table->unsignedBigInteger('nbr_react');
            $table->unsignedBigInteger('contenu_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('contenu_id')->references('id')->on('contenus')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publications');
    }
};
