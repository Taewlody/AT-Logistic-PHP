<?php
namespace App\Functions;

use App\Models\Payment\AdvancePayment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class ThaiDate
{
    public static function short_month_list(){
        $month = [ "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.", ];
        return $month;
    }

    public static function full_month_list(){
        $month = [ "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม", ];
        return $month;
    }
}