<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{

    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('album_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('image');
            $table->string('description');
            $table->foreign('album_id')->references('id')->on('albums')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('views')->default('0');
            $table->timestamps();
            $table->integer('rating')->default('0');
            $table->string('rights');
        });
    }

    public function down()
    {
        Schema::dropIfExists('images');
    }
}
