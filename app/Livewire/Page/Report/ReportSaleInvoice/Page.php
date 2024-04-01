<?php

namespace App\Livewire\Page\Report\ReportSaleInvoice;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

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

    #[Computed]
    public function getTotalAmount()
    {
        $results = Invoice::with(['customer', 'salemanRef'])
            ->where('documentstatus', 'A')->orderBy('documentID', 'DESC')
            ->where($this->query)
            ->sum('total_amt');
        return $results;
    }

    #[Computed]
    public function getTotalVat()
    {
        $results = Invoice::with(['customer', 'salemanRef'])
            ->where('documentstatus', 'A')->orderBy('documentID', 'DESC')
            ->where($this->query)
            ->sum('total_Vat');
        return $results;
    }

    #[Computed]
    public function getTotalTax3()
    {
        $results = Invoice::with(['customer', 'salemanRef'])
            ->where('documentstatus', 'A')->orderBy('documentID', 'DESC')
            ->where($this->query)
            ->sum('tax3');
        return $results;
    }

    #[Computed]
    public function getTotalTax1()
    {
        $results = Invoice::with(['customer', 'salemanRef'])
            ->where('documentstatus', 'A')->orderBy('documentID', 'DESC')
            ->where($this->query)
            ->sum('tax1');
        return $results;
    }

    #[Computed]
    public function getTotalReserve()
    {
        $results = Invoice::with(['customer', 'salemanRef'])
            ->where('documentstatus', 'A')->orderBy('documentID', 'DESC')
            ->where($this->query)
            ->sum('cus_paid');
        return $results;
    }

    #[Computed]
    public function getTotalNet()
    {
        $results = Invoice::with(['customer', 'salemanRef'])
            ->where('documentstatus', 'A')->orderBy('documentID', 'DESC')
            ->where($this->query)
            ->sum('total_netamt');
        return $results;
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
