<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReactionsPostsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('reactions_post')) {
            Schema::create('reactions_post', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pub_id')->constrained('publications');
                $table->foreignId('user_id')->constrained('users');
                $table->boolean('hasReaction')->default(false);
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('reactions_post');
    }
}
