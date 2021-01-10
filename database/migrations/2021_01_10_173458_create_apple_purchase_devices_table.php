<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplePurchaseDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apple_purchase_devices', function (Blueprint $table) {
            $table->id();
            $table->string('device_id',500)->index('deviceUID');
            $table->text('receipt');
            $table->text('receipt_check_data')->nullable();
            $table->string('price_id')->nullable();
            $table->integer('tariff_id');
            $table->integer('tariff_price_list_id');
            $table->dateTime('tariff_begin_date');
            $table->dateTime('tariff_end_date');
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
        Schema::dropIfExists('apple_purchase_devices');
    }
}
