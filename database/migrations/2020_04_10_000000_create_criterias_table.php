<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCriteriasTable extends Migration
{
    public function up()
    {
        Schema::create('criterias', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('name', 30);
        });
    }

    public function down()
    {
        Schema::dropIfExists('criterias');
    }
}
