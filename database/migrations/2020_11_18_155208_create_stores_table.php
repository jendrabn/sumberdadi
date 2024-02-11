<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('community_id');
            $table->string('name');
            $table->string('slug')->comment('Slug for username');
            $table->string('address');
            $table->char('city_id', 4);
            $table->char('province_id', 2);
            $table->mediumText('image');
            $table->string('phone', 20)->nullable();
            $table->timestamp('verified_at')->nullable();

            $table->timestamps();

            $table->foreign('community_id')
                ->references('id')
                ->on('communities')
                ->onDelete('cascade');

            $table->foreign('city_id')
                ->references('id')
                ->on('indonesia_cities');

            $table->foreign('province_id')
                ->references('id')
                ->on('indonesia_provinces');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stores');
    }
}
