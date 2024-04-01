<?php

namespace App\Livewire\Page\Report\ReportSaleTaxInvoice;

use Livewire\Component;
use Livewire\WithPagination;

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
