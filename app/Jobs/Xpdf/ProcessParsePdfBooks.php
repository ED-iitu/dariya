<?php

namespace App\Jobs\Xpdf;

use App\Book;
use App\BookPages;
use App\Helpers\XPdfToHtml;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

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
            $options = [];
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                // change pdftohtml bin location
                $options['bin'] = base_path('bin/win/xpdf/pdftohtml.exe');
                $options['info_bin'] = base_path('bin/win/xpdf/pdfinfo.exe');
            }

            $pdf_pages_dir = storage_path('app/public/pdf/book_'.Str::random(32));

            $options['output_dir'] = $pdf_pages_dir;
            $options['file'] = $path;

            $pdf_to_html = new XPdfToHtml($options);
            $pdf_to_html->parse();

            $page  = 1;
            $book_pages = $pdf_to_html->getHtml();
            if(is_array($book_pages) && !empty($book_pages)){
                BookPages::query()->where('book_id', $book->id)->delete();
                $book->pdf_hash = $hash;
                $book->page_count = count($book_pages);
                $book->save();

                $titles = [];
                foreach ($book_pages as $html){
                    \App\Helpers\XPdfToHtml::findPageTitle($html, $titles);
                }
                arsort($titles);
                $title = array_key_first($titles);

                foreach ($book_pages as $html){
                    $book_page = new BookPages();
                    $book_page->setRawAttributes([
                        'book_id' => $book->id,
                        'page' => $page,
                        'original_content' => $html,
                        'content' => $html,
                    ]);
                    if($book_page->save()){
                        ProcessCorrectingPdfBooks::dispatch($book_page, $title);
                    }
                    $page++;
                }
            }
            ProcessParsePdfBooks::delTree($pdf_pages_dir);
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
