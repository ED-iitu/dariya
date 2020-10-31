<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PushSettingsValue extends Model
{
    protected $table = 'push_settings_value';

    protected $fillable = ['user_id', 'setting_id', 'value', 'created_at'];
}
