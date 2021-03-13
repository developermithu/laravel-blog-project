<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id'); 
             //unsignedBigInteger better avoid relation error
             // category_id, user_id (_) hole there is no need to define foreign key
            $table->unsignedBigInteger('category_id');
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->string('image')->default('default.jpg');
            $table->text('body');
            $table->integer('view_count')->default(0);
            $table->boolean('status')->default(0);  //false
            $table->timestamps();

            // Delete all posts on delete users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Delete all posts on delete category 
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
