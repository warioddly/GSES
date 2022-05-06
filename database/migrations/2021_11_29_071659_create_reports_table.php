<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_status', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Наименование');
            $table->timestamps();
        });

        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Наименование');
            $table->text('query')->comment('Запрос');
            $table->text('template')->nullable()->comment('Шаблон');
            $table->text('description')->nullable()->comment('Описание');
            $table->unsignedBigInteger('status_id')->nullable()->comment('Статус (report_status.id)');
            $table->timestamps();

            $table->foreign('status_id')->references('id')->on('report_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
        Schema::dropIfExists('report_status');
    }
}
