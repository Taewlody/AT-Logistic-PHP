<?php

namespace App\Livewire\Page\Customer\AdvancePayment;

use App\Models\Payment\AdvancePayment;
use Livewire\Component;
use Livewire\Attributes\Url;

class Form extends Component
{
    #[Url]
    public $action = '';
    #[Url]
    public $id = '';

    public ?AdvancePayment $data = null;

    public function boot()
    {
        $this->data = new AdvancePayment();
        if ($this->action == '') {
            $this->action = 'view';
        } else {
            $this->action;
        }

        if ($this->id != '') {
            $this->data = AdvancePayment::find($this->id);
        } else {
            $this->action = 'create';
        }
    }


    public function render()
    {
        return view('livewire.page.customer.advance-payment.form')->extends('layouts.main')->section('main-content');
    }
}
