<?php

namespace App\Livewire\Page\Shipping\Deposit;

use App\Models\Common\BankAccount;
use App\Models\Common\Charges;
use App\Models\Common\Customer;
use App\Models\Common\Supplier;
use App\Models\Marketing\JobOrder;
use App\Models\Shipping\Deposit;
use App\Models\Shipping\DepositItems;
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

    public string $chargeCode = '';

    public ?Deposit $data = null;

    public Collection $payments;

    protected array $rules = [
        'payments.*' => 'unique:App\Models\Shipping\DepositItems',
        'payments.*.autoid' => 'integer',
        'payments.*.comCode' => 'string',
        'payments.*.documentID' => 'string',
        'payments.*.invNo' => 'string',
        'payments.*.chargeCode' => 'string',
        'payments.*.chartDetail' => 'string',
        'payments.*.amount' => 'float'
    ];

    public function mount()
    {
        $this->data = new Deposit;
        if ($this->action == '') {
            $this->action = 'view';
        } else {
            $this->action;
        }

        if ($this->id != '') {
            $this->data = Deposit::find($this->id);
            $this->payments = $this->data->items;
        } else {
            $this->action = 'create';
            $this->data->createID = Auth::user()->usercode;
        }
    }

    public function addPayment() {
        $charge = Charges::find($this->chargeCode);
        $newCharge = new DepositItems;
        $newCharge->documentID = $this->data->documentID;
        $newCharge->chargeCode = $this->chargeCode;
        $newCharge->chartDetail = $charge->chargeName;
        $this->payments->push($newCharge);
        $this->reset('chargeCode');
    }

    public function removePayment(int $index) {
        $this->payments->forget($index);
        $this->payments = $this->payments->values();
    }

    public function save() {
        $this->data->editID = Auth::user()->usercode;
        $this->data->save();
        $this->data->items()->saveMany($this->payments);
        $this->redirectRoute(name: 'deposit', navigate: true);
    }

    public function render()
    {
        return view('livewire.page.shipping.deposit.form')->extends('layouts.main')->section('main-content');
    }
}
