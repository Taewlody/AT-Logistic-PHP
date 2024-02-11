<?php

namespace App\Livewire\Page\Marketing\TrailerBooking;

use App\Models\Common\Customer;
use App\Models\Common\Feeder;
use App\Models\Common\Supplier;
use App\Models\Marketing\JobOrder;
use App\Models\Marketing\TrailerBooking;
use Livewire\Component;
use Livewire\Attributes\Url;

class Form extends Component
{

    #[Url]
    public $action = '';
    #[Url]
    public $id = '';

    public ?TrailerBooking $data = null;

    public $customerList = [];
    public $feederList = [];
    public $supplierList = [];
    public $jobOrderList = [];

    public function boot()
    {
        $this->data = new TrailerBooking();
        if ($this->action == '') {
            $this->action = 'view';
        } else {
            $this->action;
        }

        if ($this->id != '') {
            $this->data = TrailerBooking::find($this->id);
        } else {
            $this->action = 'create';
        }

        $this->customerList = Customer::all();
        $this->feederList = Feeder::all();
        $this->supplierList = Supplier::all();
        $this->jobOrderList = JobOrder::all();
    }

    public function render()
    {
        return view('livewire.page.marketing.trailer-booking.form')->extends('layouts.main')->section('main-content');
    }
}
