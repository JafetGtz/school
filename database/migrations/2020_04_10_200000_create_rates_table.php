<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatesTable extends Migration
{
    public function up()
    {
        Schema::create('rates', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('score');
            $table->unsignedTinyInteger('criteria_id');
            $table->unsignedBigInteger('teacher_id');

            $table
                ->foreign('criteria_id')
                ->references('id')
                ->on('criterias')
                ->onDelete('cascade');
            $table
                ->foreign('teacher_id')
                ->references('id')
                ->on('teachers')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('rates');
    }
}
