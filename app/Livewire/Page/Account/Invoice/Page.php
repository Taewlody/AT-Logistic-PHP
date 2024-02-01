<?php

namespace App\Livewire\Page\Account\Invoice;

use Livewire\Attributes\On;
use App\Models\Account\Invoice;
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
    public $salemanList = [];
    public $salemanSearch = "";
    public $invoiceNo = "";
    public $jobNo = "";
    public $query = [];

    public function mount(){
        $this->dateStart = Carbon::now()->subYear()->format('d/m/Y');
        $this->dateEnd = Carbon::now()->format('d/m/Y');
        $this->customerList = Customer::all()->sortBy('cusNameEN');
        $this->salemanList = Saleman::all()->sortBy('salemanNameEN');
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
        if($this->salemanSearch != null) {
            $this->query[] = ['saleman', '=', $this->salemanSearch];
        }
        if($this->invoiceNo != null) {
            $this->query[] = ['documentID', 'like', '%'.$this->invoiceNo.'%'];
        }
        if($this->jobNo != null) {
            $this->query[] = ['ref_jobNo', 'like', '%'.$this->jobNo.'%'];
        }
    }

    public function render()
    {
        return view('livewire.page.account.invoice.page', [ 'data'=> Invoice::where($this->query)->orderBy('documentDate', 'desc')->paginate(50)])->extends('layouts.main')->section('main-content');
    }
}
