<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    protected $table = 'tariffs';

    protected $fillable = [
      'title', 'description', 'image_url', 'slug'
    ];

    public function tariffPriceLists()
    {
        return $this->hasMany(TariffPriceList::class,'tariff_id', 'id');
    }
}
