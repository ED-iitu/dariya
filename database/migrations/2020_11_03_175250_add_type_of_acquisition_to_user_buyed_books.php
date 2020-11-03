<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeOfAcquisitionToUserBuyedBooks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_buyed_books', function (Blueprint $table) {
            $table->string('type_of_acquisition',32)->default('PURCHASED');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_buyed_books', function (Blueprint $table) {
            $table->removeColumn('type_of_acquisition');
        });
    }
}
