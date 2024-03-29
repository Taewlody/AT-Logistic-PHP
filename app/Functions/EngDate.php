<?php
namespace App\Functions;

use App\Models\Payment\AdvancePayment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class EngDate
{
    public static function short_month_list(){
        $month = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul","Aug", "Sep", "Oct", "Nov", "Dec"];
        return $month;
    }

    public static function full_month_list(){
        $month = ["January","February","March","April","May","June","July",
        "August","September","October","November","December"];
        return $month;
    }
}