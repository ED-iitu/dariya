<?php
namespace App\Http\Controllers\Site;


use App\Author;
use App\Book;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->q ?? "";
        $books = Book::where('name', 'LIKE', '%' . $keyword . '%')->paginate(10);

        if ($books->count() == 0) {
            $books = $this->getBooksByAuthor($keyword);
        }

        return view('site.search', [
            'books' => $books,
            'keyword' => $keyword
        ]);
    }

    protected function getBooksByAuthor($authorName)
    {
        $authors = Author::select('id')->where('name', 'like',  '%' . $authorName . '%')->get();
        $books = [];

        foreach ($authors as $author) {
            $books = Book::where('author_id', '=', $author->id)->paginate(10);
        }

        return $books;
    }

}