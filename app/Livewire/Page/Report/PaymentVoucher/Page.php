<?php

namespace App\Livewire\Page\Report\PaymentVoucher;

use Livewire\Component;
use Livewire\Attributes\Computed;

use App\Models\Payment\PaymentVoucher;

class Page extends Component
{
    public $monthSearch = '';
    public $yearSearch = '';
    public $yearList = [];

    public $sumTotal;
    public $sumTax7;

    public function boot()
    {
        $this->monthSearch = (int) date('m');
        $this->yearSearch = date('Y');
    }

    #[Computed]
    public function getSumTotal()
    {
        $this->sumTotal = PaymentVoucher::whereMonth('documentDate', $this->monthSearch)->whereYear('documentDate', $this->yearSearch)->sum('sumTotal');
        return $this->sumTotal;
    }

    #[Computed]
    public function getSumTax7()
    {
        $this->sumTax7 = PaymentVoucher::whereMonth('documentDate', $this->monthSearch)->whereYear('documentDate', $this->yearSearch)->sum('sumTax7');

        return $this->sumTax7;
    }

    public function mount()
    {
        $this->month = date('m');
        $this->year = date('Y');

        $this->yearList = range(date('Y'), date('Y')-4);
    }

    public function render()
    {
        return view('livewire.page.report.payment-voucher.page',[ 
            'data'=> PaymentVoucher::with('items')
            ->where('payment_voucher.purchasevat', 1)
            ->where('payment_voucher.documentstatus', 'A')
            ->whereMonth('documentDate', $this->monthSearch)
            ->whereYear('documentDate', $this->yearSearch)->paginate(20)
            ])->extends('layouts.main')->section('main-content');
    }
}
