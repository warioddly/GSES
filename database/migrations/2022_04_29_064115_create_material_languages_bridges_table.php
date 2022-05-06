<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialLanguagesBridgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_languages_bridges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('material_language_id')->comment('id языка');
            $table->unsignedBigInteger('material_id')->comment('id материала');

            $table->foreign('material_language_id')->references('id')->on('material_languages');
            $table->foreign('material_id')->references('id')->on('materials');

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
        Schema::dropIfExists('material_languages_bridges');
    }
}
