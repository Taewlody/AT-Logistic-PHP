<?php

namespace App\Livewire\Page\Account\BillingReceipt;

use Livewire\Attributes\On;
use App\Models\Account\ReceiptVoucher;
use App\Models\Common\Customer;
use App\Models\Common\Saleman;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class Page extends Component
{
    public function render()
    {
        return view('livewire.page.account.billing-receipt.page', [ 'data'=> ReceiptVoucher::where($this->query)->orderBy('documentDate', 'desc')->paginate(50)])->extends('layouts.main');
    }
}
