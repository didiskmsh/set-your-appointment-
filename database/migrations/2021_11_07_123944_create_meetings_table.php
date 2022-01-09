<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idCreateMeeting');
            $table->unsignedBigInteger('id_follower');
            $table->integer('meeting_status');
            $table->string('title');
            $table->string('location');
            $table->string('doc');
            $table->timestamp('time');
            $table->timestamps();


            $table->foreign('idCreateMeeting')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_follower')->references('id')->on('followers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meetings');
    }
}
