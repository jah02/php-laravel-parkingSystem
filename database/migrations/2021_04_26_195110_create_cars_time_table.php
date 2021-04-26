<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars_time', function (Blueprint $table) {
            $table->id();
            $table->integer('car_id')->nullable(false);
            $table->dateTime('arrival_time')->nullable(false);
            $table->dateTime('departure_time')->nullable(true);
            $table->decimal('cost')->nullable(true);
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
        Schema::dropIfExists('cars_time');
    }
}
