<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialAnalyzeContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marker_word_types', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Тип слова');
            $table->timestamps();
        });

        Schema::create('marker_words', function (Blueprint $table) {
            $table->id();
            $table->string('word')->comment('Слово или словосочетание');
            $table->unsignedBigInteger('type_id')->comment('Тип слова (marker_word_types.id)');
            $table->integer('word_count')->default(1)->comment('Кол-во слов');
            $table->timestamps();

            $table->unique('word');

            $table->foreign('type_id')->references('id')->on('marker_word_types');
        });

        Schema::create('marker_word_declensions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('word_id')->comment('Основное слово (marker_words.id)');
            $table->unsignedBigInteger('declension_id')->comment('Склонение (marker_words.id)');
            $table->timestamps();

            $table->unique(['word_id', 'declension_id']);

            $table->foreign('word_id')->references('id')->on('marker_words')->cascadeOnDelete();
            $table->foreign('declension_id')->references('id')->on('marker_words')->cascadeOnDelete();
        });

        Schema::create('material_words', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('material_id')->comment('Материал (materials.id)');
            $table->unsignedBigInteger('word_id')->comment('Материал (marker_words.id)');
            $table->unsignedBigInteger('type_id')->comment('Тип слова (marker_word_types.id)');
            $table->integer('frequency')->comment('Частота');

            $table->foreign('material_id')->references('id')->on('materials');
            $table->foreign('word_id')->references('id')->on('marker_words');
            $table->foreign('type_id')->references('id')->on('marker_word_types');

            $table->unique(['material_id', 'word_id']);

            $table->timestamps();
        });

        Schema::create('material_word_positions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('material_word_id')->comment('Слово в метериале (material_words.id)');
            $table->integer('position')->comment('Позиция слова в тектсе');

            $table->foreign('material_word_id')->references('id')->on('material_words')->cascadeOnDelete();

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
        Schema::dropIfExists('material_word_positions');
        Schema::dropIfExists('material_words');
        Schema::dropIfExists('marker_word_declensions');
        Schema::dropIfExists('marker_words');
        Schema::dropIfExists('marker_word_types');
    }
}
