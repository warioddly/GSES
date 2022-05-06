<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectNicknamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject_nicknames', function (Blueprint $table) {
            $table->id();
            $table->string('nickname', 1024);
            $table->bigInteger('user_id')->unsigned()->comment('creator');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->bigInteger('subject_id')->unsigned();
            $table->foreign('subject_id')
                ->references('id')
                ->on('subjects')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

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
        Schema::dropIfExists('subject_nicknames');
    }
}
