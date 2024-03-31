<?php

namespace App\Livewire\Page\Report\ReceiptVoucher;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Account\ReceiptVoucher;

class Page extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.page.report.receipt-voucher.page', [
            'data' => ReceiptVoucher::with(['items', 'customer', 'docStatus'])->orderBy('documentID', 'DESC')->paginate(20)
        ])->extends('layouts.main')->section('main-content');
    }
}
