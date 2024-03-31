<?php

namespace App\Livewire\Page\Report\ReportSaleTaxInvoice;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Account\TaxInvoice;

class Page extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.page.report.report-sale-tax-invoice.page', [
            'data' => TaxInvoice::with('customer')->orderBy('documentID', 'DESC')->paginate(20)
        ])->extends('layouts.main')->section('main-content');
    }
}
