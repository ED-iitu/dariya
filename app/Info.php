<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    const HELP_SUBSCRIBE_TYPE = 'sucscribe';
    const HELP_FAQ_TYPE = 'faq';

    protected $table = 'info';

    protected $fillable = [
        'title', 'text', 'type'
    ];

    public static function getTypeLabels(){
        return [
            self::HELP_SUBSCRIBE_TYPE => 'Все о подписке и покупке',
            self::HELP_FAQ_TYPE => 'Часто задаваемые вопросы'
        ];
    }
}
