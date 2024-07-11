<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tagging', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('predecessor');
            $table->unsignedBigInteger('successor');
            $table->integer('tier_level');
            $table->text('team');
            $table->timestamps();

            $table->foreign('predecessor')->references('id')->on('voters_profile');
            $table->foreign('successor')->references('id')->on('voters_profile');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tagging');
    }
};
