<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InviteToVip extends Model
{
    protected $table = 'invite_to_vip';
    protected $fillable = ['user_id', 'invited_by'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function invited_user()
    {
        return $this->hasOne(User::class, 'id', 'invited_by');
    }

    public function codes()
    {
        return $this->hasMany(VipCode::class,'user_id','user_id');
    }
}
