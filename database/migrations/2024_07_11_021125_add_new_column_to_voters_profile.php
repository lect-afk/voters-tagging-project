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
        Schema::table('voters_profile', function (Blueprint $table) {
            $table->enum('alliances_status', ['Green','Yellow', 'Orange','Red']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('voters_profile', function (Blueprint $table) {
            $table->dropColumn('alliances_status', ['Green','Yellow', 'Orange','Red']);
        });
    }
};
