<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialConclusionOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_conclusion_options', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Наименование');
            $table->timestamps();
        });

        Schema::create('material_conclusion_option', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('conclusion_id')->comment('Решение экспертов (material_conclusions.id)');
            $table->unsignedBigInteger('option_id')->comment('Выбор решения экспертов (material_conclusion_options.id)');

            $table->foreign('conclusion_id')->references('id')->on('material_conclusions')->cascadeOnDelete();
            $table->foreign('option_id')->references('id')->on('material_conclusion_options')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('material_conclusion_option');
        Schema::dropIfExists('material_conclusion_options');
    }
}
