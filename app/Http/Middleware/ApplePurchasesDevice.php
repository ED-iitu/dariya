<?php

namespace App\Http\Middleware;

use App\ApplePurchaseDevice;
use App\User;
use Closure;

class ApplePurchasesDevice
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $device_id = $request->get('DeviceUID');
        if($device = ApplePurchaseDevice::query()->where('device_id' , $device_id)->first()){
            if($device->tariff_id && date('Y-m-d H:i:s', time()) < $device->tariff_end_date){

            };
        }
        return $next($request);
    }
}
