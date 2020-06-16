<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsigmentsTable extends Migration
{
    public function up()
    {
        Schema::create('asigments', function (Blueprint $table) {
            $table->id();
            $table->string('details', 300);
            $table->decimal('budget', 8, 2);
	    $table->integer('hours');
            $table->dateTime('date');
            $table
                ->enum('status', [
                    'evaluating',
                    'waiting-for-class',
                    'finished',
                    'paid',
                    'canceled',
                ])
                ->default('evaluating');
            $table->unsignedTinyInteger('level_id');
            $table->unsignedTinyInteger('category_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('teacher_id')->nullable();

            $table
                ->foreign('level_id')
                ->references('id')
                ->on('levels')
                ->onDelete('cascade');
            $table
                ->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
            $table
                ->foreign('student_id')
                ->references('id')
                ->on('students')
                ->onDelete('cascade');
            $table
                ->foreign('teacher_id')
                ->references('id')
                ->on('teachers')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('asigments');
    }
}
