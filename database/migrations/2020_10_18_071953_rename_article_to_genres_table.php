<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameArticleToGenresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('article_to_genres', function (Blueprint $table) {
            $table->renameColumn('genre_id','category_id');
            $table->rename('article_to_category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('article_to_category', function (Blueprint $table) {
            $table->renameColumn('category_id', 'genre_id');
            $table->rename('article_to_genres');
        });
    }
}
