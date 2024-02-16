<?php

namespace App\Livewire\Page\Shipping\PaymentVoucher;

use App\Models\Common\BankAccount;
use App\Models\Common\Supplier;
use App\Models\Marketing\JobOrder;
use App\Models\Payment\ShipingPaymentVoucher;
use Livewire\Component;
use Livewire\Attributes\Url;

class Form extends Component
{
    #[Url]
    public $action = '';
    #[Url]
    public $id = '';

    public ?ShipingPaymentVoucher $data = null;

    public $supplierList = [];
    public $jobNoList = [];

    public $accountList = [];

    public function boot()
    {
        $this->data = new ShipingPaymentVoucher();
        if ($this->action == '') {
            $this->action = 'view';
        } else {
            $this->action;
        }

        if ($this->id != '') {
            $this->data = ShipingPaymentVoucher::find($this->id);
        } else {
            $this->action = 'create';
        }

        $this->supplierList = Supplier::all();
        $this->jobNoList = JobOrder::select('documentID')->get();
        $this->accountList = BankAccount::all();
    }

    public function render()
    {
        return view('livewire.page.shipping.payment-voucher.form')->extends('layouts.main')->section('main-content');
    }
}
