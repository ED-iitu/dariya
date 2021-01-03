<?php


namespace App\Shared;

use App\Helpers\Formatter;
use Illuminate\Support\Str;

trait PriceCode
{
    public static $prices = [
        99,
        199,
        399,
        799,
        1190,
        1590,
        1990,
        2290,
        2490,
        2990,
        3490,
        3990,
        4290,
        4490,
        4990,
        5490,
        5990,
        6290,
        6490,
        6990,
        7490,
        7990,
        8290,
        8490,
        8990,
        9490,
        9990,
        10290,
        10490,
        10990,
        11490,
        11990,
        12290,
        12490,
        12990,
        13290,
        13490,
        13990,
        14290,
        14490,
        14990,
        15490,
        15990,
        16290,
        16490,
        16990,
        17490,
        17990,
        18290,
        18490,
        18990,
        19990,
        20990,
        22990,
        24990,
        27990,
        29990,
        30990,
        32990,
        34990,
        37990,
        39990,
        42990,
        44990,
        47990,
        49990,
        54990,
        57990,
        59990,
        64990,
        67990,
        69990,
        74990,
        77990,
        79990,
        84990,
        89990,
        94990,
        99990,
        119990,
        139990,
        149990,
        179990,
        199990,
        229990,
        279990,
        299990,
        349990,
        399990,
    ];
    public $slug_field = 'name';

    public function generatePriceCode()
    {
        if ($string = $this->getAttribute($this->slug_field)) {
            $code = Formatter::transliterate($string, '_', true);
            $code = Str::limit($code,20,'');
            $code .= '_'.$this->id;
            $this->price_id = $code;
        }
        return false;
    }
}