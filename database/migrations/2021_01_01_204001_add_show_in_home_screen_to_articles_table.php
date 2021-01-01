<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShowInHomeScreenToArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->boolean('in_home_screen')->default(false);
            $table->boolean('in_list')->default(false);
        });
        Schema::table('videos', function (Blueprint $table) {
            $table->boolean('in_home_screen')->default(false);
            $table->boolean('in_list')->default(false);
        });
        Schema::table('books', function (Blueprint $table) {
            $table->boolean('in_home_screen')->default(false);
            $table->boolean('in_list')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('in_home_screen');
            $table->dropColumn('in_list');
        });
        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn('in_home_screen');
            $table->dropColumn('in_list');
        });
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('in_home_screen');
            $table->dropColumn('in_list');
        });
    }
}
