<?php
namespace App\Http\Controllers\Site;

use App\Author;
use App\Banner;
use App\Book;
use App\Genre;
use App\Http\Controllers\Controller;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        $genres = Genre::all();
        $authors = Author::all();
        $banners = Banner::all();
        return view('site.books' ,[
            'books' => $books,
            'genres' => $genres,
            'authors' => $authors,
            'banners' => $banners
        ]);
    }

    public function singleBook($id)
    {
        $book = Book::where('id', '=', $id)->get();
        $relatedBooks = Book::all();

        return view('site.book', [
            'book' => $book,
            'relatedBooks' => $relatedBooks
        ]);
    }

    public function audioBooks()
    {
        $books = Book::where('type', '=', 'AUDIO')->get();
        $genres = Genre::all();
        $authors = Author::all();
        $banners = Banner::all();
        return view('site.audioBooks' ,[
            'books' => $books,
            'genres' => $genres,
            'authors' => $authors,
            'banners' => $banners
        ]);
    }
}