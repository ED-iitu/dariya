<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->string('youtube_video_id')->nullable()->change();
            $table->string('name')->after('id');
            $table->string('image_link')->after('name');
            $table->string('local_video_link')->nullable()->after('youtube_video_id');
            $table->string('preview_text', 500)->after('name');
            $table->text('detail_text')->after('preview_text');
            $table->string('author',255)->after('detail_text');
            $table->string('lang', 5)->after('author');
            $table->integer('show_counter')->default(0)->after('lang');
            $table->boolean('for_all')->default(1)->after('show_counter');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->removeColumn('name');
            $table->removeColumn('preview_text');
            $table->removeColumn('detail_text');
            $table->removeColumn('author');
            $table->removeColumn('lang');
            $table->removeColumn('show_counter');
            $table->removeColumn('for_all');
            $table->removeColumn('image_link');
            $table->removeColumn('local_video_link');
            $table->string('youtube_video_id')->nullable(false)->change();
        });
    }
}
