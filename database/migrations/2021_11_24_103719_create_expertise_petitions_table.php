<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpertisePetitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Тип
        Schema::create('expertise_petition_types', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable()->comment('Наименование');
            $table->timestamps();
        });
        // Статус
        Schema::create('expertise_petition_status', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable()->comment('Наименование');
            $table->timestamps();
        });

        // Хадатайства
        Schema::create('expertise_petitions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expertise_id')->nullable()->comment('Экспертиза (expertise.id)');
            $table->unsignedBigInteger('expert_id')->nullable()->comment('Эксперт (users.id)');
            $table->text('reason')->nullable()->comment('Причина подготовки ходатайства');
            $table->unsignedBigInteger('type_id')->nullable()->comment('Тип (expertise_petition_types.id)');
            $table->unsignedBigInteger('scan_id')->nullable()->comment('Скан документа (documents.id)');
            $table->unsignedBigInteger('status_id')->nullable()->comment('Статус (expertise_petition_status.id)');
            $table->unsignedBigInteger('creator_id')->nullable()->comment('Кем создано (users.id)');
            $table->timestamps();

            $table->foreign('expertise_id')->references('id')->on('expertise');
            $table->foreign('expert_id')->references('id')->on('users');
            $table->foreign('type_id')->references('id')->on('expertise_petition_types');
            $table->foreign('scan_id')->references('id')->on('documents');
            $table->foreign('status_id')->references('id')->on('expertise_petition_status');
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
        Schema::dropIfExists('expertise_petitions');
        Schema::dropIfExists('expertise_petition_status');
        Schema::dropIfExists('expertise_petition_types');
    }
}
