<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlackEntitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entities', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Дата запрета');;
            $table->string('address')->nullable()->comment('Адрес');
            $table->string('phone')->nullable()->comment('Телефон');
            $table->string('email')->nullable()->comment('Почта');
            $table->string('site')->nullable()->comment('Сайт');
            $table->date('start_date')->nullable()->comment('Дата начала деятельности');
            $table->date('end_date')->nullable()->comment('Дата окончания деятельности');
            $table->timestamps();
        });

        Schema::create('entity_forbidden', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('entity_id')->comment('Организация');
            $table->date('date')->nullable()->comment('Дата запрета');
            $table->text('reason')->nullable()->comment('Причина');
            $table->timestamps();

            $table->foreign('entity_id')->references('id')->on('entities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entity_forbidden');
        Schema::dropIfExists('entities');
    }
}
