<?php

namespace App\Livewire\Page\Customer\AdvancePayment;

use App\Models\Common\Charges;
use App\Models\Payment\AdvancePayment;
use App\Models\Payment\AdvancePaymentItems;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Url;

class Form extends Component
{
    #[Url]
    public $action = '';
    #[Url]
    public $id = '';

    public ?AdvancePayment $data = null;

    public Collection $items;

    public $chargeCode = 'C-032';

    protected array $rules = [
        'items.*' => 'unique:App\Models\Payment\AdvancePaymentItems',
        'items.*.autoid' => 'integer',
        'items.*.comCode' => 'string',
        'items.*.documentID' => 'string',
        'items.*.invNo' => 'string',
        'items.*.chargeCode' => 'string',
        'items.*.chartDetail' => 'string',
        'items.*.amount' => 'float',
    ];

    public function mount()
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
            $this->data->createID = Auth::user()->usercode;
        }
        $this->items = $this->data->items;
    }

    public function addCharge(){
        $charges = Charges::find($this->chargeCode);
        $newCharge = new AdvancePaymentItems;
        $newCharge->documentID = $this->data->documentID;
        $newCharge->chargeCode = $this->chargeCode;
        $newCharge->chartDetail = $charges->chargeName;
        $this->items->push($newCharge);
        $this->reset('chargeCode');
    }

    public function removeCharge(int $index){
        $this->items->forget($index);
        $this->items = $this->items->values();
    }

    public function save() {
        $this->data->editID = Auth::user()->usercode;
        $this->data->save();
        $this->data->items()->saveMany($this->items);
        $this->redirectRoute(name: 'advance-payment', navigate: true);
    }


    public function render()
    {
        return view('livewire.page.customer.advance-payment.form')->extends('layouts.main')->section('main-content');
    }
}
