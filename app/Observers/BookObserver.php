<?php

namespace App\Observers;

use App\Book;
use App\BookPages;
use App\Jobs\ProcessParsePdfBooks;
use Gufy\PdfToHtml\Config;
use Gufy\PdfToHtml\Html;
use Gufy\PdfToHtml\PageGenerator;
use Gufy\PdfToHtml\Pdf;
use Illuminate\Support\Facades\Storage;

class BookObserver
{
    /**
     * Handle the book "created" event.
     *
     * @param  \App\Book  $book
     * @return void
     */
    public function created(Book $book)
    {
        if($book->book_link){
            ProcessParsePdfBooks::dispatch($book);
        }
    }

    /**
     * Handle the book "updated" event.
     *
     * @param  \App\Book  $book
     * @return void
     */
    public function updated(Book $book)
    {
//        if($book->book_link){
//            ProcessParsePdfBooks::dispatch($book);
//        }
    }

    /**
     * Handle the book "deleted" event.
     *
     * @param  \App\Book  $book
     * @return void
     */
    public function deleted(Book $book)
    {
        //
    }

    /**
     * Handle the book "restored" event.
     *
     * @param  \App\Book  $book
     * @return void
     */
    public function restored(Book $book)
    {
        //
    }

    /**
     * Handle the book "force deleted" event.
     *
     * @param  \App\Book  $book
     * @return void
     */
    public function forceDeleted(Book $book)
    {
        //
    }
}
