<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBelongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('belongs', function (Blueprint $table) {
            $table->integer('idList')->unsigned();
            $table->string('idCdiscount');
            $table->integer('quantity');
            $table->primary(['idList', 'idCdiscount']);
            $table->foreign('idList')->references('id')->on('lists');
            $table->foreign('idCdiscount')->references('idCdiscount')->on('products');
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
        Schema::dropIfExists('belongs');
    }
}
