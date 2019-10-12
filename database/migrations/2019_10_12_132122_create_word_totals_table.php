<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWordTotalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('word_totals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('count');
            $table->foreign('wordlist')
            ->references('id')->on('wordlist')
            ->onDelete('cascade');
            $table->foreign('phrase')
            ->references('id')->on('phrase')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('word_totals');
    }
}
