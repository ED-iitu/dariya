<?php

namespace App\Console\Commands;

use App\BookPages;
use App\Jobs\ProcessCorrectingPdfBooks;
use App\Jobs\ProcessParsePdfBooks;
use Gufy\PdfToHtml\Config;
use Gufy\PdfToHtml\Html;
use Gufy\PdfToHtml\PageGenerator;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Helper\Helper;

class PdfToHtml extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'utils:pdf-to-html {--file=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert pdf file to html';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $file = $this->option('file');
        if(!$file){
            $file = $this->ask('Укажите файл');
        }
        if(file_exists(base_path($file))){
            $this->info("Selected file: {$file}");

            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                // change pdftohtml bin location
                Config::set('pdftohtml.bin', base_path('bin/win/poppler-0.68.0/bin/pdftohtml.exe'));

                // change pdfinfo bin location
                Config::set('pdfinfo.bin', base_path('bin/win/poppler-0.68.0/bin/pdfinfo.exe'));
            }

            $pdf_pages_dir = storage_path('app/public/pdf/book_'.Str::random());
            Config::set('pdftohtml.output', $pdf_pages_dir);

            $this->info("Output dir: {$pdf_pages_dir}");
            $pdf_to_html = new Html($file,[
                'ignoreImages'=>true,
            ]);

            $page  = 1;
            $book_pages = $pdf_to_html->getHtml();
            if(is_array($book_pages) && !empty($book_pages)){
                foreach ($book_pages as $html){
                    $html = PageGenerator::generateCorrectHtml($html);
                    $this->info("Page Number : {$page}");
                    $this->info("Content : {$html}");
                    if($page == 1)
                        break;
                    $page++;
                }
            }
            ProcessParsePdfBooks::delTree($pdf_pages_dir);
        }else{
            $this->info("File not found : {$file}");
        }

        return 0;
    }
}
