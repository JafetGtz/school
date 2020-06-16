<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('document')->nullable();
            $table->date('birthday')->nullable();
            $table->boolean('answered_questions')->default(false);
            $table
                ->enum('status', ['fresh', 'active', 'inactive'])
                ->default('fresh');
            $table->unsignedTinyInteger('country_id')->nullable();

            $table
                ->foreign('country_id')
                ->references('id')
                ->on('countries')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('teachers');
    }
}
