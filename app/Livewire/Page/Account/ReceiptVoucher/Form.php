<?php

namespace App\Livewire\Page\Account\ReceiptVoucher;

use App\Models\Account\ReceiptVoucher;
use App\Models\Common\BankAccount;
use App\Models\Common\Customer;
use App\Models\Common\Supplier;
use App\Models\Marketing\JobOrder;
use Livewire\Component;
use Livewire\Attributes\Url;

class Form extends Component
{
    #[Url]
    public $action = '';
    #[Url]
    public $id = '';

    public ?ReceiptVoucher $data = null;

    public $customerList = [];


    public $jobNoList = [];

    public $accountList = [];

    public function boot()
    {
        $this->data = new ReceiptVoucher();
        if ($this->action == '') {
            $this->action = 'view';
        } else {
            $this->action;
        }

        if ($this->id != '') {
            $this->data = ReceiptVoucher::find($this->id);
        } else {
            $this->action = 'create';
        }

        $this->customerList = Customer::all();
        $this->jobNoList = JobOrder::select('documentID')->get();
        $this->accountList = BankAccount::all();
    }
    public function render()
    {
        return view('livewire.page.account.receipt-voucher.form')->extends('layouts.main')->section('main-content');
    }
}
