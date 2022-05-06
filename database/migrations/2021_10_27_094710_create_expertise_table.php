<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpertiseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Lists

        // Вид экспертизы
        Schema::create('expertise_types', function(Blueprint $table){
            $table->id();
            $table->string('title')->comment('Наименование');
            $table->timestamps();
        });
        // По последовательности проведения
        Schema::create('expertise_sequences', function(Blueprint $table){
            $table->id();
            $table->string('title')->comment('Наименование');
            $table->timestamps();
        });
        // По составу экспертизы
        Schema::create('expertise_compositions', function(Blueprint $table){
            $table->id();
            $table->string('title')->comment('Наименование');
            $table->timestamps();
        });
        // Степень сложности
        Schema::create('expertise_difficulties', function(Blueprint $table){
            $table->id();
            $table->string('title')->comment('Наименование');
            $table->timestamps();
        });
        // Местный суд
        Schema::create('expertise_courts', function(Blueprint $table){
            $table->id();
            $table->string('title')->comment('Наименование');
            $table->timestamps();
        });
        // Наименование местного суда
        Schema::create('expertise_court_names', function(Blueprint $table){
            $table->id();
            $table->string('title')->comment('Наименование');
            $table->unsignedBigInteger('court_id')->comment('Местный суд');
            $table->timestamps();

            $table->foreign('court_id')->references('id')->on('expertise_courts');
        });
        // Статус экспертизы
        Schema::create('expertise_status', function(Blueprint $table){
            $table->id();
            $table->string('title')->comment('Наименование');
            $table->timestamps();
        });
        // Причина выбора статуса
        Schema::create('expertise_status_reasons', function(Blueprint $table){
            $table->id();
            $table->string('title')->comment('Наименование');
            $table->unsignedBigInteger('status_id')->comment('Статус');
            $table->timestamps();

            $table->foreign('status_id')->references('id')->on('expertise_status');
        });
        // Экспертиза
        Schema::create('expertise', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Наименование экспертизы');
            $table->string('number')->nullable()->comment('№ экспертизы');
            $table->string('case_number')->nullable()->comment('Номер дела');
            $table->text('reason')->nullable()->comment('Основания назначения экспертизы');
            $table->string('decree_reg_number')->nullable()->comment('Регистрационные номера постановления (определения)');
            $table->dateTime('receipt_date')->nullable()->comment('Дата поступления материалов');
            $table->dateTime('start_date')->nullable()->comment('Дата начала экспертизы');
            $table->dateTime('expiration_date')->nullable()->comment('Дата окончания производства');
            $table->unsignedBigInteger('contractor_id')->nullable()->comment('ФИО следователя (contractors.id)');
            $table->unsignedBigInteger('cover_id')->nullable()->comment('Сопроводительное лицо (contractors.id)');
            $table->unsignedBigInteger('type_id')->nullable()->comment('Вид экспертизы (expertise_types.id)');
            $table->unsignedBigInteger('sequence_id')->nullable()->comment('По последовательности проведения (expertise_sequences.id)');
            $table->unsignedBigInteger('composition_id')->nullable()->comment('По составу экспертизы (expertise_compositions.id)');
            $table->unsignedBigInteger('difficulty_id')->nullable()->comment('Степень сложности (expertise_difficulties.id)');
            $table->unsignedBigInteger('resolution_id')->nullable()->comment('Постановление (documents.id)');
            $table->unsignedBigInteger('conclusion_id')->nullable()->comment('Заключение (documents.id)');
            $table->text('comment')->nullable()->comment('Примечание');
            $table->unsignedBigInteger('status_id')->nullable()->comment('Статус экспертизы (expertise_status.id)');
            $table->unsignedBigInteger('status_reason_id')->nullable()->comment('Причина (expertise_status_reasons.id)');
            $table->text('questions')->nullable()->comment('Поставленные перед экспертизой вопросы');
            $table->unsignedBigInteger('creator_id')->comment('Кем создано (users.id)');
            $table->boolean('created')->comment('Создано');
            $table->timestamps();

            $table->foreign('contractor_id')->references('id')->on('contractors');
            $table->foreign('cover_id')->references('id')->on('contractors');
            $table->foreign('type_id')->references('id')->on('expertise_types');
            $table->foreign('sequence_id')->references('id')->on('expertise_sequences');
            $table->foreign('composition_id')->references('id')->on('expertise_compositions');
            $table->foreign('difficulty_id')->references('id')->on('expertise_difficulties');
            $table->foreign('resolution_id')->references('id')->on('documents');
            $table->foreign('conclusion_id')->references('id')->on('documents');
            $table->foreign('status_id')->references('id')->on('expertise_status');
            $table->foreign('status_reason_id')->references('id')->on('expertise_status_reasons');
            $table->foreign('creator_id')->references('id')->on('users');
        });

        // Multi select

        // Ответственный/ые
        Schema::create('expertise_experts', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('expertise_id')->comment('Экспертиза (expertise.id)');
            $table->unsignedBigInteger('expert_id')->comment('Эксперт (users.id)');
            $table->timestamps();

            $table->foreign('expertise_id')->references('id')->on('expertise')->cascadeOnDelete();
            $table->foreign('expert_id')->references('id')->on('users')->cascadeOnDelete();
        });

        // Решение суда по экпертизе

        Schema::create('expertise_decisions', function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('expertise_id')->comment('Экспертиза (expertise.id)');
            $table->unsignedBigInteger('court_id')->nullable()->comment('Местный суд (expertise_courts.id)');
            $table->unsignedBigInteger('court_name_id')->nullable()->comment('Наименование местного суда (expertise_court_names.id)');
            $table->dateTime('date')->nullable()->comment('Дата');
            $table->unsignedBigInteger('file_id')->nullable()->comment('Решение суда по экспертизе (documents.id)');
            $table->unsignedBigInteger('creator_id')->nullable()->comment('Кем создано (users.id)');
            $table->timestamps();

            $table->foreign('expertise_id')->references('id')->on('expertise');
            $table->foreign('court_id')->references('id')->on('expertise_courts');
            $table->foreign('court_name_id')->references('id')->on('expertise_court_names');
            $table->foreign('file_id')->references('id')->on('documents');
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
        Schema::dropIfExists('expertise_decisions');
        Schema::dropIfExists('expertise_experts');
        Schema::dropIfExists('expertise');
        Schema::dropIfExists('expertise_court_names');
        Schema::dropIfExists('expertise_courts');
        Schema::dropIfExists('expertise_types');
        Schema::dropIfExists('expertise_sequences');
        Schema::dropIfExists('expertise_compositions');
        Schema::dropIfExists('expertise_difficulties');
        Schema::dropIfExists('expertise_status_reasons');
        Schema::dropIfExists('expertise_status');
    }
}
