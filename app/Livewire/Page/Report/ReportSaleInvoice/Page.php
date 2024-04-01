<?php

namespace App\Livewire\Page\Report\ReportSaleInvoice;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Account\Invoice;
use App\Models\Common\Customer;
use App\Models\Common\Saleman;

class Page extends Component
{
    use WithPagination;

    public $query = [];
    public $dateStart;
    public $dateEnd;
    public $documentID = '';
    public $customerList = [];
    public $customerSearch = "";
    public $salemanList = [];
    public $salemanSearch = "";

    #[On('post-search')] 
    public function search() {
        $this->query = [];

        if($this->dateStart != null) {
            $this->query[] = ['documentDate', '>=', $this->dateStart];
        }
        if($this->dateEnd != null) {
            $this->query[] = ['documentDate', '<=', $this->dateEnd];
        }
        if($this->documentID != null) {
            $this->query[] = ['documentID', 'like', '%'.$this->documentID.'%'];
        }
        if($this->customerSearch != null) {
            $this->query[] = ['cusCode', '=', $this->customerSearch];
        }
        if($this->salemanSearch != null) {
            $this->query[] = ['saleman', '=', $this->salemanSearch];
        }
    }

    public function mount()
    {
        $this->dateStart = null;
        $this->dateEnd = null;
        $this->customerList = Customer::all()->sortBy('custNameEN');
        $this->salemanList = Saleman::all()->sortBy('empName');

    }
    
    public function render()
    {
        return view('livewire.page.report.report-sale-invoice.page', [
            'data' => Invoice::with(['customer', 'salemanRef'])
            ->where('documentstatus', 'A')->orderBy('documentID', 'DESC')
            ->where($this->query)
            ->paginate(20) 
        ])->extends('layouts.main')->section('main-content');
    }
}
