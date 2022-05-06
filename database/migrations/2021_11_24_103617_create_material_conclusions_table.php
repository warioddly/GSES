<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialConclusionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Статус
        Schema::create('material_conclusion_status', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Наименование');
            $table->timestamps();
        });
        // Заключения экспертов
        Schema::create('material_conclusions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('material_id')->nullable()->comment('Материал (materials.id)');
            $table->unsignedBigInteger('file_id')->nullable()->comment('Заключение (documents.id)');
            $table->text('result')->nullable()->comment('Результат');
            $table->unsignedBigInteger('status_id')->nullable()->comment('Статус (material_conclusion_status.id)');
            $table->timestamps();

            $table->foreign('material_id')->references('id')->on('materials')->cascadeOnDelete();
            $table->foreign('status_id')->references('id')->on('material_conclusion_status');
            $table->foreign('file_id')->references('id')->on('documents');
        });

        // Эксперты
        Schema::create('material_conclusion_experts', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('conclusion_id')->comment('Заключения экспертов (material_conclusions.id)');
            $table->unsignedBigInteger('expert_id')->comment('Эксперт (users.id)');
            $table->timestamps();

            $table->foreign('conclusion_id')->references('id')->on('material_conclusions')->cascadeOnDelete();
            $table->foreign('expert_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('material_conclusion_status');
        Schema::dropIfExists('material_conclusion_experts');
        Schema::dropIfExists('material_conclusions');
    }
}
