<?php

namespace App\Livewire\page\Account\PettyCash;

use Livewire\Attributes\On;
use App\Models\PettyCash\PettyCash;
use App\Models\Common\Customer;
use App\Models\Common\Saleman;
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
        $this->customerList = Customer::all()->sortBy('cusNameEN');
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
    }
    public function render()
    {
        return view('livewire.page.account.petty-cash.page', [ 'data'=> PettyCash::where($this->query)->orderBy('documentDate', 'desc')->paginate(20)])->extends('layouts.main')->section('main-content');
    }
}
