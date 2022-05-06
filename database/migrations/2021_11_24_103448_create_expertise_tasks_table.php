<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpertiseTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Статус
        Schema::create('expertise_task_status', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Наименование');
            $table->timestamps();
        });

        // Задачи перед экспертами
        Schema::create('expertise_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('task')->comment('Задача');
            $table->text('comment')->nullable()->comment('Комментарий');
            $table->unsignedBigInteger('status_id')->nullable()->comment('Статус (expertise_task_status.id)');
            $table->unsignedBigInteger('expertise_id')->nullable()->comment('Экспертиза (expertise.id)');
            $table->unsignedBigInteger('creator_id')->nullable()->comment('Кем создано (users.id)');
            $table->timestamps();

            $table->foreign('status_id')->references('id')->on('expertise_task_status');
            $table->foreign('expertise_id')->references('id')->on('expertise');
            $table->foreign('creator_id')->references('id')->on('users');
        });

        // Эксперты
        Schema::create('expertise_task_experts', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('task_id')->comment('Задачи перед экспертами (expertise_tasks.id)');
            $table->unsignedBigInteger('expert_id')->comment('Эксперт (users.id)');
            $table->timestamps();

            $table->foreign('task_id')->references('id')->on('expertise_tasks')->cascadeOnDelete();
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
        Schema::dropIfExists('expertise_tasks');
        Schema::dropIfExists('expertise_task_status');
        Schema::dropIfExists('expertise_task_experts');
    }
}
