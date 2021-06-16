<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Comment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $comment) {
            $comment->bigIncrements('comment_id');
            $comment->bigInteger('author_id')->unsigned();
            $comment->bigInteger('posted_in')->unsigned();
            $comment->string('img')->nullable();
            $comment->text('desc');
            $comment->timestamps();
            $comment->foreign('author_id')->references('id')->on('users');
            $comment->foreign('posted_in')->references('post_id')->on('posts');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
