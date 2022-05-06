<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarkerBlackWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Терминалогия
        Schema::create('marker_terminologies', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Наименование');
            $table->timestamps();
        });
        // Статус
        Schema::create('marker_status', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Наименование');
            $table->timestamps();
        });

        Schema::create('marker_black_words', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('terminology_id')->nullable()->comment('Терминалогия (marker_terminologies.id)');
            $table->string('word')->nullable()->comment('Слово или словосочетание');
            $table->text('declension')->nullable()->comment('Склонение');
            $table->unsignedBigInteger('language_id')->nullable()->comment('Язык (material_languages.id)');
            $table->string('comment')->nullable()->comment('Комментарий к слову ');
            $table->unsignedBigInteger('status_id')->nullable()->comment('Статус (marker_status.id)');
            $table->unsignedBigInteger('creator_id')->nullable()->comment('Кем создано (users.id)');
            $table->timestamps();

            $table->foreign('terminology_id')->references('id')->on('marker_terminologies');
            $table->foreign('language_id')->references('id')->on('material_languages');
            $table->foreign('status_id')->references('id')->on('marker_status');
            $table->foreign('creator_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marker_black_words');
        Schema::dropIfExists('marker_terminologies');
        Schema::dropIfExists('marker_status');
    }
}
