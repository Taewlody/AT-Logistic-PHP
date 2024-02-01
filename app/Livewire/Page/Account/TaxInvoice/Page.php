<?php

namespace App\Livewire\page\Account\TaxInvoice;

use Livewire\Attributes\On;
use App\Models\Account\TaxInvoice;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use App\Models\Common\Customer;

class Page extends Component
{

    use WithPagination;

    public $dateStart;
    public $dateEnd;
    public $customerList = [];
    public $customerSearch = "";
    public $salemanList = [];
    public $salemanSearch = "";
    public $documentNo = "";
    public $jobNo = "";
    public $query = [];

    public function mount(){
        $this->dateStart = Carbon::now()->subYear()->format('d/m/Y');
        $this->dateEnd = Carbon::now()->format('d/m/Y');
        $this->customerList = Customer::all()->sortBy('cusNameEN');
    }

    #[On('post-search')] 
    public function search() {
        $this->query = [];
        if($this->dateStart != null && $this->dateEnd != null) {
            $this->query[] = ['documentDate', '>=', Carbon::createFromFormat('d/m/Y', $this->dateStart)->format('Y-m-d')];
            $this->query[] = ['documentDate', '<=', Carbon::createFromFormat('d/m/Y', $this->dateEnd)->format('Y-m-d')];
        }
        if($this->customerSearch != null) {
            $this->query[] = ['cusCode', '=', $this->customerSearch];
        }
        if($this->documentNo != null) {
            $this->query[] = ['documentID', 'like', '%'.$this->documentNo.'%'];
        }
        if($this->jobNo != null) {
            $this->query[] = ['ref_jobNo', 'like', '%'.$this->jobNo.'%'];
        }
    }

    public function render()
    {
        return view('livewire.page.account.tax-invoice.page', [ 'data'=> TaxInvoice::where($this->query)->orderBy('documentDate', 'desc')->paginate(50)])->extends('layouts.main')->section('main-content');
    }
}
