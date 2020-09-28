<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TariffPriceList extends Model
{
    protected $table = 'tariff_price_lists';

    protected $fillable = [
      'price', 'duration'
    ];

    public function tariffs()
    {
        return $this->belongsToMany(Tariff::class);
    }
}
