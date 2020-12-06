<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Book extends Model
{

    use MultiLang;

    const BOOK_TYPE = 'BOOK';
    const AUDIO_BOOK_TYPE = 'AUDIO';

    const PDF_TO_HTML = 'PDF_TO_HTML';
    const X_PDF_TO_HTML = 'X_PDF_TO_HTML';

    protected $table = 'books';

    protected $fillable = [
        'name', 'type', 'preview_text', 'detail_text', 'lang', 'pdf_to_html',
        'publisher_id', 'price', 'author_id', 'genres', 'image_link', 'book_link', 'is_free', 'background_color', 'page_count', 'pdf_hash', 'duration'
    ];

    public function author()
    {
        return $this->hasOne(Author::class, 'id', 'author_id');
    }

    public function user_read_book_link()
    {
        return $this->hasOne(UserReadBookLink::class, 'book_id', 'id')->where('user_id', Auth::id());
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'object_id', 'id')->where('object_type', '=', Rating::BOOK_TYPE);
    }

    public function publisher()
    {
        return $this->hasOne(Publisher::class, 'id', 'publisher_id');
    }

    public function genres()
    {
        return $this->hasManyThrough(Genre::class, BookToGenre::class, 'book_id', 'id', 'id', 'genre_id');
    }

    public function objectToGenres()
    {
        return $this->hasMany(BookToGenre::class);
    }

    public function pages()
    {
        return $this->hasMany(BookPages::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'object_id', 'id')->where('object_type', '=', Comment::BOOK_TYPE)->orderBy('comments.created_at', 'desc');
    }

    public function audio_files()
    {
        return $this->hasMany(AudioFile::class, 'book_id', 'id')->orderBy('order');
    }

    public function getGenresIds()
    {
        $ids = [];
        foreach ($this->genres as $genre) {
            $ids[] = $genre->id;
        }
        return $ids;
    }

    public function favorited()
    {
        return (bool)Favorite::where('user_id', Auth::id())
            ->where('object_id', $this->id)
            ->first();
    }

    public function user_rate()
    {
        if (Auth::user()) {
            return Rating::query()
                ->where([
                    'author_id' => Auth::id(),
                    'object_type' => Rating::BOOK_TYPE,
                    'object_id' => $this->id
                ])
                ->orderBy('created_at')
                ->first();
        }
        return false;
    }

    public function isBookFavorite()
    {
        if (Auth::user() &&
            Favorite::query()
                ->where([
                    'object_id' => $this->id,
                    'object_type' => Favorite::FAVORITE_BOOK_TYPE,
                    'user_id' => Auth::id()
                ])->exists()) {
            return true;
        }
        return false;
    }

    public function inMyBook()
    {
        if (Auth::user() &&
            UserBook::query()
                ->where([
                    'book_id' => $this->id,
                    'user_id' => Auth::id()
                ])->exists()) {
            return true;
        }
        return false;
    }

    public function isAudioBookFavorite()
    {
        if (Auth::user() &&
            Favorite::query()
                ->where([
                    'object_id' => $this->id,
                    'object_type' => Favorite::FAVORITE_AUDIO_BOOK_TYPE,
                    'user_id' => Auth::id()
                ])->exists()) {
            return true;
        }
        return false;
    }

    public function isFavorite()
    {
        if ($this->isBookFavorite() || $this->isAudioBookFavorite()) {
            return true;
        }
        return false;
    }

    public function isAccess(){
        $is_access = false;
        if(Auth::user()){
            if($this->is_free){
                return true;
            }
            $id = $this->id;
            if(Auth::user()->have_active_tariff()){
                $is_access = true;
                if(Auth::user()->tariff->slug == 'standard' && $this->type == Book::AUDIO_BOOK_TYPE){
                    $is_access = false;
                }
            }else{
                Auth::user()->books->each(function ($my_book) use (&$is_access, $id){
                    if(!$is_access && $id == $my_book->id){
                        $is_access = true;
                    }
                });
            }
        }
        return $is_access;
    }

    public function getReadLink(){
        if($this->isAccess()){
            if($this->user_read_book_link){
                return route('read_book', $this->user_read_book_link->hash);
            }else{
                $user_read_book_link = new UserReadBookLink();
                $data = [
                    'user_id' => Auth::id(),
                    'book_id' => $this->id,
                    'user_data' => \GuzzleHttp\json_encode([
                        'current_page' => 1
                    ])
                ];
                $user_read_book_link->setRawAttributes($data);
                $user_read_book_link->hash = hash('sha256', serialize($data));
                if($user_read_book_link->save()){
                    return route('read_book', $user_read_book_link->hash);
                }
            }
        }
        return null;
    }
}
