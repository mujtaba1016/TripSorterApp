<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJourneysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journeys', function (Blueprint $table) {
            $table->increments('id');
            $table->string('DepartureDestination');
            $table->string('finalDestination');
            $table->integer('trip_id')->unsigned();
            $table->foreign('trip_id')->references('id')->on('Trips');
            $table->integer('boarding_id')->unsigned();
            $table->foreign('boarding_id')->references('id')->on('boarding_cards');
            $table->string('transport_type');   
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
        Schema::dropIfExists('journeys');
    }
}
