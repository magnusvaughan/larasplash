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
            $table->unsignedBigInteger('wordlist');
            $table->foreign('wordlist')
            ->references('id')->on('wordlists')
            ->onDelete('cascade');
            $table->unsignedBigInteger('phrase');
            $table->foreign('phrase')
            ->references('id')->on('phrases')
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
