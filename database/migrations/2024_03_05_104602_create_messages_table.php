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
        Schema::create('messages', function (Blueprint $table) {
            $table->id('id');
            $table->text('corps');
            $table->unsignedBigInteger('user_id');
            $table->integer('chat_room_id');
           // $table->unsignedBigInteger('userDest_id');
            $table->timestamp('date_envoie');
           // $table->foreign('user_id')->references('id')->on('users');
           // $table->foreign('userDest_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};