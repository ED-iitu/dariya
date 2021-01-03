<?php

namespace App\Observers;

use App\AudioFile;
use App\Book;
use App\BookPages;
use App\Jobs\ProcessParsePdfBooks;
use App\Jobs\Xpdf\ProcessParsePdfBooks as XProcessParsePdfBooks;

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
        $book->generatePriceCode();
        $book->save();
        if($book->book_link){
            if($book->pdf_to_html == Book::X_PDF_TO_HTML){
                XProcessParsePdfBooks::dispatch($book);
            }else{
                ProcessParsePdfBooks::dispatch($book);
            }

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
        $book->generatePriceCode();
        $book->save();
        if($book->book_link){
            if($book->pdf_to_html == Book::X_PDF_TO_HTML){
                XProcessParsePdfBooks::dispatch($book);
            }else{
                ProcessParsePdfBooks::dispatch($book);
            }
        }
    }

    /**
     * Handle the book "deleted" event.
     *
     * @param  \App\Book  $book
     * @return void
     */
    public function deleted(Book $book)
    {
        AudioFile::query()->where('book_id',$book->id)->get()->each(function ($file){
            /**
             * @var AudioFile $file
             */
            if($file->audio_link && file_exists(public_path($file->audio_link))){
                unlink(public_path($file->audio_link));
            }
            $file->delete();
        });

        BookPages::query()->where('book_id',$book->id)->get()->each(function ($page){
            /**
             * @var BookPages $page
             */
            $page->delete();
        });

        if($book->book_link && file_exists(public_path($book->book_link))){
            unlink(public_path($book->book_link));
        }
        if($book->image_link && file_exists(public_path($book->image_link))){
            unlink(public_path($book->image_link));
        }
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
