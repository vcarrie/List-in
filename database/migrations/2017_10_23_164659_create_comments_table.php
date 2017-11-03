<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->integer('idAccount')->unsigned();
            $table->integer('idList')->unsigned();
            $table->text('remark');
            $table->timestamps();
            $table->foreign('idAccount')->references('idAccount')->on('accounts');
            $table->foreign('idList')->references('idList')->on('listController');
            $table->primary(['idAccount', 'idList', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
