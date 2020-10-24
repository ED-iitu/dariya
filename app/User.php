<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kodeine\Acl\Traits\HasRole;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use Notifiable, HasApiTokens, HasRole;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'date_of_birth',
        'tariff_id',
        'tariff_price_list',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function transactions()
    {
        return $this->HasMany(Transaction::class, 'id');
    }

    public function books()
    {
        return $this->hasManyThrough(
            Book::class,
            UserBuyedBook::class,
            'user_id',
            'id',
            'id',
            'book_id'
        );
    }

    public function book_shelfs()
    {
        return $this->HasMany(BookShelf::class, 'user_id','id');
    }

    public function tariff(){
        return $this->hasOne(Tariff::class,'id','tariff_id');
    }

    public function tariff_price_list(){
        return $this->hasOne(TariffPriceList::class,'id','tariff_price_list_id');
    }

    public function have_active_tariff(){
         return ($this->tariff_id && date('Y-m-d H:i:s', time()) < $this->tariff_end_date) ? true : false;
    }

    /**
     * Get all of favorite posts for the user.
     */
    public function favorites()
    {
        return $this->belongsToMany(Book::class, 'favorites', 'user_id', 'object_id');
    }

    public function getRatingForArticle($article_id){
        $rating = Rating::query()->where(['object_id' => $article_id,'object_type' => Rating::ARTICLE_TYPE,'author_id' => $this->id])->orderBy('created_at', 'desc')->first();
        if($rating){
            return $rating->rate;
        }
        return null;
    }

    public function getRatingForBook($book_id){
        $rating = Rating::query()->where(['object_id' => $book_id,'object_type' => Rating::BOOK_TYPE,'author_id' => $this->id])->orderBy('created_at', 'desc')->first();
        if($rating){
            return $rating->rate;
        }
        return null;
    }
}
