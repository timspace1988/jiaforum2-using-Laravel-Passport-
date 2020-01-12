<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReferences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('topics', function(Blueprint $table){
            //Build foreign key restriction  on topics table
            //When user_id's user was deleted from users table, delete this topic
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('replies', function(Blueprint $table){
            //Build foreign key restriction  on replies
            //When user_id's user was deleted from users table, delete this reply
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            //When topic_id's topic was deleted from topics table, delete this reply
            $table->foreign('topic_id')->references('id')->on('topics')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('topics', function(Blueprint $table){
            //Remove the foreign key restrition on topics table
            $table->dropForeign(['user_id']);
        });

        Schema::table('topics', function(Blueprint $table){
            //Remove the foreign key restrition on replies table
            $table->dropForeign(['user_id']);
            $table->dropForeign(['topic_idsubl']);
        });
    }
}
