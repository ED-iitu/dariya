<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';

    protected $primaryKey = 'transaction_id';

    protected $fillable = [
      'user_id', 'transaction_type', 'object_id', 'amount', 'processor_transaction_id', 'status'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
