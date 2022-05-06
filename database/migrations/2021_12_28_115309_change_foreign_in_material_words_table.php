<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeForeignInMaterialWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('material_words', function (Blueprint $table) {
            $table->dropForeign(['word_id']);
            $table->foreign(['word_id'])
                ->references('id')
                ->on('marker_words')
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
        Schema::table('material_words', function (Blueprint $table) {
            $table->dropForeign(['word_id']);
            $table->foreign(['word_id'])
                ->references('id')
                ->on('marker_words')
                ->restrictOnDelete()
                ->onUpdate('restrict');
        });
    }
}
