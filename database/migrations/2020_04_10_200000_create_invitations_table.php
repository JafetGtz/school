<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvitationsTable extends Migration
{
    public function up()
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table
                ->enum('status', [
                    'pending',
                    'accepted',
                    'denied',
                    'canceled',
                    'obsolete',
                ])
                ->default('pending');
            $table->unsignedBigInteger('asigment_id');
            $table->unsignedBigInteger('teacher_id');

            $table
                ->foreign('asigment_id')
                ->references('id')
                ->on('asigments')
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
        Schema::dropIfExists('invitations');
    }
}
