<?php

namespace App\Jobs;

use App\BookPages;
use Gufy\PdfToHtml\PageGenerator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessCorrectingPdfBooks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $book_page;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(BookPages $book_pages)
    {
        $this->book_page = $book_pages;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $book_page = $this->book_page;
        $correct_html  = PageGenerator::generateCorrectHtml($book_page->content);
        $book_page->content = $correct_html;
        $book_page->status = true;
        $book_page->save();
    }
}
