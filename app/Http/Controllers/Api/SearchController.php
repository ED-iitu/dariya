<?php


namespace App\Http\Controllers\Api;



use Akaunting\Money\Money;
use App\Article;
use App\Book;
use App\Video;
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
                ->orderBy('created_at','desc')->orderBy('updated_at', 'desc')
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
                        "preview_text"=> $book->preview_text,
                        "rating"=> $book->rate,
                        "authors"=> $authors,
                        "type"=> $book->type,
                        "is_free"=> $book->is_free ? true :false,
                        "is_favorite"=> $book->isFavorite(),
                        "price"=> $book->price,
                        "formatted_price"=> Money::KZT($book->price)->format(),
                        "forum_message_count"=> ($book->comments) ? $book->comments->count() : 0,
                        "show_counter"=> $book->show_counter,
                        "image_url"=> ($book->image_link) ? url($book->image_link) : null,
                        "url"=> url('book/'.$book->id),
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
                ->orderBy('created_at','desc')->orderBy('updated_at', 'desc')
                ->paginate(5)
                ->each(function ($article) use (&$data){
                    $data[] = [
                        "id"=> $article->id,
                        "name"=> $article->name,
                        "preview_text"=> $article->preview_text,
                        "rating"=> $article->rate,
                        "author"=> $article->author ? $article->author : null,
                        "type"=> 'ARTICLE',
                        "is_favorite"=> $article->isFavorite(),
                        "is_free"=> true,
                        "price"=> null,
                        "formatted_price"=> null,
                        "forum_message_count"=> ($article->comments) ? $article->comments->count() : 0,
                        "show_counter"=> $article->show_counter,
                        "image_url"=> ($article->image_link) ? url($article->image_link) : null,
                        "url"=> url('article/'.$article->id),
                    ];
                });

            Video::query()
                ->where('name','like', "%$search%")
                ->orWhere('preview_text','like', "%$search%")
                ->orWhere('detail_text','like', "%$search%")
                ->orWhere('author','like', "%$search%")
                ->orWhereHas('categories',function ($query) use ($search){
                    return $query->where('name', 'like', "%$search%");
                })
                ->orderBy('created_at','desc')->orderBy('updated_at', 'desc')
                ->paginate(5)
                ->each(function ($video) use (&$data){
                    $data[] = [
                        "id"=> $video->id,
                        "name"=> $video->name,
                        "preview_text"=> $video->preview_text,
                        "rating"=> $video->rate,
                        "author"=> $video->author ? $video->author : null,
                        "type"=> 'VIDEO',
                        "is_favorite"=> $video->isFavorite(),
                        "is_free"=> true,
                        "price"=> null,
                        "formatted_price"=> null,
                        "forum_message_count"=> ($video->comments) ? $video->comments->count() : 0,
                        "show_counter"=> $video->show_counter,
                        "image_url"=> ($video->image_link) ? url($video->image_link) : null,
                        "url"=> url('article/'.$video->id),
                    ];
                });
        }
        return $this->sendResponse([
            'data' =>$data, 'query' => $search,
        ], '');
    }
}