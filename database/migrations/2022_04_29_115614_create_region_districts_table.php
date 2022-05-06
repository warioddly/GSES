<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegionDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('region_districts', function (Blueprint $table) {
            $table->id();
            $table->string('district')->comment('Район');
            $table->unsignedBigInteger('region_id')->comment('id Региона');

            $table->foreign('region_id')->references('id')->on('regions');

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
        Schema::dropIfExists('region_districts');
    }
}
