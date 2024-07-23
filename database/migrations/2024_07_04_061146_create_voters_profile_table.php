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
            $table->string('middlename', 50)->nullable();
            $table->string('lastname', 50);
            $table->unsignedBigInteger('sitio')->nullable();
            $table->unsignedBigInteger('purok')->nullable();
            $table->unsignedBigInteger('barangay')->nullable();
            $table->unsignedBigInteger('precinct')->nullable();
            $table->enum('leader', ['None','Purok','Barangay', 'Municipal','District','Provincial','Regional']);
            $table->enum('alliances_status', ['None','Green','Yellow', 'Orange','Red']);
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
