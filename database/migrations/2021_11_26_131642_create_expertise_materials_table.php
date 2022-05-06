<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpertiseMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expertise_materials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expertise_id')->comment('Экспертиза (expertise.id)');
            $table->unsignedBigInteger('material_id')->comment('Материал (materials.id)');
            $table->timestamps();

            $table->foreign('expertise_id')->references('id')->on('expertise')->cascadeOnDelete();
            $table->foreign('material_id')->references('id')->on('materials')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expertise_materials');
    }
}
