<?php

namespace App\Livewire\Page\Report\ReportSaleTaxInvoice;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

use App\Models\Account\TaxInvoice;
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
    }

    #[Computed]
    public function getTotalAmount()
    {
        $results = TaxInvoice::with('customer')->where($this->query)->orderBy('documentID', 'DESC')->sum('total_amt');
        return $results;
    }

    #[Computed]
    public function getTotalVat()
    {
        $results = TaxInvoice::with('customer')->where($this->query)->orderBy('documentID', 'DESC')->sum('total_Vat');
        return $results;
    }

    #[Computed]
    public function getTotalTax3()
    {
        $results = TaxInvoice::with('customer')->where($this->query)->orderBy('documentID', 'DESC')->sum('tax3');
        return $results;
    }

    #[Computed]
    public function getTotalTax1()
    {
        $results = TaxInvoice::with('customer')->where($this->query)->orderBy('documentID', 'DESC')->sum('tax1');
        return $results;
    }

    #[Computed]
    public function getTotalReserve()
    {
        $results = TaxInvoice::with('customer')->where($this->query)->orderBy('documentID', 'DESC')->sum('cus_paid');
        return $results;
    }

    #[Computed]
    public function getTotalNet()
    {
        $results = TaxInvoice::with('customer')->where($this->query)->orderBy('documentID', 'DESC')->sum('total_netamt');
        return $results;
    }

    public function mount()
    {
        $this->dateStart = null;
        $this->dateEnd = null;
        $this->customerList = Customer::all()->sortBy('custNameEN');

    }

    public function render()
    {
        return view('livewire.page.report.report-sale-tax-invoice.page', [
            'data' => TaxInvoice::with('customer')->where($this->query)->orderBy('documentID', 'DESC')->paginate(20)
        ])->extends('layouts.main')->section('main-content');
    }
}
