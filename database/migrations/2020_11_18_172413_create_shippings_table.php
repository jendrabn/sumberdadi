<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shippings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->char('sender_city');
            $table->char('receiver_city');
            $table->unsignedBigInteger('user_address_id');
            $table->string('shipper', 100)->nullable();
            $table->string('service', 100)->nullable();
            $table->string('estimated_delivery', 30)->nullable();
            $table->unsignedDecimal('weight');
            $table->string('tracking_code')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();

            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');

            $table->foreign('user_address_id')
                ->references('id')
                ->on('user_addresses')
                ->onDelete('cascade');

            $table->foreign('sender_city')
                ->references('id')
                ->on('indonesia_cities');

            $table->foreign('receiver_city')
                ->references('id')
                ->on('indonesia_cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shippings');
    }
}
