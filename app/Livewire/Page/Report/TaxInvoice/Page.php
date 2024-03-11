<?php

namespace App\Livewire\Page\Report\TaxInvoice;

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

    public function boot()
    {
        $this->monthSearch = (int) date('m');
        $this->yearSearch = date('Y');
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
            'data'=> TaxInvoice::whereMonth('documentDate', $this->monthSearch)->whereYear('documentDate', $this->yearSearch)->paginate(20)
            ])->extends('layouts.main')->section('main-content');
    }
}
