<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeviceIdToUserReadBookLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_read_book_links', function (Blueprint $table) {
            $table->integer('user_id')->default(0)->change();
            $table->string('device_id', 500)->nullable()->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_read_book_links', function (Blueprint $table) {
            $table->integer('user_id')->nullable(false)->change();
            $table->dropColumn('device_id');
        });
    }
}
