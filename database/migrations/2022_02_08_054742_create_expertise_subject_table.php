<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpertiseSubjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expertise_subject', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('expertise_id')->unsigned();
            $table->bigInteger('subject_id')->unsigned();
            $table->index(['expertise_id', 'subject_id']);

            $table->foreign('expertise_id')
                ->references('id')
                ->on('expertise')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('subject_id')
                ->references('id')
                ->on('subjects')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expertise_subject');
    }
}
