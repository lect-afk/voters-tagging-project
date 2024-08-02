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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->string('fullname', 50);
            $table->enum('position', ['Councilor','Vice-Mayor','Mayor', 'Board Member','Congressman','Vice-Governor','Governor'])->nullable();
            $table->unsignedBigInteger('city')->nullable();
            $table->unsignedBigInteger('district')->nullable();
            $table->unsignedBigInteger('province')->nullable();
            $table->timestamps();

            $table->foreign('city')->references('id')->on('city');
            $table->foreign('district')->references('id')->on('legislative_district');
            $table->foreign('province')->references('id')->on('province');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidates');
    }
};
