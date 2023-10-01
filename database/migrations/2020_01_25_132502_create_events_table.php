<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('group_id');
            $table->text('title');
            $table->text('type');
            $table->text('description');
            $table->unsignedBigInteger('location_id');
            $table->dateTime('start_time');
            $table->text('duration');
            $table->timestamps();

            $table->foreign('group_id')->references('id')->on('groups');
            $table->foreign('location_id')->references('id')->on('locations');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
