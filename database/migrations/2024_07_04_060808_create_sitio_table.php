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
        Schema::create('sitio', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->unsignedBigInteger('barangay');
            $table->unsignedBigInteger('purok');
            $table->timestamps();

            $table->foreign('barangay')->references('id')->on('barangay');
            $table->foreign('purok')->references('id')->on('purok');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sitio');
    }
};
