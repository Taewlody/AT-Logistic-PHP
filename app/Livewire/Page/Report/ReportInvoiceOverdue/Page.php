<?php

namespace App\Livewire\Page\Report\ReportInvoiceOverdue;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Account\Invoice;

class Page extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.page.report.report-invoice-overdue.page', [
            'data' => Invoice::with(['customer', 'salemanRef'])->whereDoesntHave('taxInvoiceItems')->where('documentstatus', 'A')->orderBy('documentID', 'DESC')->paginate(20)
        ])->extends('layouts.main')->section('main-content');
    }
}
