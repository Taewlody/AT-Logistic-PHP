<?php

namespace App\Livewire\Page\Shipping\PettyCash;

use App\Models\Common\Charges;
use App\Models\Common\Supplier;
use App\Models\Marketing\JobOrder;
use App\Models\PettyCash\PettyCashShipping;
use Livewire\Attributes\Url;
use Livewire\Component;

class Form extends Component
{

    #[Url]
    public $action = '';
    #[Url]
    public $id = '';

    public ?PettyCashShipping $data = null;

    public $supplierList = [];
    public $jobNoList = [];
    public $chargeList = [];

    public function boot()
    {
        $this->data = new PettyCashShipping();
        if ($this->action == '') {
            $this->action = 'view';
        } else {
            $this->action;
        }

        if ($this->id != '') {
            $this->data = PettyCashShipping::find($this->id);
        } else {
            $this->action = 'create';
        }

        $this->supplierList = Supplier::select('supCode', 'supNameEN')->get();
        $this->jobNoList = JobOrder::select('documentID')->get();
        $this->chargeList = Charges::select('chargeCode', 'chargeName')->get();
    }

    public function render()
    {
        return view('livewire.page.shipping.petty-cash.form')->extends('layouts.main')->section('main-content');
    }
}
