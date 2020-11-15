<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InviteToVip extends Model
{
    protected $table = 'invite_to_vip';
    protected $fillable = ['user_id', 'invited_by'];

    public function user(){
        return $this->hasOne(User::class,'user_id','id');
    }
}
