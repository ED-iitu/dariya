<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserReadBookLink extends Model
{
    protected $casts = [
        'user_data' => 'array',
    ];
}
