<?php

namespace App\Livewire\Page\Account\TaxInvoice;

use App\Models\Account\TaxInvoice;
use App\Models\Common\BankAccount;
use App\Models\Common\CreditTerm;
use App\Models\Common\Customer;
use App\Models\Common\Saleman;
use App\Models\Common\Supplier;
use App\Models\Common\TransportType;
use App\Models\Marketing\JobOrder;
use Livewire\Component;
use Livewire\Attributes\Url;

class Form extends Component
{
    #[Url]
    public $action = '';
    #[Url]
    public $id = '';

    public ?TaxInvoice $data;

    public $creditTermList = [];

    public $TransportTypeList = [];

    public $jobList = [];

    public $salemanList = [];

    public $customerList = [];

    public $supplierList = [];

    public $accountList = [];


    public function boot()
    {
        if($this->action==''){
            $this->action = 'view';
        }else{
            $this->action;
        }
        if($this->id!=''){
            $this->data = TaxInvoice::find($this->id);
        }else{
            $this->action = 'create';
            $this->data = new TaxInvoice();
        }

        $this->creditTermList = CreditTerm::select('creditCode', 'creditName')->get();
        $this->TransportTypeList = TransportType::select('transportCode', 'transportName')->get();
        $this->jobList = JobOrder::select('documentID')->get();
        $this->salemanList = Saleman::select('usercode', 'empName')->get();
        $this->customerList = Customer::select('cusCode', 'custNameEN')->get();
        $this->supplierList = Supplier::select('supCode', 'supNameEN')->get();
        $this->accountList = BankAccount::select('accountCode', 'accountName')->get();
    }

    public function render()
    {
        return view('livewire.page.account.tax-invoice.form')->extends('layouts.main')->section('main-content');
    }
}
