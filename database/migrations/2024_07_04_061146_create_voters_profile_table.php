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
        Schema::create('voters_profile', function (Blueprint $table) {
            $table->id();
            $table->string('firstname', 50);
            $table->string('middlename', 50);
            $table->string('lastname', 50);
            $table->unsignedBigInteger('sitio');
            $table->unsignedBigInteger('purok');
            $table->unsignedBigInteger('barangay');
            $table->unsignedBigInteger('precinct');
            $table->enum('leader', ['None','Barangay', 'Municipal','District','Provincial','Regional']);
            $table->timestamps();

            $table->foreign('sitio')->references('id')->on('sitio');
            $table->foreign('purok')->references('id')->on('purok');
            $table->foreign('barangay')->references('id')->on('barangay');
            $table->foreign('precinct')->references('id')->on('precinct');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voters_profile');
    }
};
