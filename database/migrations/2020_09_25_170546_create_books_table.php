<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->default('BOOK');
            $table->string('preview_text', 500);
            $table->text('detail_text');
            $table->string('lang',5);
            $table->integer('publisher_id')->nullable();
            $table->decimal('price',19,2);
            $table->integer('author_id')->nullable();
            $table->integer('show_counter')->default(0);
            $table->string('book_link')->nullable();
            $table->string('image_link')->nullable();
            $table->boolean('is_free')->nullable()->default(0);
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
        Schema::dropIfExists('books');
    }
}
