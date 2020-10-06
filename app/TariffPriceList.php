<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TariffPriceList extends Model
{
    protected $table = 'tariff_price_lists';

    protected $fillable = [
      'price', 'duration'
    ];

    public function tariff()
    {
        return $this->hasOne(Tariff::class, 'id', 'tariff_id');
    }
}
