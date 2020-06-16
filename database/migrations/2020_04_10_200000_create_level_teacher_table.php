<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLevelTeacherTable extends Migration
{
    public function up()
    {
        Schema::create('level_teacher', function (Blueprint $table) {
            $table->unsignedTinyInteger('level_id');
            $table->unsignedBigInteger('teacher_id');

            $table
                ->foreign('level_id')
                ->references('id')
                ->on('levels')
                ->onDelete('cascade');
            $table
                ->foreign('teacher_id')
                ->references('id')
                ->on('teachers')
                ->onDelete('cascade');

            $table->primary(['level_id', 'teacher_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('level_teacher');
    }
}
