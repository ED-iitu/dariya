<?php

namespace App;

use DateInterval;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kodeine\Acl\Traits\HasRole;
use Laravel\Sanctum\HasApiTokens;
use MadWeb\SocialAuth\Contracts\SocialAuthenticatable;
use MadWeb\SocialAuth\Models\SocialProvider;
use Laravel\Socialite\Contracts\User as UserContract;


class User extends Authenticatable implements SocialAuthenticatable
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
            UserBook::class,
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
     * Get all of favorite all for the user.
     */
    public function favorites()
    {
        return $this->belongsToMany(Book::class, 'favorites', 'user_id', 'object_id');
    }

    /**
     * Get all of favorite books for the user.
     */
    public function favorites_books()
    {
        return $this->belongsToMany(Book::class, 'favorites', 'user_id', 'object_id')
            ->wherePivot('object_type',Favorite::FAVORITE_BOOK_TYPE);
    }

    /**
     * Get all of favorite audio-books for the user.
     */
    public function favorites_audio_books()
    {
        return $this->belongsToMany(Book::class, 'favorites', 'user_id', 'object_id')
            ->wherePivot('object_type',Favorite::FAVORITE_AUDIO_BOOK_TYPE);
    }

    /**
     * Get all of favorite articles for the user.
     */
    public function favorites_articles()
    {
        return $this->belongsToMany(Article::class, 'favorites', 'user_id', 'object_id')
            ->wherePivot('object_type',Favorite::FAVORITE_ARTICLE_TYPE);
    }

    /**
     * Get all of favorite articles for the user.
     */
    public function favorites_videos()
    {
        return $this->belongsToMany(Video::class, 'favorites', 'user_id', 'object_id')
            ->wherePivot('object_type',Favorite::FAVORITE_VIDEO);
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
    /**
     * Provide ability to modify user data
     * received from social network.
     *
     * @param UserContract $socialUser
     * @return array
     */
    public function mapSocialData(UserContract $socialUser)
    {
        $raw = $socialUser->getRaw();
        $name = $socialUser->getName() ?? $socialUser->getNickname();
        $name = $name ?? $socialUser->getEmail();

        $result = [
            $this->getEmailField() => $socialUser->getEmail(),
            'name' => $name,
            'verified' => $raw['verified'] ?? true,
            'profile_photo_path' => $socialUser->getAvatar(),
        ];

        return $result;
    }

    /**
     * User socials relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function socials()
    {
        $social_pivot_table_name = config('social-auth.table_names.user_has_social_provider');

        return $this->belongsToMany(SocialProvider::class, $social_pivot_table_name);
    }

    /**
     * Check social network is attached to user.
     *
     * @param $slug
     * @return mixed
     */
    public function isAttached(string $slug): bool
    {
        return $this->socials()->where(['slug' => $slug])->exists();
    }

    /**
     * Attach social network provider to the user.
     *
     * @param SocialProvider $social
     * @param string $socialId
     * @param string $token
     * @param int $expiresIn
     */
    public function attachSocial($social, string $socialId, string $token, int $expiresIn = null)
    {
        $data = ['social_id' => $socialId, 'token' => $token];

        $expiresIn = $expiresIn
            ? date_create('now')
                ->add(DateInterval::createFromDateString($expiresIn.' seconds'))
                ->format($this->getDateFormat())
            : false;

        if ($expiresIn) {
            $data['expires_in'] = $expiresIn;
        }

        $this->socials()->attach($social, $data);
    }

    /**
     * Get model email field name.
     *
     * @return string
     */
    public function getEmailField(): string
    {
        return 'email';
    }

    public function shortUpperInitial(){
        if($this->name){
            return strtoupper(substr($this->name,0,2));
        }
        if($this->email){
            return strtoupper(substr($this->email,0,2));
        }
    }
}
