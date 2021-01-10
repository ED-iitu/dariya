<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplePurchaseDevice extends Model
{
    protected $table = 'apple_purchase_devices';

    protected $fillable = ['device_id', 'price_id', 'receipt', 'receipt_check_data',
        'tariff_id', 'tariff_price_list_id', 'tariff_begin_date', 'tariff_end_date'];

    public function have_active_tariff(){
        return ($this->tariff_id && date('Y-m-d H:i:s', time()) < $this->tariff_end_date) ? true : false;
    }
}
