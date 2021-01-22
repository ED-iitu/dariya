<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class Device extends Model
{
    public static function saveDevice(User $user)
    {
        if ($device_id = Request::header('DeviceUID')) {
            if (!Device::query()->where(['device_id' => $device_id, 'user_id' => $user->id])->exists()) {
                $device = new Device();
                $device->device_id =  $device_id;
                $device->user_id =  $user->id;
                $device->save();
            }
        }
    }
}
