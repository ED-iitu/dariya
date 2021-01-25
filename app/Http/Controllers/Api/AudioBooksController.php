<?php


namespace App\Http\Controllers\Api;


use App\Book;
use App\Rating;
use Illuminate\Http\Request;

class AudioBooksController extends Controller
{
    public function index(Request $request){
        $page = $request->get('page') ? $request->get('page') : 1;
        $pageSize = $request->get('pageSize') ? $request->get('pageSize') : 5;
        $audio_books = [];
        $res = Book::query()->where(['type' => Book::AUDIO_BOOK_TYPE, 'in_list' => true])->orderBy('created_at','desc')->orderBy('updated_at', 'desc')->paginate($pageSize,['*'],'page', $page);
        $res->each(function ($audio_book) use (&$audio_books){
            $audio_books[] = [
                "id"=> $audio_book->id,
                "name"=> $audio_book->name,
                "rating"=> $audio_book->rate,
                "type"=> $audio_book->type,
                "is_free"=> $audio_book->is_free ? true :false,
                "is_favorite"=> $audio_book->isFavorite(),
                "price"=> 0,
                "formatted_price"=> null,
                "forum_message_count"=> ($audio_book->comments) ? $audio_book->comments->count() : 0,
                "show_counter"=> $audio_book->show_counter,
                "image_url"=> ($audio_book->image_link) ? url($audio_book->image_link) : null
            ];
        });
        return $this->sendResponse([
            'audio_books' =>$audio_books, 'count' => $res->count(), 'all_count' => $res->total()
        ], '');
    }

    public function view($id){
        if($audio_book = Book::query()->find($id)){
            Book::where('id', $id)->increment('show_counter');
            $data = [
                "id"=> $audio_book->id,
                "name"=> $audio_book->name,
                "preview_text"=> $audio_book->preview_text,
                "detail_text"=> $audio_book->detail_text,
                "lang"=> $audio_book->lang,
                "lang_label"=> $audio_book->getLangLabel(),
                "publisher"=> ($audio_book->publisher) ? $audio_book->publisher->name : null,
                "rating"=> round($audio_book->rate, 20),
                'label' => $audio_book->is_free ? 'Бесплатно' : 'Премиум',
                "user_rating"=> ($audio_book->user_rate()) ? $audio_book->user_rate()->rate : null,
                "type"=> $audio_book->type,
                "page_count"=> $audio_book->page_count,
                "duration"=> $audio_book->duration,
                "is_free"=> $audio_book->is_free ? true :false,
                "is_favorite"=> $audio_book->isFavorite(),
                "in_my_book"=> $audio_book->inMyBook(),
                "is_access"=> $audio_book->isAccess(),
                "price"=> 0,
                "formatted_price"=> null,
                "forum_message_count"=> ($audio_book->comments) ? $audio_book->comments->count() : 0 ,
                "show_counter"=> $audio_book->show_counter,
                "image_url"=> ($audio_book->image_link) ? url($audio_book->image_link) : null,
                "share_link"=> route('book', $audio_book->id)
            ];

            if($audio_book->book_id){
                $data['book_id'] = $audio_book->book_id;
            }

            if($audio_book->genres){
                foreach ($audio_book->genres as $genre){
                    $data['genres'][] = [
                        "genre_id"=> $genre->id,
                        "name"=> $genre->name,
                    ];
                }
            }

            if($audio_book->comments){
                foreach ($audio_book->comments()->paginate(5) as $comment){
                    $rating = Rating::query()->where([
                        'author_id' => $comment->author_id,
                        'object_type' => Rating::BOOK_TYPE,
                        'object_id' => $id
                    ])->first();
                    $comment = [
                        "message"=> $comment->message,
                        "author_id"=> $comment->author_id,
                        "author_name"=> ($comment->author) ? $comment->author->name : '',
                        "personal_photo"=> null,
                        "post_date"=> $comment->created_at
                    ];
                    if($rating){
                        $comment["user_rating"] = $rating->rate;
                    }
                    $data['comments'][] = $comment;
                }
            }
            if($audio_book->ratings){
                $data['rated_users_count'] = $audio_book->ratings->count();
            }
            if($audio_book->author){
                $data['authors'][] = $audio_book->author->getFullName();
            }


            if($audio_book->audio_files){
                foreach ($audio_book->audio_files as $audio_file){
                    $data['files'][] = [
                        'file_id' => $audio_file->id,
                        'original_name' => $audio_file->original_name,
                        'file_size' => $audio_file->file_size,
                        'duration' => $audio_file->duration,
                        'content_type' => $audio_file->content_type,
                        'url' => $audio_file->audio_link ? url($audio_file->audio_link) : null
                    ];
                }
            }

            return $this->sendResponse($data, '');
        }
        return $this->sendError('Аудио-книга не существует!','Ресус не найден');
    }
}