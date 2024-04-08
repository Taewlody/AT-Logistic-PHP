<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CustomDateTime implements CastsAttributes {
    public function get(Model $model, string $key, mixed $value, array $attributes) {
        // Log::debug("get value date: $value");
        
        if($value == "") {
            // return Carbon::createFromTimestamp(0)->setTimezone('UTC')->format('Y-m-d H:i:s');
            return "";
        } else if($value < 1) {
            return '';
        } else {
            return Carbon::parse($value)->setTimezone('UTC')->format('Y-m-d H:i:s');
        }
    }
    public function set(Model $model, string $key, mixed $value, array $attributes) {
        // Log::debug("set value date [".gettype($value)."]: $value");
        
        return $value == "" ? '0000-00-00 00:00:00' : Carbon::parse($value)->setTimezone('UTC')->format('Y-m-d H:i:s');

    }
}