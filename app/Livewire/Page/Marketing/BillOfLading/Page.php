<?php

namespace App\Livewire\Page\Marketing\BillOfLading;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

use App\Models\Common\Customer;
use App\Models\Common\Saleman;
use App\Models\Marketing\BillOfLading;

class Page extends Component
{
    use WithPagination;

    public $dateStart;
    public $dateEnd;
    public $customerList = [];
    public $customerSearch = "";
    public $salemanList = [];
    public $salemanSearch = "";

    public function mount(){
        $this->dateStart = Carbon::now()->subYear()->format('d/m/Y');
        $this->dateEnd = Carbon::now()->format('d/m/Y');
        $this->customerList = Customer::all()->sortBy('custNameEN');
        $this->salemanList = Saleman::all()->sortBy('empName');
    }

    public function render()
    {
        return view('livewire.page.marketing.bill-of-lading.page', [ 'data'=> BillOfLading::paginate(50)])->extends('layouts.main')->section('main-content');
    }
}
