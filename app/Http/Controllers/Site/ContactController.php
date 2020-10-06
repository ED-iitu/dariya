<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 10/7/20
 * Time: 01:14
 */

namespace App\Http\Controllers\Site;


use App\Book;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    public function index()
    {
        $books = Book::limit(10)->get();
        return view('site.contacts',[
            'books' => $books
        ]);
    }
}