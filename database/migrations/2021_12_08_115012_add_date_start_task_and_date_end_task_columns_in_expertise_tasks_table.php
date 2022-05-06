<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDateStartTaskAndDateEndTaskColumnsInExpertiseTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('expertise_tasks', function (Blueprint $table) {
            $table->dateTime('date_start')->nullable();
            $table->dateTime('date_end')->nullable();
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
            $table->dropColumn('date_start', 'date_end');
        });
    }
}
