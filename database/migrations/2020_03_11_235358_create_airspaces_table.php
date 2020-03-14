<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAirspacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airspaces', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('flight_id');
            $table->text('short_overview');
            $table->text('full_overview');
            $table->json('color');
            $table->json('classes');
            $table->json('airports');
            $table->json('advisories');
            $table->timestamps();

            $table->foreign('flight_id')
                ->references('id')->on('flights')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('airspaces');
    }
}
