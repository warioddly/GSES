<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialAnalyzes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_analyzes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('search_material_id')->nullable()->comment('Исходный материал (materials.id)');
            $table->longText('search_text')->comment('Исходный текст');
            $table->longText('result')->comment('Найденный текст');
            $table->unsignedBigInteger('material_id')->nullable()->comment('Найденный материал (materials.id)');
            $table->double('coefficient')->nullable()->comment('Коэфф-т совпадения');
            $table->text('conclusion')->nullable()->comment('Выводы по сравнению материалы');
            $table->timestamps();

            $table->foreign('search_material_id')->references('id')->on('materials')->cascadeOnDelete();
            $table->foreign('material_id')->references('id')->on('materials')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('material_analyzes');
    }
}
