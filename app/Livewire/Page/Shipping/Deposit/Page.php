<?php

namespace App\Livewire\Page\Shipping\Deposit;

use Livewire\Attributes\On;
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
    public $jobNo = "";
    public $query = [];
    
    public function mount(){
        $this->dateStart = Carbon::now()->subDays(7)->toDateString();
        $this->dateEnd = Carbon::now()->toDateString();
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
        if($this->customerSearch != null) {
            $this->query[] = ['cusCode', '=', $this->customerSearch];
        }
        if($this->documentNo != null) {
            $this->query[] = ['documentID', 'like', '%'.$this->documentNo.'%'];
        }
        if($this->jobNo != null) {
            $this->query[] = ['refJobNo', 'like', '%'.$this->jobNo.'%'];
        }
        // dd($this->query);
    }

    public function render()
    {
        return view('livewire.page.shipping.deposit.page', [ 'data'=> Deposit::whereBetween('documentDate', [$this->dateStart, $this->dateEnd] )->where($this->query)->orderBy('documentstatus', 'DESC')->orderBy('documentID', 'DESC')->paginate(20)])->extends('layouts.main')->section('main-content');
    }
}
