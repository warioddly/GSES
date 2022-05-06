<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Lists

        // Кем назначена экспертиза
        Schema::create('contractor_types', function(Blueprint $table){
            $table->id();
            $table->string('title')->comment('Наименование');
            $table->timestamps();
        });

        // Наименование органа, учреждения
        Schema::create('contractor_organs', function(Blueprint $table){
            $table->id();
            $table->string('title')->comment('Наименование');
            $table->timestamps();
        });

        Schema::create('contractors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_id')->comment('Тип контрагента (contractor_types.id)');
            $table->unsignedBigInteger('organ_id')->nullable()->comment('Наименование органа, учреждения (contractor_organs.id)');
            $table->string('sub_organ')->nullable()->comment('Наименование подразделения органа, учреждения');
            $table->string('last_name')->comment('Фамилия');
            $table->string('name')->comment('Имя');
            $table->string('middle_name')->nullable()->comment('Отчество');
            $table->string('position')->nullable()->comment('Должность');
            $table->string('phone')->nullable()->comment('№ телефона');
            $table->string('email')->nullable()->comment('Электронный адрес');

            $table->unsignedBigInteger('region_id')->nullable()->comment('Регион');
            $table->unsignedBigInteger('district_id')->nullable()->comment('Район');

            $table->unsignedBigInteger('creator_id')->comment('Кем создано (users.id)');
            $table->timestamps();

            $table->foreign('type_id')->references('id')->on('contractor_types');
            $table->foreign('organ_id')->references('id')->on('contractor_organs');
            $table->foreign('creator_id')->references('id')->on('users');

            $table->foreign('region_id')->references('id')->on('regions');
            $table->foreign('district_id')->references('id')->on('region_districts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contractors');
        Schema::dropIfExists('contractor_types');
    }
}
