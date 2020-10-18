<?php


namespace App\Http\Controllers\Api;



use Akaunting\Money\Money;
use App\Article;
use App\Book;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $data = [];
        $search = $request->get('q');
        if($search){
            Book::query()
                ->where('name','like', "%$search%")
                ->orWhere('preview_text','like', "%$search%")
                ->orWhere('detail_text','like', "%$search%")
                ->orWhereHas('author',function ($query) use ($search){
                    return $query->where('name', 'like', "%$search%");
                })
                ->orWhereHas('publisher',function ($query) use ($search){
                    return $query->where('name', 'like', "%$search%");
                })
                ->orWhereHas('genres',function ($query) use ($search){
                    return $query->where('name', 'like', "%$search%");
                })
                ->paginate(5)
                ->each(function ($book) use (&$data){
                    $authors = [];
                    if($book->author){
                        $author = $book->author->name;
                        if($book->author->surname)
                            $author .= ' '.$book->author->surname;
                        $authors[] = $author;
                    }
                    $data[] = [
                        "id"=> $book->id,
                        "name"=> $book->name,
                        "rating"=> $book->rate,
                        "authors"=> $authors,
                        "type"=> $book->type,
                        "is_free"=> $book->is_free ? true :false,
                        "price"=> $book->price,
                        "formatted_price"=> Money::KZT($book->price)->format(),
                        "forum_message_count"=> ($book->comments) ? $book->comments->count() : 0,
                        "show_counter"=> $book->show_counter,
                        "image_url"=> ($book->image_link) ? url($book->image_link) : null
                    ];
                });

            Article::query()
                ->where('name','like', "%$search%")
                ->orWhere('preview_text','like', "%$search%")
                ->orWhere('detail_text','like', "%$search%")
                ->orWhere('author','like', "%$search%")
                ->orWhereHas('categories',function ($query) use ($search){
                    return $query->where('name', 'like', "%$search%");
                })
                ->paginate(5)
                ->each(function ($article) use (&$data){
                    $data[] = [
                        "id"=> $article->id,
                        "name"=> $article->name,
                        "rating"=> $article->rate,
                        "authors"=> $article->author ? [$article->author] : [],
                        "type"=> 'ARTICLE',
                        "is_free"=> true,
                        "price"=> null,
                        "formatted_price"=> null,
                        "forum_message_count"=> ($article->comments) ? $article->comments->count() : 0,
                        "show_counter"=> $article->show_counter,
                        "image_url"=> ($article->image_link) ? url($article->image_link) : null
                    ];
                });
        }
        return $this->sendResponse([
            'data' =>$data, 'query' => $search,
        ], '');
    }
}