<?php

namespace App;

use App\Helpers\Formatter;
use App\Shared\PriceCode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TariffPriceList extends Model
{
    use PriceCode;

    const DURAION_3_MONTH = 3;
    const DURAION_6_MONTH = 6;
    const DURAION_12_MONTH = 12;
    protected $table = 'tariff_price_lists';
    protected $fillable = [
        'price', 'duration'
    ];

    public static function getDurationLabels($duration = null)
    {
        $labels = [
            self::DURAION_3_MONTH => '3 месяц',
            self::DURAION_6_MONTH => '6 месяц',
            self::DURAION_12_MONTH => '12 месяц',
        ];
        if (isset($labels[$duration])) {
            return $labels[$duration];
        }
        return $labels;
    }

    public function tariff()
    {
        return $this->hasOne(Tariff::class, 'id', 'tariff_id');
    }

    public function generatePriceCode()
    {
        if ($string = $this->tariff->slug) {
            $code = Formatter::transliterate($string, '_', true);
            $code = Str::limit($code, 20, '');
            $code .= '_' . $this->duration . '_MONTH';
            $this->price_id = $code;
        }
        return false;
    }
}
