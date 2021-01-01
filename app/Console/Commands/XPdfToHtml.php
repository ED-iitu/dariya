<?php

namespace App\Console\Commands;

use App\Jobs\ProcessParsePdfBooks;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class XPdfToHtml extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'utils:x-pdf-to-html {--file=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert pdf file to html with Xpdf utils';

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

            $options = [];
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                // change pdftohtml bin location
                $options['bin'] = base_path('bin/win/xpdf/pdftohtml.exe');
                $options['info_bin'] = base_path('bin/win/xpdf/pdfinfo.exe');
            }

            $pdf_pages_dir = storage_path('app/public/pdf/book_'.Str::random());
            $this->info("Set output dir: {$pdf_pages_dir}");
            $options['output_dir'] = $pdf_pages_dir;
            $options['file'] = base_path($file);

            $this->info("Output dir: {$pdf_pages_dir}");
            $pdf_to_html = new \App\Helpers\XPdfToHtml($options);
            $pdf_to_html->parse();
            $page  = 1;
            $book_pages = $pdf_to_html->getHtml();
            if(is_array($book_pages) && !empty($book_pages)){
                $titles = [];
                foreach ($book_pages as $html){
                    \App\Helpers\XPdfToHtml::findPageTitle($html, $titles);
                }
                arsort($titles);
                $title = array_key_first($titles);
                foreach ($book_pages as $key=>$html){
                    if($page == 75){
                        $html = \App\Helpers\XPdfToHtml::generateCorrectHtml($html, $title);
                        $h_file = $pdf_pages_dir.'/page_'.$key.'.html';
                        file_put_contents($h_file, $html);
                        $this->info("Page Number : {$page}");
                        $this->info("Content : {$html}");
                        break;
                    }
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
