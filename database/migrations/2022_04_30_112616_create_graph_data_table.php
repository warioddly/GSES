<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGraphDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('graph_data', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->unsignedBigInteger('Бишкек')->nullable();
            $table->unsignedBigInteger('Ош')->nullable();
            $table->unsignedBigInteger('Ошская область')->nullable();
            $table->unsignedBigInteger('Баткенская область')->nullable();
            $table->unsignedBigInteger('Жалал-Абадская область')->nullable();
            $table->unsignedBigInteger('Чуйская область')->nullable();
            $table->unsignedBigInteger('Нарынская область')->nullable();
            $table->unsignedBigInteger('Иссык-кульская область')->nullable();
            $table->unsignedBigInteger('Таласская область')->nullable();
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
        Schema::dropIfExists('graph_data');
    }
}
