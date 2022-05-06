<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistrictVillagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('district_villages', function (Blueprint $table) {
            $table->id();
            $table->string('village')->comment('Село');
            $table->unsignedBigInteger('district_id')->comment('id Региона');

            $table->foreign('district_id')->references('id')->on('region_districts');
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
        Schema::dropIfExists('district_villages');
    }
}
