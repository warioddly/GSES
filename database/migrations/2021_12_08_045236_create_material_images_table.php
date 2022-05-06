<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('file_id')->comment('Материал (documents.id)');
            $table->unsignedBigInteger('image_id')->comment('Документ (documents.id)');
            $table->timestamps();

            $table->foreign('file_id')->references('id')->on('documents')->cascadeOnDelete();
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
        Schema::dropIfExists('material_images');
    }
}
