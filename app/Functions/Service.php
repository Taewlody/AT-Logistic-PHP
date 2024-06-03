<?php

namespace App\Functions;

use App\Enum\Role;
use App\Models\Common\BankAccount;
use App\Models\Common\Charges;
use App\Models\Common\Commodity;
use App\Models\Common\ContainerSize;
use App\Models\Common\ContainerType;
use App\Models\Common\Country;
use App\Models\Common\CreditTerm;
use App\Models\Common\Customer;
use App\Models\Common\Feeder;
use App\Models\Common\Place;
use App\Models\Common\Port;
use App\Models\Common\Saleman;
use App\Models\Common\Supplier;
use App\Models\Common\TransportType;
use App\Models\Common\UnitContainer;
use App\Models\Marketing\JobOrder;
use App\Models\Account\Invoice;
use App\Models\User;
use App\Models\UserType;
use Auth;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Cache;

class Service
{

    private static function ReadNumber($number)
    {
        $position_call = array("แสน", "หมื่น", "พัน", "ร้อย", "สิบ", "");
        $number_call = array("", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า");
        $number = $number + 0;
        $ret = "";
        if ($number == 0)
            return $ret;
        if ($number > 1000000) {
            $ret .= self::ReadNumber(intval($number / 1000000)) . "ล้าน";
            $number = intval(fmod($number, 1000000));
        }

        $divider = 100000;
        $pos = 0;
        while ($number > 0) {
            $d = intval($number / $divider);
            $ret .= (($divider == 10) && ($d == 2)) ? "ยี่" :
            ((($divider == 10) && ($d == 1)) ? "" :
                ((($divider == 1) && ($d == 1) && ($ret != "")) ? "เอ็ด" : $number_call[$d]));
            $ret .= ($d ? $position_call[$pos] : "");
            $number = $number % $divider;
            $divider = $divider / 10;
            $pos++;
        }
        return $ret;
    }

    public static function MoneyFormat($number)
    {
        return number_format($number, 2, '.', ',');
    }

    public static function ThaiBahtConversion($amount_number)
    {
        $amount_number = number_format($amount_number, 2, ".", "");
        $pt = strpos($amount_number, ".");
        $number = $fraction = "";
        if ($pt === false)
            $number = $amount_number;
        else {
            $number = substr($amount_number, 0, $pt);
            $fraction = substr($amount_number, $pt + 1);
        }

        $ret = "";
        $baht = self::ReadNumber($number);
        if ($baht != "")
            $ret .= $baht . "บาท";

        $satang = self::ReadNumber($fraction);
        if ($satang != "")
            $ret .= $satang . "สตางค์";
        else
            $ret .= "ถ้วน";
        return $ret;
    }

    public static function DateFormat($date, bool|null $empty = false)
    {
        
        return $date == null || Carbon::parse($date) == Carbon::createFromTimestamp(0) ? ($empty ? "" : "00/00/0000") : Carbon::parse($date)->format('d/m/Y');
    }

    public static function CountrySelecter()
    {
        return Cache::remember('country-select', 15, function () {
            return Country::select('countryCode', 'countryNameEN')->orderBy('countryNameEN')->get();
        });
    }

    public static function AccountSelecter()
    {
        return Cache::remember('account-select', 15, function () {
            return BankAccount::select('accountCode', 'accountName')->where('isActive', '=', '1')->orderBy('accountName')->get();
        });
    }

    public static function TransportTypeSelecter()
    {
        return Cache::remember('transport-type-select', 15, function () {
            return TransportType::select('transportCode', 'transportName')->where('isActive', '=', '1')->orderBy('transportName')->get();
        });
    }

    public static function PortSelecter()
    {
        return Cache::remember('port-select', 15, function () {
            return Port::select('portCode', 'portNameEN')->where('isActive', '=', '1')->orderBy('portNameEN')->get();
        });
    }

    public static function PlaceSelecter()
    {
        return Cache::remember('place-select', 15, function () {
            return Place::select('pCode', 'pName')->orderBy('pName')->where('isActive', '=', '1')->get();
        });
    }

    public static function CustomerSelecter(bool|null $checkRole = true)
    {
        return Cache::remember('customer-select', 15, function () use ($checkRole) {
            if ($checkRole && Auth::user()->UserType?->userTypeName == 'Customer'){
                return Customer::select('cusCode', 'custNameEN')->where('isActive', '=', '1')->where('usercode', '=', Auth::user()->usercode)->orderBy('custNameEN')->get();
            } else {
                return Customer::select('cusCode', 'custNameEN')->where('isActive', '=', '1')->orderBy('custNameEN')->get();
            }
        });
    }

    public static function SalemanSelecter()
    {
        return Cache::remember('salename-select', 15, function () {
            return Saleman::select('usercode', 'empName')->where('isActive', '=', '1')->orderBy('empName')->get();
        });
    }

    public static function AllSalemanSelecter()
    {
        return Cache::remember('salename-select', 15, function () {
            return Saleman::select('usercode', 'empName')->orderBy('empName')->get();
        });
    }

    public static function SupplierSelecter()
    {
        return Cache::remember('supplier-select', 15, function () {
            return Supplier::select('supCode', 'supNameTH', 'supNameEN')->where('isActive', '=', '1')->orderBy('supNameEN')->get();
        });
    }

    public static function FeederSelecter()
    {
        return Cache::remember('feeder-select', 15, function () {
            return Feeder::select('fCode', 'fName')->where('isActive', '=', '1')->orderBy('fName')->get();
        });
    }

    public static function ContainerTypeSelecter()
    {
        return Cache::remember('container-type-select', 15, function () {
            return ContainerType::select('containertypeCode', 'containertypeName')->where('isActive', '=', '1')->orderBy('containertypeName')->get();
        });
    }

    public static function ContainerSizeSelecter()
    {
        return Cache::remember('container-size-select', 15, function () {
            return ContainerSize::select('containersizeCode', 'containersizeName')->where('isActive', '=', '1')->orderBy('containersizeName')->get();
        });
    }

    public static function UnitContainerSelecter()
    {
        return Cache::remember('unit-select', 15, function () {
            return UnitContainer::select('unitCode', 'unitName')->where('isActive', '=', '1')->orderBy('unitName')->get();
        });
    }

    public static function ChargesSelecter()
    {
        return Cache::remember('charge-select', 15, function () {
            return Charges::select('chargeCode', 'chargeName')->where('isActive', '=', '1')->orderBy('chargeName')->get();
        });
    }

    public static function JobOrderSelecter(bool|null $approve = null)
    {
        return Cache::remember('job-order-select', 15, function () use ($approve) {
            if ($approve === null) {
                $invoice = Invoice::select('ref_jobNo')
                   ->where(function ($query) {
                       $query->where('taxivRef', '!=', '')
                             ->whereNotNull('taxivRef');
                   })
                   ->groupBy('ref_jobNo')
                   ->pluck('ref_jobNo');
                   

                return JobOrder::select('documentID', 'documentstatus')->whereNotIn('documentID', $invoice)->orderBy('documentID', 'desc')->get();
            }else{
                return JobOrder::select('documentID', 'documentstatus')->with('invoice')->where("documentstatus", "=", ($approve ? "A" : "P"))->orWhereHas('invoice', function($query) {
                    $query->where('taxivRef', '=', '');
                })->orWhereDoesntHave('invoice')->orderBy('documentID', 'desc')->get();
            }
        });
    }

    public static function CreditTermSelecter()
    {
        return Cache::remember('credit-term-select', 15, function () {
            return CreditTerm::select('creditCode', 'creditName')->where('isActive', '=', '1')->get();
        });
    }

    public static function CommoditySelecter()
    {
        return Cache::remember('commodity-select', 15, function () {
            return Commodity::select('commodityCode', 'commodityNameEN')->orderBy('commodityNameEN')->get();
        });
    }

    public static function UserSelecter(string|null $role = null)
    {
        return Cache::remember('user-role-select', 15, function () use ($role) {
            if ($role !== null) {
                return User::whereHas('UserType', function($q) use ($role) {
                    $q->where('userTypeName', $role);
                
                })->select('userCode', 'username')->where('isActive', '=', '1')->orderBy('username')->get();
            }else{
                return User::select('userCode', 'username')->where('isActive', '=', '1')->orderBy('username')->get();
            }
        });
    }

    public static function BusinessTypeSelecter()
    {
        return Cache::remember('business-type-select', 15, function () {
            return (object) array(
                ['id' => '1', 'name' => 'Corporation'], 
                ['id' => '2', 'name' =>'individual']
        );
        });
    }

    public static function CurrentDateDiff($date)
    {
        $now = Carbon::now();
        $diff = date_diff($now, date_create($date));
        return $diff->format('%R%a days');
    }

    public static function CheckDeleteJob($documentID)
    {
        $getJob = JobOrder::where('documentID', $documentID)->first();

        $getPaymentVoucher = $getJob->PaymentVoucher()->get()->toArray();
        $getPettyCash = $getJob->PettyCash()->get()->toArray();
        $getAdvancePayment = $getJob->AdvancePayment()->get()->toArray();

        $checkPaymentVoucher = [];
        $checkPettyCash = [];
        $checkAdvancePayment = [];

        if(count($getPaymentVoucher) > 0) {
            $checkPaymentVoucher = array_filter($getAdvancePayment, function ($object) {
                return $object['documentstatus'] === 'A';
            });
        }
        if(count($getPettyCash) > 0) {
            $checkPettyCash = array_filter($getPettyCash, function ($object) {
                return $object['documentstatus'] === 'A';
            });
        }
        if(count($getAdvancePayment) > 0) {
            $checkAdvancePayment = array_filter($getAdvancePayment, function ($object) {
                return $object['documentstatus'] === 'A';
            });
        }
        // dd(count($checkPaymentVoucher));
        if((count($checkPaymentVoucher)) > 0 || 
        (count($checkPettyCash)) > 0 || 
        (count($checkAdvancePayment)) > 0
        ) {
            return false;
        }else {
            return true;
        }
    }
}