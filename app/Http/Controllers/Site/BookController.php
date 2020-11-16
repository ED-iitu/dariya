<?php
namespace App\Http\Controllers\Site;

use App\Author;
use App\BookToGenre;
use Auth;
use App\Banner;
use App\Book;
use App\Comment;
use App\Genre;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jorenvh\Share\ShareFacade;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Книги';
        $breadcrumb[] = [
            'title' => $title,
            'route' => route('articles'),
            'active' => true
        ];

        $books = Book::query()->where('type', '=', Book::BOOK_TYPE);
        if($request->get('authors')){
            $books->whereIn('author_id',$request->get('authors'));
        }

        if($request->get('genres')){
            $genres = $request->get('genres');
            $books->whereHas('objectToGenres',function ($query)use($genres){
                return $query->whereIn('genre_id', $genres);
            });
        }

        $books = $books->orderBy('created_at','desc')->orderBy('updated_at', 'desc')->paginate(9);
        $genres = Genre::all();
        $authors = Author::all();
        $banners = Banner::all();
        return view('site.books' ,[
            'books' => $books,
            'genres' => $genres,
            'authors' => $authors,
            'banners' => $banners,
            'title' => $title,
            'breadcrumb' => $breadcrumb
        ]);
    }

    public function singleBook($id)
    {
        $book = Book::find($id);

        if($book) {
            $book->where('id', $id)->increment('show_counter');
        }

        $relatedBooks = Book::query()->where('type', $book->type)->whereHas('genres', function($query)use($book){
            return $query->whereIn('genre_id', $book->genres->pluck('id')->toArray());
        })->limit(4)->get();
        $relatedBooksFilterParams = [];
        foreach ($book->genres->pluck('id')->toArray() as $key=>$genre_id){
            $relatedBooksFilterParams['genres['.$key.']'] =$genre_id;
        }
        $comments = Comment::where('object_id', '=', $id)->where('object_type', '=', 'BOOK')->get();

        if ($comments->count() == 0) {
            $comments = [];
        }

        $breadcrumb[] = [
            'title' => ($book->type == Book::BOOK_TYPE) ? 'Книги' : 'Аудио книги',
            'route' => ($book->type == Book::BOOK_TYPE) ? route('books') : route('audio_books'),
            'active' => false,
        ];
        $title = $book->name;
        $breadcrumb[] = [
            'title' => $title,
            'active' => true
        ];

        $share_links = ShareFacade::page(url('book/'.$id), $book->name)
            ->facebook()
            ->vk()
            ->twitter()
            ->whatsapp()
            ->telegram()
            ->getRawLinks();

        return view('site.book', [
            'bookData' => $book,
            'relatedBooks' => $relatedBooks,
            'relatedBooksFilterParams' => $relatedBooksFilterParams,
            'comments' => $comments,
            'title' => $title,
            'breadcrumb' => $breadcrumb,
            'share_links' => $share_links,
        ]);
    }
    public function readBook($id)
    {
        if($book = Book::query()->find($id)){
            $android_link = env('ANDROID_APP_LINK','#');
            $ios_link = env('IOS_APP_LINK','#');

            $message = 'Чтобы читать книгу установите приложение из <a href="'.$android_link.'" target="_blank"><b>Google Play</b></a> или <a href="'.$ios_link.'" target="_blank"><b>App Store</b></a>';
            if($book->type == Book::AUDIO_BOOK_TYPE){
                $message = 'Чтобы слушать аудио-книгу установите приложение из <a href="'.$android_link.'" target="_blank"><b>Google Play</b></a> или <a href="'.$ios_link.'" target="_blank"><b>App Store</b></a>';
            }
            return redirect()->route('book', $id)
                ->with('success',$message);
        }
    }
    public function audioBooks()
    {
        $books = Book::where('type', '=', Book::AUDIO_BOOK_TYPE)->orderBy('created_at','desc')->orderBy('updated_at', 'desc')->paginate(9);

        if ($books->count() == 0) {
            $books = [];
        }

        $genres = Genre::all();
        $authors = Author::all();
        $banners = Banner::all();

        $title = 'Аудио книги';
        $breadcrumb[] = [
            'title' => $title,
            'route' => route('books'),
            'active' => true
        ];

        return view('site.books' ,[
            'books' => $books,
            'genres' => $genres,
            'authors' => $authors,
            'banners' => $banners,
            'title' => $title,
            'breadcrumb' => $breadcrumb
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