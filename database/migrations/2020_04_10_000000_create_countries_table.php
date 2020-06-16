<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('name', 50);
            $table->char('code', 2);
        });
    }

    public function down()
    {
        Schema::dropIfExists('countries');
    }
}
