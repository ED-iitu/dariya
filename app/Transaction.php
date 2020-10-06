<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    const TRANSACTION_TYPE_TARIFF = 'tariff';
    const TRANSACTION_TYPE_PRODUCT = 'product';

    protected $table = 'transactions';

    protected $primaryKey = 'transaction_id';

    protected $fillable = [
      'user_id', 'transaction_type', 'object_id', 'amount', 'processor_transaction_id', 'status'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function geTypes(){
        return [self::TRANSACTION_TYPE_PRODUCT, self::TRANSACTION_TYPE_TARIFF];
    }
}
