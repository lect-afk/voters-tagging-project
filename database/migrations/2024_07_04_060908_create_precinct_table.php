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
        Schema::create('precinct', function (Blueprint $table) {
            $table->id();
            $table->text('number');
            $table->unsignedBigInteger('barangay');
            $table->timestamps();

            $table->foreign('barangay')->references('id')->on('barangay');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('precinct');
    }
};
