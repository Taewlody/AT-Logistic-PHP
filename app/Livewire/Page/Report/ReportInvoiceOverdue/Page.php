<?php

namespace App\Livewire\Page\Report\ReportInvoiceOverdue;

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
    public $documentID = '';
    public $customerList = [];
    public $customerSearch = "";
    public $salemanList = [];
    public $salemanSearch = "";

    #[On('post-search')] 
    public function search() {
        $this->query = [];

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

    #[Computed]
    public function getTotalAmount()
    {
        $results = Invoice::with(['customer', 'salemanRef'])
        ->whereDoesntHave('taxInvoiceItems')
        ->where('documentstatus', 'A')
        ->where($this->query)
        ->orderBy('documentID', 'DESC')->sum('total_amt');
        return $results;
    }

    #[Computed]
    public function getTotalVat()
    {
        $results = Invoice::with(['customer', 'salemanRef'])
        ->whereDoesntHave('taxInvoiceItems')
        ->where('documentstatus', 'A')
        ->where($this->query)
        ->orderBy('documentID', 'DESC')->sum('total_Vat');
        return $results;
    }

    #[Computed]
    public function getTotalTax3()
    {
        $results = Invoice::with(['customer', 'salemanRef'])
        ->whereDoesntHave('taxInvoiceItems')
        ->where('documentstatus', 'A')
        ->where($this->query)
        ->orderBy('documentID', 'DESC')->sum('tax3');
        return $results;
    }

    #[Computed]
    public function getTotalTax1()
    {
        $results = Invoice::with(['customer', 'salemanRef'])
        ->whereDoesntHave('taxInvoiceItems')
        ->where('documentstatus', 'A')
        ->where($this->query)
        ->orderBy('documentID', 'DESC')->sum('tax1');
        return $results;
    }

    #[Computed]
    public function getTotalReserve()
    {
        $results = Invoice::with(['customer', 'salemanRef'])
        ->whereDoesntHave('taxInvoiceItems')
        ->where('documentstatus', 'A')
        ->where($this->query)
        ->orderBy('documentID', 'DESC')->sum('cus_paid');
        return $results;
    }

    #[Computed]
    public function getTotalNet()
    {
        $results = Invoice::with(['customer', 'salemanRef'])
        ->whereDoesntHave('taxInvoiceItems')
        ->where('documentstatus', 'A')
        ->where($this->query)
        ->orderBy('documentID', 'DESC')->sum('total_netamt');

        $cus_paid = Invoice::with(['customer', 'salemanRef'])
        ->whereDoesntHave('taxInvoiceItems')
        ->where($this->query)
        ->where('documentstatus', 'A')->sum('cus_paid');

        return $results - $cus_paid;
    }

    public function mount()
    {
        $this->customerList = Customer::all()->sortBy('custNameEN');
        $this->salemanList = Saleman::all()->sortBy('empName');

    }

    public function render()
    {
        return view('livewire.page.report.report-invoice-overdue.page', [
            'data' => Invoice::with(['customer', 'salemanRef'])
            ->whereDoesntHave('taxInvoiceItems')
            ->where('documentstatus', 'A')
            ->where($this->query)
            ->orderBy('documentID', 'DESC')->paginate(20)
        ])->extends('layouts.main')->section('main-content');
    }
}
