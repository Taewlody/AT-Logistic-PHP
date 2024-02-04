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
    public $query = [];

    public function mount(){
        $this->dateStart = null;
        $this->dateEnd = null;
        $this->customerList = Customer::all()->sortBy('custNameEN');
    }

    #[On('post-search')] 
    public function search() {
        $this->query = [];
        if($this->dateStart != null) {
            $this->query[] = ['documentDate', '>=', $this->dateStart];
        }
        if($this->dateEnd != null) {
            $this->query[] = ['documentDate', '<=', $this->dateEnd];
        }
        if($this->jobNo != null) {
            $this->query[] = ['refJobNo', 'like', '%'.$this->jobNo.'%'];
        }
        if($this->documentNo != null) {
            $this->query[] = ['documentID', 'like', '%'.$this->documentNo.'%'];
        }
        // if($this->customerSearch != null) {
        //     $this->query[] = ['customerSearch', $this->customerSearch];
        // }
    }

    public function render()
    {
        return view('livewire.page.customer.advance-payment.page', [ 'data'=> AdvancePayment::where($this->query)->paginate(20)])->extends('layouts.main')->section('main-content');
    }
}
