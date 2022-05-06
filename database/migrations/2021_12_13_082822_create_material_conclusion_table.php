<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialConclusionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_conclusion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('material_id')->comment('Материал (materials.id)');
            $table->unsignedBigInteger('conclusion_id')->comment('Материал (material_conclusions.id)');

            $table->foreign('material_id')->references('id')->on('materials')->cascadeOnDelete();
            $table->foreign('conclusion_id')->references('id')->on('material_conclusions')->cascadeOnDelete();
        });

        Schema::table('material_conclusions', function (Blueprint $table){
            $table->dropForeign('material_conclusions_material_id_foreign');
            $table->dropColumn(['material_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('material_conclusion');

        Schema::table('material_conclusions', function (Blueprint $table){
            $table->unsignedBigInteger('material_id')->nullable()->comment('Материал (materials.id)');

            $table->foreign('material_id')->references('id')->on('materials')->cascadeOnDelete();
        });
    }
}
