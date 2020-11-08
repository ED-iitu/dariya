<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TariffPriceList extends Model
{
    protected $table = 'tariff_price_lists';

    protected $fillable = [
      'price', 'duration'
    ];

    const DURAION_3_MONTH = 3;
    const DURAION_6_MONTH = 6;
    const DURAION_12_MONTH = 12;

    public function tariff()
    {
        return $this->hasOne(Tariff::class, 'id', 'tariff_id');
    }

    public static function getDurationLabels($duration = null){
        $labels = [
            self::DURAION_3_MONTH => '3 месяц',
            self::DURAION_6_MONTH => '6 месяц',
            self::DURAION_12_MONTH => '12 месяц',
        ];
        if(isset($labels[$duration])){
            return $labels[$duration];
        }
        return $labels;
    }
}
