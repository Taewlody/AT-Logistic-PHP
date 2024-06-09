<?php
namespace App\Functions;

use App\Livewire\Page\Marketing\JobOrder\Element\Models\JobCharge;
use App\Models\Marketing\JobOrderCharge;
use App\Models\Payment\AdvancePayment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class CalculatorPrice
{
    public static function cal_charge(Collection $charge, float $commissionSale, float $commissionCustomers){
        $cal_charge = (object)[
            'tax7' => 0,
            'tax3' => 0,
            'tax1' => 0,
            'total' => 0,
        ];
        // $cal_charge->tax7 = ($charge->sum('chargesReceive') * 0.07) + ($commissionSale + $commissionCustomers);
        $cal_charge->tax7 = ($charge->sum('chargesReceive') * 0.07);
        $cal_charge->tax3 = $charge->filter(function (JobOrderCharge $item) {
            // if($item->charge == null || $item->charge->chargesType == null) return false;
            return (float)$item->charges?->chargesType?->amount == 3;
        })->sum('chargesReceive') * 0.03;
        $cal_charge->tax1 = $charge->filter(function (JobOrderCharge $item) {
            // Log::info($item->charges->chargesType->amount);
            // if($item->charge == null || $item->charge->chargesType == null) return false;
            // if($item->charge?->chargesType == null) return false;
            return (float)$item->charges?->chargesType?->amount == 1;
        })->sum('chargesReceive') * 0.01;
        $cal_charge->total = $charge->sum('chargesReceive') + $cal_charge->tax7;
        return $cal_charge;
    }

    public static function cal_customer_piad($documentID) {
        return AdvancePayment::where(['refJobNo'=> $documentID, 'documentstatus'=> 'A'])->get();
    }
}