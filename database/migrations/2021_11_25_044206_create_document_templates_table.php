<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_template_status', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Наименование');
            $table->timestamps();
        });

        Schema::create('document_templates', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Наименование шаблона');
            $table->string('code')->comment('Идентификатор шаблона');
            $table->unsignedBigInteger('document_id')->nullable()->comment('Шаблон (documents.id)');
            $table->unsignedBigInteger('status_id')->nullable()->comment('Статус (document_template_status.id)');
            $table->unsignedBigInteger('creator_id')->nullable()->comment('Кем создано (users.id)');
            $table->timestamps();

            $table->foreign('document_id')->references('id')->on('documents');
            $table->foreign('status_id')->references('id')->on('document_template_status');
            $table->foreign('creator_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_templates');
        Schema::dropIfExists('document_template_status');
    }
}
