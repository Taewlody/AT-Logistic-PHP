<?php

namespace App\Livewire\Page\Shipping\PaymentVoucher;

use App\Models\Common\Supplier;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use App\Models\Shipping\PaymentVoucher;

class Page extends Component
{
    use WithPagination;

    public $dateStart;
    public $dateEnd;
    public $supplierList = [];
    public $supplierSearch = "";
    public $documentNo = "";
    public $jobNo = "";

    public function mount(){
        $this->dateStart = Carbon::now()->subYear()->format('d/m/Y');
        $this->dateEnd = Carbon::now()->format('d/m/Y');
        $this->supplierList = Supplier::all()->sortBy('supNameEN');
    }

    public function render()
    {
        return view('livewire.page.shipping.payment-voucher.page', [ 'data'=> PaymentVoucher::paginate(50)])->extends('layouts.main')->section('content');
    }
}
