<?php
namespace App\Functions;

use App\Models\Payment\AdvancePayment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class CalculatorPrice
{
    public static function cal_charge(Collection $charge){
        $cal_charge = [
            'tax7' => 0,
            'tax3' => 0,
            'tax1' => 0,
            'total' => 0,
        ];
        // $this->cal_charge['tax7'] = $this->data->charge->filter(function ($item) {
        //     return $item->charges->chargesType->amount == 7;
        // })->sum('chargesReceive') * 0.07;
        // Log::debug("cal_charge : ".print_r($charge, true));
        // if(!($charge->first() instanceof \App\Models\Job\JobOrderCharge) || $charge->isEmpty()){
        //     return $cal_charge;
        // }
        $cal_charge['tax7'] = $charge->sum('chargesReceive') * 0.07;
        $cal_charge['tax3'] = $charge->filter(function ($item) {
            if($item->charge == null || $item->charge->chargesType == null) return false;
            return $item->charges->chargesType->amount == 3;
        })->sum('chargesReceive') * 0.03;
        $cal_charge['tax1'] = $charge->filter(function ($item) {
            if($item->charge == null || $item->charge->chargesType == null) return false;
            return $item->charges->chargesType->amount == 1;
        })->sum('chargesReceive') * 0.01;
        $cal_charge['total'] = $charge->sum('chargesReceive') + $cal_charge['tax7'];
        return $cal_charge;
    }

    public static function cal_customer_piad($documentID) {
        return AdvancePayment::where('refJobNo', $documentID)->where('documentstatus', 'A')->get();
    }
}