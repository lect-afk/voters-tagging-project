<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeysToCascade extends Migration
{
    public function up()
    {
        // Update group_tagging table
        Schema::table('group_tagging', function (Blueprint $table) {
            $table->dropForeign(['profile_id']);
            $table->dropForeign(['group_id']);
            $table->foreign('profile_id')->references('id')->on('voters_profile')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('group')->onDelete('cascade');
        });

        // Update candidates_tagging table
        Schema::table('candidates_tagging', function (Blueprint $table) {
            $table->dropForeign(['profile_id']);
            $table->dropForeign(['candidate_id']);
            $table->foreign('profile_id')->references('id')->on('voters_profile')->onDelete('cascade');
            $table->foreign('candidate_id')->references('id')->on('candidates')->onDelete('cascade');
        });

        // Update color_history table
        Schema::table('color_history', function (Blueprint $table) {
            $table->dropForeign(['profile_id']);
            $table->foreign('profile_id')->references('id')->on('voters_profile')->onDelete('cascade');
        });

        // Update events_tagging_table
        Schema::table('events_tagging', function (Blueprint $table) {
            $table->dropForeign(['profile_id']);
            $table->dropForeign(['event_id']);
            $table->foreign('profile_id')->references('id')->on('voters_profile')->onDelete('cascade');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
        });

        // Update create_candidates_table
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropForeign(['city']);
            $table->dropForeign(['district']);
            $table->dropForeign(['province']);
            $table->foreign('city')->references('id')->on('city')->onDelete('cascade');
            $table->foreign('district')->references('id')->on('legislative_district')->onDelete('cascade');
            $table->foreign('province')->references('id')->on('province')->onDelete('cascade');
        });

        // Update create_tagging table
        Schema::table('tagging', function (Blueprint $table) {
            $table->dropForeign(['predecessor']);
            $table->dropForeign(['successor']);
            $table->foreign('predecessor')->references('id')->on('voters_profile')->onDelete('cascade');
            $table->foreign('successor')->references('id')->on('voters_profile')->onDelete('cascade');
        });

        // Update create_voters_group_table
        Schema::table('voters_group', function (Blueprint $table) {
            $table->dropForeign(['group']);
            $table->dropForeign(['voter']);
            $table->foreign('group')->references('id')->on('group')->onDelete('cascade');
            $table->foreign('voter')->references('id')->on('voters_profile')->onDelete('cascade');
        });

        // Update create_voters_profile_table
        Schema::table('voters_profile', function (Blueprint $table) {
            $table->dropForeign(['sitio']);
            $table->dropForeign(['purok']);
            $table->dropForeign(['barangay']);
            $table->dropForeign(['precinct']);
            $table->foreign('sitio')->references('id')->on('sitio')->onDelete('cascade');
            $table->foreign('purok')->references('id')->on('purok')->onDelete('cascade');
            $table->foreign('barangay')->references('id')->on('barangay')->onDelete('cascade');
            $table->foreign('precinct')->references('id')->on('precinct')->onDelete('cascade');
        });

        // Update create_precinct_table
        Schema::table('precinct', function (Blueprint $table) {
            $table->dropForeign(['barangay']);
            $table->foreign('barangay')->references('id')->on('barangay')->onDelete('cascade');
        });

        // Update create_sitio_table
        Schema::table('sitio', function (Blueprint $table) {
            $table->dropForeign(['barangay']);
            $table->dropForeign(['purok']);
            $table->foreign('barangay')->references('id')->on('barangay')->onDelete('cascade');
            $table->foreign('purok')->references('id')->on('purok')->onDelete('cascade');
        });

        // Update create_purok_table
        Schema::table('purok', function (Blueprint $table) {
            $table->dropForeign(['barangay']);
            $table->foreign('barangay')->references('id')->on('barangay')->onDelete('cascade');
        });

        // Update create_barangay_table
        Schema::table('barangay', function (Blueprint $table) {
            $table->dropForeign(['city']);
            $table->foreign('city')->references('id')->on('city')->onDelete('cascade');
        });

        // Update create_city table
        Schema::table('city', function (Blueprint $table) {
            $table->dropForeign(['district']);
            $table->dropForeign(['province']);
            $table->foreign('district')->references('id')->on('legislative_district')->onDelete('cascade');
            $table->foreign('province')->references('id')->on('province')->onDelete('cascade');
        });

        // Update create_legislative_district table
        Schema::table('legislative_district', function (Blueprint $table) {
            $table->dropForeign(['province']);
            $table->foreign('province')->references('id')->on('province')->onDelete('cascade');
        });
    }

    public function down()
    {
        // Logic to revert changes if needed
    }
};
