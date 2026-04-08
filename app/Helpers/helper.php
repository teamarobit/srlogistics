<?php

use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Models\Cotype;
use App\Models\User;
use App\Models\Organisation;
use App\Models\Organisationuser;
use App\Models\Tyre;

if(! function_exists('allcotypes'))
{
    function allcotypes()
    {
        return Cotype::get();
    }
}


if (!function_exists('organisation_id')) {
    function organisation_id()
    {
        return Auth::user()?->organisation?->id;
    }
}


if (!function_exists('organisation_name')) {
    function organisation_name()
    {
        return optional(Auth::user()?->organisation)->name;
    }
}



if(! function_exists('getPhoneCode'))
{
    function getPhoneCode()
    {
        $ip = request()->ip();

        $response = @file_get_contents("http://ip-api.com/json/{$ip}");
        $data = json_decode($response, true);
        
        $countryCode = $data['countryCode'] ?? 'IN';
        
        $phoneCode = [
            'IN' => '+91',
            'US' => '+1',
            'GB' => '+44',
            'AU' => '+61',
            'CA' => '+1',
            'AE' => '+971',
        ][$countryCode] ?? '+91';

        return $phoneCode;
    }
}

if(!function_exists('getTyreLifeInfo')){
    function getTyreLifeInfo($tyre_id){
        $lifeInfo = [
                        'life_percent' => '-',
                        'life_border_class' => 'bg-secondary',
                        'life_fill_class' => 'bg-secondary',
                        'life_color' => 'grey',
                        'life_text' => 'N/A',
                        'icon' => asset('images/icons/tyre-default.png')
                    ];
        $tyre = Tyre::find($tyre_id);
        if($tyre){
            if($tyre->fixed_run_km != NULL && $tyre->actual_run_km != NULL && $tyre->fixed_run_km != 0){
                $used_percent = round($tyre->actual_run_km * 100 / $tyre->fixed_run_km);
                $life_percent = 100 - $used_percent;
                if($life_percent >= 70){
                    $lifeInfo['life_percent'] = $life_percent;
                    $lifeInfo['life_border_class'] = 'reg-active';
                    $lifeInfo['life_fill_class'] = 'bg-success';
                    $lifeInfo['life_color'] = 'green';
                    $lifeInfo['life_text'] = 'Good';
                    $lifeInfo['icon'] = asset('images/icons/tyre-success.png');
                }elseif($life_percent >= 30){
                    $lifeInfo['life_percent'] = $life_percent;
                    $lifeInfo['life_border_class'] = 'bg-warning';
                    $lifeInfo['life_fill_class'] = 'bg-warning';
                    $lifeInfo['life_color'] = 'yellow';
                    $lifeInfo['life_text'] = 'Warning';
                    $lifeInfo['icon'] = asset('images/icons/tyre-warning.png');
                }else{
                    $lifeInfo['life_percent'] = $life_percent;
                    $lifeInfo['life_border_class'] = 'reg-inactive';
                    $lifeInfo['life_fill_class'] = 'bg-danger';
                    $lifeInfo['life_color'] = 'red';
                    $lifeInfo['life_text'] = 'Critical';
                    $lifeInfo['icon'] = asset('images/icons/tyre-danger.png');
                }
            }
        }
        
        return $lifeInfo;
    }
}


















