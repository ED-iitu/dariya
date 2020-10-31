<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PushSetting extends Model
{
    protected $table = 'push_settings';

    public function getValue(){
        if(Auth::user()){
            $value = PushSettingsValue::query()->where(['user_id' => Auth::id(), 'setting_id' => $this->id])->first();
            if($value){
                return (bool)$value->value;
            }
        }
        return false;
    }
}
