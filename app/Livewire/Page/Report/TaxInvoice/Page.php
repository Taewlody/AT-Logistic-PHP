<?php

namespace App\Livewire\Page\Report\TaxInvoice;

use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use App\Functions\ThaiDate;
use Illuminate\Support\Facades\DB;

use App\Models\Account\TaxInvoice;

class Page extends Component
{
    use WithPagination;

    public $month = '';
    public $year = '';

    public $yearList = [];

    public $monthSearch = '';
    public $yearSearch = '';

    public $totalVat;
    public $amount;

    public function boot()
    {
        $this->monthSearch = (int) date('m');
        $this->yearSearch = date('Y');
    }

    #[Computed]
    public function getTotalAmount()
    {

        $results = TaxInvoice::withSum('items', 'chargesReceive')
            ->whereMonth('documentDate', $this->monthSearch)
            ->whereYear('documentDate', $this->yearSearch)
            ->get();

        $this->amount = $results->sum(function ($invoice) {
            return (float) $invoice['items_sum_charges_receive'];
        });

        return $this->amount;
    }

    #[Computed]
    public function getTotalVat()
    {

        $this->totalVat = TaxInvoice::whereMonth('documentDate', $this->monthSearch)->whereYear('documentDate', $this->yearSearch)->sum('total_vat');

        return $this->totalVat;
    }

    public function mount()
    {

        $this->month = date('m');
        $this->year = date('Y');

        $this->yearList = range(date('Y'), date('Y')-4);

    }

    public function render()
    {
        return view('livewire.page.report.tax-invoice.page',[ 
            'data'=> TaxInvoice::withSum('items', 'chargesReceive')
            ->whereMonth('documentDate', $this->monthSearch)
            ->whereYear('documentDate', $this->yearSearch)->paginate(20)
            ])->extends('layouts.main')->section('main-content');
    }
}
