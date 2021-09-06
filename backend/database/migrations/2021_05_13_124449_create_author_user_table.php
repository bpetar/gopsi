<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthorUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('author_user', function (Blueprint $table) {
            $table->id();
            $table->integer('author_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('archived')->default('0');
            $table->timestamps();
            $table->foreign('author_id')->references('id')->on('authors');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('author_user');
    }
}
