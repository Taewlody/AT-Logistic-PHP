<?php

namespace App\Livewire\Page\Shipping\Deposit;

use App\Models\Common\BankAccount;
use App\Models\Common\Customer;
use App\Models\Common\Supplier;
use App\Models\Marketing\JobOrder;
use App\Models\Shipping\Deposit;
use Livewire\Component;
use Livewire\Attributes\Url;

class Form extends Component
{
    #[Url]
    public $action = '';
    #[Url]
    public $id = '';

    public $customerList = [];
    public $jobList = [];
    public $supplierList = [];
    public $accountList = [];

    public ?Deposit $data = null;

    public function boot()
    {
        $this->data = new Deposit();
        if ($this->action == '') {
            $this->action = 'view';
        } else {
            $this->action;
        }

        if ($this->id != '') {
            $this->data = Deposit::find($this->id);
        } else {
            $this->action = 'create';
        }

        $this->customerList = Customer::select('cusCode', 'custNameEN')->without('country', 'saleman', 'creditType', 'createBy', 'editBy')->get();
        $this->jobList = JobOrder::select("documentID")->get();
        $this->supplierList = Supplier::select("supCode", "supNameEN")->get();
        $this->accountList = BankAccount::select("accountCode", "accountName")->get();

    }

    public function render()
    {
        return view('livewire.page.shipping.deposit.form')->extends('layouts.main')->section('main-content');
    }
}
