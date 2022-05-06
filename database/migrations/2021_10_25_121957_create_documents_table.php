<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Название файла оригинал');
            $table->string('name_uuid')->comment('Название файла в папке');
            $table->string('extension')->nullable()->comment('Расширение');
            $table->string('folder')->nullable()->comment('Папка');
            $table->unsignedBigInteger('creator_id')->comment('Кем создано (users.id)');
            $table->timestamps();

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
        Schema::dropIfExists('documents');
    }
}
