<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHealthCheckTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('health_check', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('api_checks');
            $table->timestamps();
        });

        $health_check = new \App\Models\HealthCheck();
        $health_check->api_checks = 0;
        $health_check->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('health_check');
    }
}
