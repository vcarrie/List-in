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
            $table->integer('idAccount')->unsigned();
            $table->integer('idList')->unsigned();
            $table->smallInteger('rating');
            $table->timestamps();

            $table->foreign('idAccount')->references('idAccount')->on('accounts');
            $table->foreign('idList')->references('idList')->on('listController');
            $table->primary(['idAccount', 'idList']);
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
