<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Book extends Model
{

    use MultiLang;

    const BOOK_TYPE = 'BOOK';
    const AUDIO_BOOK_TYPE = 'AUDIO';

    protected $table = 'books';

    protected $fillable = [
        'name', 'type', 'preview_text', 'detail_text', 'lang',
        'publisher_id', 'price', 'author_id', 'genres', 'image_link', 'book_link', 'is_free', 'background_color', 'page_count', 'pdf_hash', 'duration'
    ];

    public function author()
    {
        return $this->hasOne(Author::class, 'id', 'author_id');
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
        return $this->hasMany(Comment::class, 'object_id', 'id')->where('object_type', '=', Comment::BOOK_TYPE);
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
}
