<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeForeignInExpertiseTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('expertise_tasks', function (Blueprint $table) {
            $table->dropForeign(['expertise_id']);
            $table->foreign(['expertise_id'])
                ->references('id')
                ->on('expertise')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->dropForeign(['status_id']);
            $table->foreign(['status_id'])
                ->references('id')
                ->on('expertise_task_status')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->dropForeign(['creator_id']);
            $table->foreign(['creator_id'])
                ->references('id')
                ->on('users')
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
        Schema::table('expertise_tasks', function (Blueprint $table) {
            $table->dropForeign(['expertise_id']);
            $table->foreign(['expertise_id'])
                ->references('id')
                ->on('expertise')
                 ->restrictOnDelete()
                ->onUpdate('restrict');

            $table->dropForeign(['status_id']);
            $table->foreign(['status_id'])
                ->references('id')
                ->on('expertise_task_status')
                 ->restrictOnDelete()
                ->onUpdate('restrict');

            $table->dropForeign(['creator_id']);
            $table->foreign(['creator_id'])
                ->references('id')
                ->on('users')
                 ->restrictOnDelete()
                ->onUpdate('restrict');
        });
    }
}
