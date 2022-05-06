<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpertiseConclusionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expertise_conclusions', function (Blueprint $table) {
            $table->unsignedBigInteger('expertise_id')->comment('Экспертиза');
            $table->unsignedBigInteger('document_id')->comment('Документ');
            $table->foreign('expertise_id')->references('id')->on('expertise')->cascadeOnDelete();
            $table->foreign('document_id')->references('id')->on('documents')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expertise_conclusions');
    }
}
