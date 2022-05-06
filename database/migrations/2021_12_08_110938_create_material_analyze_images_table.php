<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialAnalyzeImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_analyze_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('search_image_id')->nullable()->comment('Исходное изображение (documents.id)');
            $table->double('coefficient')->nullable()->comment('Коэфф-т совпадения');
            $table->unsignedBigInteger('image_id')->nullable()->comment('Найденное изображение (documents.id)');
            $table->string('size')->nullable()->comment('Исходный размер');
            $table->text('conclusion')->nullable()->comment('Выводы по сравнению материалы');
            $table->timestamps();

            $table->foreign('search_image_id')->references('id')->on('documents')->cascadeOnDelete();
            $table->foreign('image_id')->references('id')->on('documents')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('material_analyze_images');
    }
}
