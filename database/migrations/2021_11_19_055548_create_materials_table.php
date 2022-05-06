<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Объект экспертизы
        Schema::create('material_object_types', function(Blueprint $table){
            $table->id();
            $table->string('title')->comment('Наименование');
            $table->timestamps();
        });
        // Тип материала
        Schema::create('material_types', function(Blueprint $table){
            $table->id();
            $table->string('title')->comment('Наименование');
            $table->timestamps();
        });
        Schema::create('material_type_object_types', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('object_type_id')->comment('Объект экспертизы (material_object_types.id)');
            $table->unsignedBigInteger('type_id')->comment('Тип материала (material_types.id)');
            $table->timestamps();

            $table->foreign('object_type_id')->references('id')->on('material_object_types')->cascadeOnDelete();
            $table->foreign('type_id')->references('id')->on('material_types')->cascadeOnDelete();
        });
        // Язык
        Schema::create('material_languages', function(Blueprint $table){
            $table->id();
            $table->string('title')->comment('Наименование');
            $table->string('code')->comment('Код');
            $table->timestamps();
        });

        // Статус материала
        Schema::create('material_status', function(Blueprint $table){
            $table->id();
            $table->string('title')->comment('Наименование');
            $table->timestamps();
        });

        // Статья
        Schema::create('material_articles', function(Blueprint $table){
            $table->id();
            $table->string('title')->comment('Наименование');
            $table->timestamps();
        });

        // Решение суда по признанию материала
        Schema::create('material_court_decisions', function(Blueprint $table){
            $table->id();
            $table->string('title')->comment('Наименование');
            $table->timestamps();
        });

        // Решение суда статус
        Schema::create('material_decision_status', function(Blueprint $table){
            $table->id();
            $table->string('title')->comment('Наименование');
            $table->timestamps();
        });


        // Материалы
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Наименование материала');
            $table->unsignedBigInteger('object_type_id')->nullable()->comment('Объект экспертизы (material_object_types.id)');
            $table->unsignedBigInteger('type_id')->nullable()->comment('Тип материала (material_types.id)');
            $table->unsignedBigInteger('language_id')->nullable()->comment('Язык (material_languages.id)');
            $table->string('source')->nullable()->comment('Источник материала');
            $table->unsignedBigInteger('file_id')->nullable()->comment('Прикрепить исходный файл (documents.id)');
            $table->longText('file_text')->nullable()->comment('Распознанный материал');
            $table->string('file_text_comment')->nullable()->comment('Комментарий к распознанному материалу');
            $table->unsignedBigInteger('status_id')->nullable()->comment('Статус материала (material_status.id)');
            $table->unsignedBigInteger('creator_id')->nullable()->comment('Кем создано (users.id)');
            $table->timestamps();

            $table->foreign('object_type_id')->references('id')->on('material_object_types');
            $table->foreign('type_id')->references('id')->on('material_types');
            $table->foreign('language_id')->references('id')->on('material_languages');
            $table->foreign('status_id')->references('id')->on('material_status');
            $table->foreign('file_id')->references('id')->on('documents');
            $table->foreign('creator_id')->references('id')->on('users');
        });

        // Судебное решение
        Schema::create('material_decisions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('material_id')->comment('Материал (materials.id)');
            $table->unsignedBigInteger('article_id')->nullable()->comment('Статья (material_articles.id)');
            $table->unsignedBigInteger('court_decision_id')->nullable()->comment('Решение суда по признанию материала (material_court_decisions.id)');
            $table->dateTime('date')->nullable()->comment('Дата');
            $table->text('comment')->nullable()->comment('Комментарий');
            $table->unsignedBigInteger('status_id')->comment('Статус (material_decision_status.id)');
            $table->unsignedBigInteger('creator_id')->comment('Кем создано (users.id)');
            $table->timestamps();

            $table->foreign('material_id')->references('id')->on('materials');
            $table->foreign('article_id')->references('id')->on('material_articles');
            $table->foreign('court_decision_id')->references('id')->on('material_court_decisions');
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
        Schema::dropIfExists('material_decisions');
        Schema::dropIfExists('material_decision_status');
        Schema::dropIfExists('materials');
        Schema::dropIfExists('material_type_object_types');
        Schema::dropIfExists('material_object_types');
        Schema::dropIfExists('material_types');
        Schema::dropIfExists('material_languages');
        Schema::dropIfExists('material_status');
        Schema::dropIfExists('material_court_names');
        Schema::dropIfExists('material_courts');
        Schema::dropIfExists('material_articles');
        Schema::dropIfExists('material_court_decisions');
    }
}
