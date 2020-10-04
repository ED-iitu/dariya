<?php


namespace App\Http\Controllers\Api;



use App\Book;
use Gufy\PdfToHtml\Config;
use Gufy\PdfToHtml\Html;
use Gufy\PdfToHtml\PageGenerator;
use Gufy\PdfToHtml\Pdf;
use PHPHtmlParser\Dom;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_html($id)
    {

        $book = Book::query()->find($id);
        if($book){
            $data = [];
            foreach ($book->pages as $page){
                if($page->status){
                    $data[] = [
                        'content' => $page->content,
                        'page' => $page->page
                    ];
                }else{
                    $data[] = [
                        'content' => 'Страница в обработке',
                        'page' => $page->page
                    ];
                }
            }
            return response(['data' => $data]);
        }


        return $this->sendError('Book Not Found' ,[], 404);
    }
}