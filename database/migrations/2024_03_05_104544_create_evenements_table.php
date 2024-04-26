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
        Schema::create('evenements', function (Blueprint $table) {
            $table->id('id');
            $table->text('description');
            $table->string('image')->nullable();
            $table->timestamp('date_event');
            $table->string('lieu_event');
            $table->integer('nbr_max');
            $table->integer('nbr_participants');

            $table->foreignId('user_id')->constrained('user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evenements');
    }
};