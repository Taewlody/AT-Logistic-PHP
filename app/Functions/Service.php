<?php

namespace App\Functions;

use App\Models\Common\BankAccount;
use App\Models\Common\Charges;
use App\Models\Common\ContainerSize;
use App\Models\Common\ContainerType;
use App\Models\Common\Customer;
use App\Models\Common\Feeder;
use App\Models\Common\Place;
use App\Models\Common\Port;
use App\Models\Common\Saleman;
use App\Models\Common\Supplier;
use App\Models\Common\TransportType;
use App\Models\Common\UnitContainer;
use App\Models\Marketing\JobOrder;
use Illuminate\Support\Facades\Cache;

class Service
{
    public static function MoneyFormat($number)
    {
        return number_format($number, 2,'.', ',');
    }

    public static function AccountSelecter(){
        return Cache::remember('account-select', 15, function () {
            return BankAccount::select('accountCode', 'accountName')->orderBy('accountName')->get();
        });
    }

    public static function TransportTypeSelecter(){
        return Cache::remember('transport-type-select', 15, function () {
            return TransportType::select('transportCode', 'transportName')->orderBy('transportName')->get();
        });
    }

    public static function PortSelecter(){
        return Cache::remember('port-select', 15, function () {
            return Port::select('portCode', 'portNameEN')->orderBy('portNameEN')->get();
        });
    }

    public static function PlaceSelecter(){
    return Cache::remember('place-select', 15, function () {
        return Place::select('pCode', 'pName')->orderBy('pName')->get();
    });
    }

    public static function CustomerSelecter(){
        return Cache::remember('customer-select', 15, function () {
            return Customer::select('cusCode', 'custNameEN')->orderBy('custNameEN')->get();
        });
    }

    public static function SalemanSelecter(){
        return Cache::remember('salename-select', 15, function () {
            return Saleman::select('usercode', 'empName')->orderBy('empName')->get();
        });
    }

    public static function SupplierSelecter(){
        return Cache::remember('supplier-select', 15, function () {
            return Supplier::select('supCode', 'supNameTH')->orderBy('supNameTH')->get();
        });
    }

    public static function FeederSelecter(){
        return Cache::remember('feeder-select', 15, function () {
            return Feeder::select('fCode', 'fName')->orderBy('fName')->get();
        });
    }

    public static function ContainerTypeSelecter(){
        return Cache::remember('container-type-select', 15, function () {
            return ContainerType::select('containertypeCode', 'containertypeName')->orderBy('containertypeName')->get();
        });
    }

    public static function ContainerSizeSelecter(){
        return Cache::remember('container-size-select', 15, function () {
            return ContainerSize::select('containersizeCode', 'containersizeName')->orderBy('containersizeName')->get();
        });
    }

    public static function UnitContainerSelecter(){
        return Cache::remember('unit-select', 15, function () {
            return UnitContainer::select('unitCode', 'unitName')->orderBy('unitName')->get();
        });
    }

    public static function ChargesSelecter(){
        return Cache::remember('charge-select', 15, function () {
            return Charges::select('chargeCode', 'chargeName')->orderBy('chargeName')->get();
        });
    }

    public static function JobOrderSelecter(){
        return Cache::remember('job-order-select', 15, function () {
            return JobOrder::select('documentID')->orderBy('documentID')->get();
        });
    }
}