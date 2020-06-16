<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id');
            $table->string('transaction_id');
            $table->decimal('amount', 8, 2);
            $table->unsignedBigInteger('asigment_id')->nullable();

            $table
                ->foreign('asigment_id')
                ->references('id')
                ->on('asigments')
                ->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
