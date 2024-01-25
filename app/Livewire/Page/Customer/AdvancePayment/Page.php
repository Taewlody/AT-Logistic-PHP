<?php

namespace App\Livewire\Page\Customer\AdvancePayment;

use App\Models\Common\Customer;
use App\Models\Customer\AdvancePayment;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

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
        return view('livewire.page.customer.advance-payment.page', [ 'data'=> AdvancePayment::paginate(50)])->extends('layouts.main')->section('content');
    }
}
