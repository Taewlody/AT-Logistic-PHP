<?php

namespace App\Livewire\Page\Account\Invoice;

use App\Models\Account\Invoice;
use App\Models\Account\InvoiceItems;
use App\Models\Common\Charges;
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
    public ?Invoice $data = null;

    public Collection $payments;

    protected array $rules = [
        'payments.*' => 'unique:App\Models\Account\InvoiceItems',
        'payments.*.items' => 'integer',
        'payments.*.comCode' => 'string',
        'payments.*.documentID' => 'string',
        'payments.*.chargeCode' => 'string',
        'payments.*.detail' => 'string',
        'payments.*.chargesCost' => 'float',
        'payments.*.chargesReceive' => 'float',
        'payments.*.chargesbillReceive' => 'float',
    ];

    public function mount()
    {
        $this->data = new Invoice;
        if($this->action==''){
            $this->action = 'view';
        }else{
            $this->action;
        }
        if($this->id!=''){
            $this->data = Invoice::find($this->id);
            $this->payments = $this->data->items;
        }else{
            $this->action = 'create';
            $this->data->createID = Auth::user()->usercode;
        }
    }

    public function addPayment() {
        $charge = Charges::find($this->chargeCode);
        $newCharge = new InvoiceItems;
        $newCharge->documentID = $this->data->documentID;
        $newCharge->chargeCode = $this->chargeCode;
        $newCharge->detail = $charge->chargeName;
        $this->payments->push($newCharge);
        $this->reset('chargeCode');
    }

    // public function removePayment(int $index) {
    //     $this->payments->forget($index);
    //     $this->payments = $this->payments->values();
    // }

    public function updatedPayments($value, $key) {
        // $this->data->total_vat = $this->payments->filter(function (InvoiceItems $item) {
        //     if($item->charge == null || $item->charge->chargesType == null) return false;
        //     return $item->charges->chargesType->amount == 7;
        // })->sum(function(InvoiceItems $payment) {
        //     return $payment->chargesReceive - $payment->chargesbillReceive;
        // });
        $this->data->total_vat = $this->payments->sum('chargesReceive') * 0.07;
        $this->data->total_amt = $this->data->total_vat + ($this->payments->sum('chargesReceive') + $this->payments->sum('chargesbillReceive'));
        $this->data->tax1 = $this->payments->filter(function (InvoiceItems $item) {
            if($item->charge == null || $item->charge->chargesType == null) return false;
            return $item->charges->chargesType->amount == 1;
        })->sum(function(InvoiceItems $payment) {
            return $payment->chargesReceive - $payment->chargesbillReceive;
        });
        $this->data->tax3 = $this->payments->filter(function (InvoiceItems $item) {
            if($item->charge == null || $item->charge->chargesType == null) return false;
            return $item->charges->chargesType->amount == 3;
        })->sum(function(InvoiceItems $payment) {
            return $payment->chargesReceive - $payment->chargesbillReceive;
        });
        $this->data->total_netamt = $this->data->total_amt - ($this->data->tax1 + $this->data->tax3);

    }

    public function save() {
        $this->data->editID = Auth::user()->usercode;
        $this->data->save();
        $this->data->items()->saveMany($this->payments);
        $this->redirectRoute(name: 'invoice', navigate: true);
    }
    
    public function render()
    {
        return view('livewire.page.account.invoice.form')->extends('layouts.main')->section('main-content');
    }
}
