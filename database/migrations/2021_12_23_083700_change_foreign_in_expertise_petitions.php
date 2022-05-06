<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeForeignInExpertisePetitions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('expertise_petitions', function (Blueprint $table) {
            $table->dropForeign(['expertise_id']);
            $table->foreign(['expertise_id'])
                ->references('id')
                ->on('expertise')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->dropForeign(['expert_id']);
            $table->foreign(['expert_id'])
                ->references('id')
                ->on('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->dropForeign(['type_id']);
            $table->foreign(['type_id'])
                ->references('id')
                ->on('expertise_petition_types')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->dropForeign(['status_id']);
            $table->foreign(['status_id'])
                ->references('id')
                ->on('expertise_petition_status')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->dropForeign(['creator_id']);
            $table->foreign(['creator_id'])
                ->references('id')
                ->on('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->dropForeign(['scan_id']);
            $table->foreign(['scan_id'])
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
        Schema::table('expertise_petitions', function (Blueprint $table) {
            $table->dropForeign(['expertise_id']);
            $table->foreign(['expertise_id'])
                ->references('id')
                ->on('expertise')
                ->restrictOnDelete()
                ->onUpdate('restrict');

            $table->dropForeign(['expert_id']);
            $table->foreign(['expert_id'])
                ->references('id')
                ->on('users')
                ->restrictOnDelete()
                ->onUpdate('restrict');

            $table->dropForeign(['type_id']);
            $table->foreign(['type_id'])
                ->references('id')
                ->on('expertise_petition_types')
                ->restrictOnDelete()
                ->onUpdate('restrict');

            $table->dropForeign(['status_id']);
            $table->foreign(['status_id'])
                ->references('id')
                ->on('expertise_petition_status')
                ->restrictOnDelete()
                ->onUpdate('restrict');

            $table->dropForeign(['creator_id']);
            $table->foreign(['creator_id'])
                ->references('id')
                ->on('users')
                 ->restrictOnDelete()
                ->onUpdate('restrict');

            $table->dropForeign(['scan_id']);
            $table->foreign(['scan_id'])
                ->references('id')
                ->on('documents')
                ->restrictOnDelete()
                ->onUpdate('restrict');
        });
    }
}
