<?php

namespace App\Jobs;

use App\Book;
use App\BookPages;
use Gufy\PdfToHtml\Config;
use Gufy\PdfToHtml\Html;
use Gufy\PdfToHtml\PageGenerator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ProcessParsePdfBooks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $book;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $book = $this->book;
        $path = public_path(substr_replace($book->book_link,'',0,1));
        $hash = hash_file('sha256', $path);
        if($book->pdf_hash != $hash){
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                // change pdftohtml bin location
                Config::set('pdftohtml.bin', base_path('bin/win/poppler-0.68.0/bin/pdftohtml.exe'));

                // change pdfinfo bin location
                Config::set('pdfinfo.bin', base_path('bin/win/poppler-0.68.0/bin/pdfinfo.exe'));
            }

            $pdf_pages_dir = storage_path('app/public/pdf/book_'.$book->id);

            Config::set('pdftohtml.output', $pdf_pages_dir);
            $pdf_to_html = new Html($path,[
                'ignoreImages'=>true,
            ]);

            $page  = 1;
            foreach ($pdf_to_html->getHtml() as $html){
                $book_page_query = BookPages::query()->where(['book_id' => $book->id, 'page' => $page]);
                if($book_page_query->exists()){
                    $book_page = $book_page_query->first();
                    $book_page->content = $html;
                }else{
                    $book_page = new BookPages();
                    $book_page->setRawAttributes([
                        'book_id' => $book->id,
                        'page' => $page,
                        'content' => $html
                    ]);
                }
                if($book_page->save()){
                    ProcessCorrectingPdfBooks::dispatch($book_page);
                }
                $page++;
            }
            static::delTree($pdf_pages_dir);
            $book->pdf_hash = $hash;
            $book->save();
        }
    }

    static function delTree($dir)
    {
        $files = array_diff(scandir($dir), array('.', '..'));

        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? static::delTree("$dir/$file") : unlink("$dir/$file");
        }

        return rmdir($dir);
    }
}
