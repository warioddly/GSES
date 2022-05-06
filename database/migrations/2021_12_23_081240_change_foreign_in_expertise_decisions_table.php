<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeForeignInExpertiseDecisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('expertise_decisions', function (Blueprint $table) {
            $table->dropForeign(['expertise_id']);
            $table->foreign(['expertise_id'])
                ->references('id')
                ->on('expertise')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->dropForeign(['court_id']);
            $table->foreign(['court_id'])
                ->references('id')
                ->on('expertise_courts')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->dropForeign(['court_name_id']);
            $table->foreign(['court_name_id'])
                ->references('id')
                ->on('expertise_court_names')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->dropForeign(['creator_id']);
            $table->foreign(['creator_id'])
                ->references('id')
                ->on('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->dropForeign(['file_id']);
            $table->foreign(['file_id'])
                ->references('id')
                ->on('documents')
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
        Schema::table('expertise_decisions', function (Blueprint $table) {
            $table->dropForeign(['expertise_id']);
            $table->foreign(['expertise_id'])
                ->references('id')
                ->on('expertise')
                ->restrictOnDelete()
                ->onUpdate('restrict');

            $table->dropForeign(['court_id']);
            $table->foreign(['court_id'])
                ->references('id')
                ->on('expertise_courts')
                ->restrictOnDelete()
                ->onUpdate('restrict');

            $table->dropForeign(['court_name_id']);
            $table->foreign(['court_name_id'])
                ->references('id')
                ->on('expertise_court_names')
                ->restrictOnDelete()
                ->onUpdate('restrict');

            $table->dropForeign(['creator_id']);
            $table->foreign(['creator_id'])
                ->references('id')
                ->on('users')
                ->restrictOnDelete()
                ->onUpdate('restrict');

            $table->dropForeign(['file_id']);
            $table->foreign(['file_id'])
                ->references('id')
                ->on('documents')
                ->restrictOnDelete()
                ->onUpdate('restrict');
        });
    }
}
