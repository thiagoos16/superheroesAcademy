<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuperheroSuperpowerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('superhero_superpower', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('superhero_id')->unsigned();
            $table->foreign('superhero_id')->references('id')->on('superhero');

            $table->integer('superpower_id')->unsigned();
            $table->foreign('superpower_id')->references('id')->on('superpower');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('superhero_superpower', function(Blueprint $table){
            $table->dropForeign('superhero_id');
        });

        Schema::table('superhero_superpower', function(Blueprint $table){
            $table->dropForeign('superpower_id');
        });

        Schema::dropIfExists('superhero_superpower');
    }
}
