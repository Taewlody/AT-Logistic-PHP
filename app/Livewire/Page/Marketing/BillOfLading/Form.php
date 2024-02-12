<?php

namespace App\Livewire\Page\Marketing\BillOfLading;

use App\Models\Common\Customer;
use App\Models\Common\Supplier;
use App\Models\Marketing\BillOfLading;
use App\Models\Marketing\JobOrder;
use Livewire\Component;
use Livewire\Attributes\Url;

class Form extends Component
{
    #[Url]
    public $action = '';
    #[Url]
    public $id = '';

    public ?BillOfLading $data = null;

    public $customerList = [];
    public $supplierList = [];
    public $jobOrderList = [];

    public function boot()
    {
        $this->data = new BillOfLading();
        if ($this->action == '') {
            $this->action = 'view';
        } else {
            $this->action;
        }

        if ($this->id != '') {
            $this->data = BillOfLading::find($this->id);
        } else {
            $this->action = 'create';
        }

        $this->customerList = Customer::all();
        $this->supplierList = Supplier::all();
        $this->jobOrderList = JobOrder::all();
    }

    public function render()
    {
        return view('livewire.page.marketing.bill-of-lading.form')->extends('layouts.main')->section('main-content');
    }
}
