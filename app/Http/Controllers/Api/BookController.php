<?php


namespace App\Http\Controllers\Api;



use Gufy\PdfToHtml\Config;
use Gufy\PdfToHtml\Pdf;
use PHPHtmlParser\Dom;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $page = new Dom();
        $page->load(file_get_contents(base_path('libs/pdf-to-html/output/book/qaraman_qaraqshy-6.html')));
        //dd($page->find('p'));
        $elemets = $page->find('p');
        /**
         * @var Dom\HtmlNode $elemet
         */
        $element_left_css = [];
        foreach ($elemets as $key=>$elemet){
            $styles = $elemet->getAttribute('style');
            $styles_arr = explode(';',$styles);
            foreach ($styles_arr as $style){
                $style_arr = explode(':', $style);
                if(isset($style_arr[0]) && $style_arr[0] == 'left'){
                    $left = intval($style_arr[1]);
                    if(is_numeric($elemet->text())){
                        $elemet->delete();
                        unset($elemets[$key]);
                    }
                    if(isset($element_left_css[$left])){
                        $element_left_css[$left]++;
                    }else{
                        $element_left_css[$left] = 1;
                    }
                }
                //dd($style_arr);
            }
        }
        arsort($element_left_css);
        $element_left_css = array_keys($element_left_css);
        $min_left = min($element_left_css[0], $element_left_css[1]);
        $max_left = max($element_left_css[0], $element_left_css[1]);
        dd($element_left_css, $min_left, $max_left);
        $els = [];
        $new_page = new Dom();
        $prev_left = null;
        /**
         * @var Dom\HtmlNode $e
         */
        foreach ($elemets as $k=>$e){
            $styles = $elemet->getAttribute('style');
            $styles_arr = explode(';',$styles);
            foreach ($styles_arr as $style){
                $style_arr = explode(':', $style);
                if(isset($style_arr[0]) && $style_arr[0] == 'left'){
                    $left = intval($style_arr[1]);
                    if($prev_left == $left){
                        $tag = new Dom\Tag('p');
                        $tag->makeClosingTag();
                        $node->text('dddddd');
                        $elemets[$key-1] =
                    }
                    $prev_left = $left;
                }
                //dd($style_arr);
            }
        }
        dd($els);


//        $path = public_path('files/books/qaraman_qaraqshy.pdf');
//
//// change pdftohtml bin location
//        Config::set('pdftohtml.bin', base_path('bin/win/poppler-0.68.0/bin/pdftohtml.exe'));
//
//// change pdfinfo bin location
//        Config::set('pdfinfo.bin', base_path('bin/win/poppler-0.68.0/bin/pdfinfo.exe'));
//// initiate
//        $pdf = new Pdf($path);
//
//// convert to html and return it as [Dom Object](https://github.com/paquettg/php-html-parser)
//        $html = $pdf->html(1,[
//            'ignoreImages'=>true,
//        ]);
//// check if your pdf has more than one pages
//        $total_pages = $pdf->getPages();
//
//// Your pdf happen to have more than one pages and you want to go another page? Got it. use this command to change the current page to page 3
//        $html->goToPage(3);
//
//// and then you can do as you please with that dom, you can find any element you want
//        $paragraphs = $html->find('body > p');
        return $this->sendError(['data' => 'data1'], 'Products retrieved successfully.');
    }
}