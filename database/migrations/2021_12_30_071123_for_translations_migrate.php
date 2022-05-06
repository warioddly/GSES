<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ForTranslationsMigrate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contractor_organs', function (Blueprint $table) {
            $table->string('title', 1024)->change();
        });
        Schema::table('contractor_types', function (Blueprint $table) {
            $table->string('title', 1024)->change();
        });
        Schema::table('document_templates', function (Blueprint $table) {
            $table->string('title', 1024)->change();
        });
        Schema::table('document_template_status', function (Blueprint $table) {
            $table->string('title', 1024)->change();
        });
        //TODO:: Тут все нормально, почему-то не работает. И пока ручную меняю внутри БД
//        Schema::table('expertise', function (Blueprint $table) {
//            $table->string('name',1024)->change();
//        });
        Schema::table('expertise_compositions', function (Blueprint $table) {
            $table->string('title', 1024)->change();
        });
        Schema::table('expertise_courts', function (Blueprint $table) {
            $table->string('title', 1024)->change();
        });
        Schema::table('expertise_court_names', function (Blueprint $table) {
            $table->string('title', 2048)->change();
        });
        Schema::table('expertise_difficulties', function (Blueprint $table) {
            $table->string('title', 1024)->change();
        });
        Schema::table('expertise_petition_status', function (Blueprint $table) {
            $table->string('title', 1024)->change();
        });
        Schema::table('expertise_sequences', function (Blueprint $table) {
            $table->string('title', 1024)->change();
        });
        Schema::table('expertise_status', function (Blueprint $table) {
            $table->string('title', 1024)->change();
        });
        Schema::table('expertise_status_reasons', function (Blueprint $table) {
            $table->string('title', 2048)->change();
        });
        Schema::table('expertise_tasks', function (Blueprint $table) {
            $table->string('task', 2048)->change();
        });
        Schema::table('expertise_task_status', function (Blueprint $table) {
            $table->string('title', 1024)->change();
        });
        Schema::table('expertise_types', function (Blueprint $table) {
            $table->string('title', 1024)->change();
        });
        Schema::table('marker_status', function (Blueprint $table) {
            $table->string('title', 1024)->change();
        });
        Schema::table('marker_terminologies', function (Blueprint $table) {
            $table->string('title', 1024)->change();
        });
        Schema::table('marker_word_types', function (Blueprint $table) {
            $table->string('title', 1024)->change();
        });
        Schema::table('materials', function (Blueprint $table) {
            $table->string('name', 1024)->change();
        });
        Schema::table('material_articles', function (Blueprint $table) {
            $table->string('title', 1024)->change();
        });
        Schema::table('material_conclusion_options', function (Blueprint $table) {
            $table->string('title', 1024)->change();
        });
        Schema::table('material_conclusion_status', function (Blueprint $table) {
            $table->string('title', 1024)->change();
        });
        Schema::table('material_court_decisions', function (Blueprint $table) {
            $table->string('title', 1024)->change();
        });
        Schema::table('material_decision_status', function (Blueprint $table) {
            $table->string('title', 1024)->change();
        });
        Schema::table('material_languages', function (Blueprint $table) {
            $table->string('title', 1024)->change();
        });
        Schema::table('material_object_types', function (Blueprint $table) {
            $table->string('title', 1024)->change();
        });
        Schema::table('material_status', function (Blueprint $table) {
            $table->string('title', 1024)->change();
        });
        Schema::table('material_types', function (Blueprint $table) {
            $table->string('title', 1024)->change();
        });
        Schema::table('reports', function (Blueprint $table) {
            $table->string('name', 1024)->change();
        });
        Schema::table('report_status', function (Blueprint $table) {
            $table->string('title', 1024)->change();
        });
        Schema::table('user_positions', function (Blueprint $table) {
            $table->string('title', 1024)->change();
        });
        Schema::table('user_specialities', function (Blueprint $table) {
            $table->string('title', 1024)->change();
        });
        Schema::table('user_statuses', function (Blueprint $table) {
            $table->string('title', 1024)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contractor_organs', function (Blueprint $table) {
            $table->string('title')->change();
        });
        Schema::table('contractor_types', function (Blueprint $table) {
            $table->string('title')->change();
        });
        Schema::table('document_templates', function (Blueprint $table) {
            $table->string('title')->change();
        });
        Schema::table('document_template_status', function (Blueprint $table) {
            $table->string('title')->change();
        });
        //TODO:: Тут все нормально, почему-то не работает. И пока ручную меняю внутри БД
//        Schema::table('expertise', function (Blueprint $table) {
//            $table->string('name')->change();
//        });
        Schema::table('expertise_compositions', function (Blueprint $table) {
            $table->string('title')->change();
        });
        Schema::table('expertise_courts', function (Blueprint $table) {
            $table->string('title')->change();
        });
        Schema::table('expertise_court_names', function (Blueprint $table) {
            $table->string('title')->change();
        });
        Schema::table('expertise_difficulties', function (Blueprint $table) {
            $table->string('title')->change();
        });
        Schema::table('expertise_petition_status', function (Blueprint $table) {
            $table->string('title')->change();
        });
        Schema::table('expertise_sequences', function (Blueprint $table) {
            $table->string('title')->change();
        });
        Schema::table('expertise_status', function (Blueprint $table) {
            $table->string('title')->change();
        });
        Schema::table('expertise_status_reasons', function (Blueprint $table) {
            $table->string('title')->change();
        });
        Schema::table('expertise_tasks', function (Blueprint $table) {
            $table->string('task')->change();
        });
        Schema::table('expertise_task_status', function (Blueprint $table) {
            $table->string('title')->change();
        });
        Schema::table('expertise_types', function (Blueprint $table) {
            $table->string('title')->change();
        });
        Schema::table('marker_status', function (Blueprint $table) {
            $table->string('title')->change();
        });
        Schema::table('marker_terminologies', function (Blueprint $table) {
            $table->string('title')->change();
        });
        Schema::table('marker_word_types', function (Blueprint $table) {
            $table->string('title')->change();
        });
        Schema::table('materials', function (Blueprint $table) {
            $table->string('name')->change();
        });
        Schema::table('material_articles', function (Blueprint $table) {
            $table->string('title')->change();
        });
        Schema::table('material_conclusion_options', function (Blueprint $table) {
            $table->string('title')->change();
        });
        Schema::table('material_conclusion_status', function (Blueprint $table) {
            $table->string('title')->change();
        });
        Schema::table('material_court_decisions', function (Blueprint $table) {
            $table->string('title')->change();
        });
        Schema::table('material_decision_status', function (Blueprint $table) {
            $table->string('title')->change();
        });
        Schema::table('material_languages', function (Blueprint $table) {
            $table->string('title')->change();
        });
        Schema::table('material_object_types', function (Blueprint $table) {
            $table->string('title')->change();
        });
        Schema::table('material_status', function (Blueprint $table) {
            $table->string('title')->change();
        });
        Schema::table('material_types', function (Blueprint $table) {
            $table->string('title')->change();
        });
        Schema::table('reports', function (Blueprint $table) {
            $table->string('name')->change();
        });
        Schema::table('report_status', function (Blueprint $table) {
            $table->string('title')->change();
        });
        Schema::table('user_positions', function (Blueprint $table) {
            $table->string('title')->change();
        });
        Schema::table('user_specialities', function (Blueprint $table) {
            $table->string('title')->change();
        });
        Schema::table('user_statuses', function (Blueprint $table) {
            $table->string('title')->change();
        });
    }
}
