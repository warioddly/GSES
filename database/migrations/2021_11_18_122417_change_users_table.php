<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Lists

        // Должности
        Schema::create('user_positions', function(Blueprint $table){
            $table->id();
            $table->string('title')->comment('Наименование');
            $table->string('code')->comment('Код');
            $table->timestamps();
        });
        // Номенклатурный номер специальности
        Schema::create('user_speciality_numbers', function(Blueprint $table){
            $table->id();
            $table->string('title')->comment('Наименование');
            $table->timestamps();
        });
        // Наименование специальности высшего профильного образования
        Schema::create('user_specialities', function(Blueprint $table){
            $table->id();
            $table->string('title')->comment('Наименование');
            $table->timestamps();
        });
        //
        Schema::create('user_speciality_speciality_numbers', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('speciality_id')->comment('Наименование специальности высшего профильного образования (user_specialities.id)');
            $table->unsignedBigInteger('speciality_number_id')->comment('Номенклатурный номер специальности (user_speciality_numbers.id)');
            $table->timestamps();

            $table->foreign('speciality_id')->references('id')->on('user_specialities')->cascadeOnDelete();
            $table->foreign('speciality_number_id')->references('id')->on('user_speciality_numbers')->cascadeOnDelete();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('last_name')->comment('Фамилия')->after('id');
            $table->string('middle_name')->nullable()->comment('Отчество')->after('name');
            $table->unsignedBigInteger('position_id')->nullable()->comment('Должность (user_positions.id)')->after('middle_name');
            $table->unsignedBigInteger('speciality_id')->nullable()->comment('Наименование специальности высшего профильного образования (user_specialities.id)')->after('position_id');
            $table->unsignedBigInteger('speciality_number_id')->nullable()->comment('Номенклатурный номер специальности (user_speciality_numbers.id)')->after('speciality_id');
            $table->string('academic_degrees')->nullable()->comment('Наличие ученых степеней и званий')->after('speciality_number_id');
            $table->string('speciality_experience')->nullable()->comment('Стаж работы по специальности')->after('academic_degrees');
            $table->string('expert_experience')->nullable()->comment('Стаж экспертной деятельности')->after('academic_degrees');
            $table->unsignedBigInteger('certificate_file_id')->nullable()->comment('Сертификат компетентности (documents.id)')->after('speciality_experience');
            $table->string('certificate_valid')->nullable()->comment('Период действия сертифика')->after('certificate_file_id');
            $table->string('phone')->nullable()->comment('Номер телефона')->after('certificate_valid_to');

            $table->foreign('position_id')->references('id')->on('user_positions');
            $table->foreign('speciality_number_id')->references('id')->on('user_speciality_numbers');
            $table->foreign('speciality_id')->references('id')->on('user_specialities');
            $table->foreign('certificate_file_id')->references('id')->on('documents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_position_id_foreign');
            $table->dropForeign('users_speciality_number_id_foreign');
            $table->dropForeign('users_speciality_id_foreign');

            $table->dropColumn(['last_name', 'middle_name', 'position_id', 'speciality_id',
                'speciality_number_id', 'academic_degrees', 'speciality_experience',
                'certificate_file_id', 'certificate_valid_from', 'certificate_valid_to',
                'phone']);
        });

        Schema::dropIfExists('user_positions');
        Schema::dropIfExists('user_speciality_speciality_numbers');
        Schema::dropIfExists('user_specialities');
        Schema::dropIfExists('user_speciality_numbers');
    }
}
