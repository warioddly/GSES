<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeExpertiseTypeMultiple extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('expertise', function (Blueprint $table){
            $table->dropForeign('expertise_type_id_foreign');

            $table->dropColumn(['type_id']);
        });

        Schema::create('expertise_type', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expertise_id')->comment('Экспертиза (expertise.id)' );
            $table->unsignedBigInteger('type_id')->comment('Вид экспертизы (expertise_types.id)' );
            $table->timestamps();

            $table->foreign('expertise_id')->references('id')->on('expertise')->cascadeOnDelete();
            $table->foreign('type_id')->references('id')->on('expertise_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expertise', function (Blueprint $table){
            $table->unsignedBigInteger('type_id')->nullable()->after('contractor_id')->comment('Вид экспертизы (expertise_types.id)');

            $table->foreign('type_id')->references('id')->on('expertise_types');
        });

        Schema::dropIfExists('expertise_type');
    }
}
