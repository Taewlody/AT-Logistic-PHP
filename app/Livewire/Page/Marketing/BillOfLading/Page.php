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
    public $query = [];

    public function mount(){
        $this->dateStart = null;
        $this->dateEnd = null;
        $this->customerList = Customer::all()->sortBy('custNameEN');
        $this->salemanList = Saleman::all()->sortBy('empName');
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
        // if($this->salemanSearch != null) {
        //     $this->query[] = ['saleman', '=', $this->salemanSearch];
        // }
        // if($this->customerSearch != null) {
        //     $this->query[] = ['customerSearch', $this->customerSearch];
        // }
    }

    public function render()
    {
        return view('livewire.page.marketing.bill-of-lading.page', [ 'data'=> BillOfLading::where($this->query)->paginate(20)])->extends('layouts.main')->section('main-content');
    }
}
