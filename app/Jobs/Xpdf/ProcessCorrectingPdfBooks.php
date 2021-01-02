<?php

namespace App\Jobs\Xpdf;

use App\BookPages;
use App\Helpers\XPdfToHtml;
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
    protected $title;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(BookPages $book_pages, string $title)
    {
        $this->book_page = $book_pages;
        $this->title = $title;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            $book_page = $this->book_page;
            $correct_html = XPdfToHtml::generateCorrectHtml($book_page->original_content, $this->title);
            $book_page->content = $correct_html;
            $book_page->status = true;
            $book_page->save();
        }catch (\Exception $e){
            echo $e->getMessage();
        }
    }
}
