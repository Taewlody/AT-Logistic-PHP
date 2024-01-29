<?php

namespace App\Livewire\Page\Shipping\Deposit;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

use App\Models\Common\Customer;
use App\Models\Shipping\Deposit;

class Page extends Component
{
    use WithPagination;
    public $dateStart;
    public $dateEnd;
    public $customerList = [];
    public $customerSearch = "";
    public $documentNo = "";
    
    public function mount(){
        $this->dateStart = Carbon::now()->subYear()->format('d/m/Y');
        $this->dateEnd = Carbon::now()->format('d/m/Y');
        $this->customerList = Customer::all()->sortBy('custNameEN');
    }

    public function render()
    {
        return view('livewire.page.shipping.deposit.page', [ 'data'=> Deposit::paginate(50)])->extends('layouts.main')->section('main-content');
    }
}
