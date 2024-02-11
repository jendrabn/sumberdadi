<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunityEventAttendeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('community_event_attendees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('community_member_id');
            $table->boolean('is_absent')->default(0);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('event_id')
                ->references('id')
                ->on('community_events')
                ->onDelete('cascade');

            $table->foreign('community_member_id')
                ->references('id')
                ->on('community_members')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('community_event_attendees');
    }
}
