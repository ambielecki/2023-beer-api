<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeersTable extends Migration
{
    /**a
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('is_public')->default(0);
            $table->text('name');
            $table->text('style')->nullable();
            $table->text('recipe')->nullable();
            $table->text('yeast')->nullable();
            $table->text('brew_notes')->nullable();
            $table->text('tasting_notes')->nullable();
            $table->decimal('original_gravity', 5, 4)->nullable();
            $table->decimal('final_gravity', 5, 4)->nullable();
            $table->dateTime('primary_fermentation_start');
            $table->dateTime('secondary_fermentation_start')->nullable();
            $table->dateTime('bottling')->nullable();
            $table->integer('rating')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('beers');
    }
}
