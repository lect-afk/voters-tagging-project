<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoterLeaderConnectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voter_leader_connections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voter_id')->constrained('voters_profile')->onDelete('cascade');
            $table->foreignId('leader_id')->constrained('voters_profile')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voter_leader_connections');
    }
}
