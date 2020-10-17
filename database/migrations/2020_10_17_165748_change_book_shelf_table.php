<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeBookShelfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('book_shelfs', function (Blueprint $table) {
            $table->string('description', 500)->nullable()->change();
            $table->string('image_url')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('book_shelfs', function (Blueprint $table) {
            $table->string('description', 500)->change();
            $table->string('image_url')->change();
        });
    }
}
