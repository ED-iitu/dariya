<?php
namespace App\Http\Controllers\Site;

use App\Author;
use Auth;
use App\Banner;
use App\Book;
use App\Comment;
use App\Genre;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::paginate(10);
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
        $book = Book::find($id);

        if($book) {
            $book->where('id', $id)->increment('show_counter');
        }

        $relatedBooks = Book::where('id', '!=', $id)->get();
        $comments = Comment::where('object_id', '=', $id)->where('object_type', '=', 'BOOK')->get();

        if ($comments->count() == 0) {
            $comments = [];
        }

        return view('site.book', [
            'bookData' => $book,
            'relatedBooks' => $relatedBooks,
            'comments' => $comments
        ]);
    }

    public function audioBooks()
    {
        $books = Book::where('type', '=', 'AUDIO')->paginate(10);

        if ($books->count() == 0) {
            $books = [];
        }

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

    public function filter(Request $request)
    {
        $filter = $request->orderBy ?? "ASC";

        $books = Book::orderBy('price', $filter)->paginate(10);
       // dd($books);

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

    /**
     * Favorite a particular post
     *
     * @param  Book $book
     * @return Response
     */
    public function favoriteBook(Book $book)
    {
        if (Auth::user() == null) {
            return view('site.createAccount');
        }

        Auth::user()->favorites()->attach($book->id);

        return redirect()->back()->with('success','Книга добалена в избранное');
    }

    /**
     * Unfavorite a particular post
     *
     * @param  Book $book
     * @return Response
     */
    public function unFavoriteBook(Book $book)
    {
        Auth::user()->favorites()->detach($book->id);

        return redirect()->back()->with('success','Книга удаленна из избранных');
    }
}