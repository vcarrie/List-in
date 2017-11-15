<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rates', function (Blueprint $table) {
            $table->integer('idUser')->unsigned();
            $table->integer('idList')->unsigned();
            $table->smallInteger('rating');
            $table->timestamps();

            $table->foreign('idUser')->references('id')->on('users');
            $table->foreign('idList')->references('id')->on('lists');
            $table->primary(['idUser', 'idList']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rates');
    }
}
