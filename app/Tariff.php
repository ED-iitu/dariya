<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    protected $table = 'tariffs';

    protected $fillable = [
      'title', 'description', 'image_url'
    ];

    public function tariffPriceLists()
    {
        return $this->hasMany(TariffPriceList::class);
    }
}
