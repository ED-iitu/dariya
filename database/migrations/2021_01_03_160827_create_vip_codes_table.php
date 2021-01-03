<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVipCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vip_codes', function (Blueprint $table) {
            $table->id();
            $table->integer('object_id');
            $table->string('object_type')->default(\App\VipCode::VIDEO_TYPE);
            $table->integer('user_id');
            $table->integer('try_count')->default(3);
            $table->boolean('status')->default(false);
            $table->string('code',6);
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
        Schema::dropIfExists('vip_codes');
    }
}
