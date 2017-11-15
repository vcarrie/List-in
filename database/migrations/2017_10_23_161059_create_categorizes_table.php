<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategorizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorizes', function (Blueprint $table) {
            $table->integer('idTag')->unsigned();
            $table->integer('idList')->unsigned();
            $table->primary(['idTag', 'idList']);
            $table->foreign('idTag')->references('id')->on('tags');
            $table->foreign('idList')->references('id')->on('lists');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categorizes');
    }
}
