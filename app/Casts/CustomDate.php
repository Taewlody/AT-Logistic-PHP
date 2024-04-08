<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CustomDate implements CastsAttributes {
    public function get(Model $model, string $key, mixed $value, array $attributes) {
        // Log::debug("get value date: $value");
        // return $value == "0000-00-00" ? Carbon::createFromTimestamp(0)->setTimezone('UTC')->format('Y-m-d') : Carbon::parse($value)->setTimezone('UTC')->format('Y-m-d');
        if($value == null || $value == "" || $value == "0000-00-00" )
            null;
        else
            return Carbon::parse($value)->setTimezone('UTC')->format('Y-m-d');
        // return $value == "0000-00-00" ? "" : Carbon::parse($value)->setTimezone('UTC')->format('Y-m-d');
    }
    public function set(Model $model, string $key, mixed $value, array $attributes) {
        // Log::debug("set value date [".gettype($value)."]: $value");
        // return $value == "0000-00-00" ? Carbon::createFromTimestamp(0)->setTimezone('UTC')->format('Y-m-d') : Carbon::parse($value)->setTimezone('UTC')->format('Y-m-d');
        if($value == null || $value == "" || $value == "0000-00-00" )
            null;
        else
            return Carbon::parse($value)->setTimezone('UTC')->format('Y-m-d');
    }
}