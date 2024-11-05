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
        DB::statement("ALTER TABLE `voters_profile` MODIFY COLUMN `alliances_status` ENUM('None','Green','Yellow', 'Orange','Red','White','Black')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE `voters_profile` MODIFY COLUMN `alliances_status` ENUM('None','Green','Yellow', 'Orange','Red','White')");
    }
};
