<?php

namespace App\Livewire\Page\Shipping\PettyCash;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

use App\Models\Common\Customer;
use App\Models\Shipping\PettyCashShipping;


class Page extends Component
{
    use WithPagination;
    public $dateStart;
    public $dateEnd;
    public $customerList = [];
    public $customerSearch = "";
    public $documentNo = "";
    public $jobNo = "";

    public function mount(){
        $this->dateStart = Carbon::now()->subYear()->format('d/m/Y');
        $this->dateEnd = Carbon::now()->format('d/m/Y');
        $this->customerList = Customer::all()->sortBy('custNameEN');
    }
    public function render()
    {
        return view('livewire.page.shipping.petty-cash.page', [ 'data'=> PettyCashShipping::paginate(50)])->extends('layouts.main')->section('content');
    }
}
