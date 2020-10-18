<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    const BANNER_MAIN_TYPE = 'main';
    const BANNER_ADVERTISING_TYPE = 'custom';

    protected $table = 'banners';

    protected $fillable = [
      'title', 'redirect', 'file_url', 'type', 'background_color'
    ];

    public static function getBannerTypes(){
        return [
            self::BANNER_MAIN_TYPE => 'Главный баннер',
            self::BANNER_ADVERTISING_TYPE => 'Рекламный баннер',
        ];
    }

    public function type_name(){
        $types = $this->getBannerTypes();
        if(array_key_exists($this->type, $types)){
            return $types[$this->type];
        }
        return null;
    }
}
