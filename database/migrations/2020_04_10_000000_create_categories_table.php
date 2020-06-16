<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('name', 25);
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
