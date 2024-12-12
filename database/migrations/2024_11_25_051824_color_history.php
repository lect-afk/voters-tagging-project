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
        Schema::create('color_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profile_id');
            $table->string('old_tag', 50)->nullable();
            $table->string('new_tag', 50)->nullable();
            $table->enum('remarks', ['Candidate Behavior and Scandals','Policy Changes','Social Issues',
            'Party Allegiance and Identity','Media Influence','Endorsements and Alliances',
            'Campaign Effectiveness','Personal Experience','Strategic Voting','Financial Incentives',
            'Promises of Personal Gain','Threats and Coercion','Development Projects and Local Investments',
            'None'])->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('profile_id')->references('id')->on('voters_profile');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('color_history');
    }
};
