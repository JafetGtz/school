<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('size');
            $table->string('type');
            $table->string('path');
            $table->unsignedBigInteger('asigment_id');

            $table
                ->foreign('asigment_id')
                ->references('id')
                ->on('asigments')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('files');
    }
}
