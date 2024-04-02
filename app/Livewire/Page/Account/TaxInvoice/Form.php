<?php

namespace App\Livewire\Page\Account\TaxInvoice;

use App\Models\Account\TaxInvoice;
use App\Models\Account\TaxInvoiceItems;
use App\Models\Common\BankAccount;
use App\Models\Common\Charges;
use App\Models\Common\CreditTerm;
use App\Models\Common\Customer;
use App\Models\Common\Saleman;
use App\Models\Common\Supplier;
use App\Models\Common\TransportType;
use App\Models\Marketing\JobOrder;
use Auth;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\Attributes\Url;

class Form extends Component
{
    #[Url]
    public string $action = '';
    #[Url]
    public string $id = '';

    public string $chargeCode = '';

    public ?TaxInvoice $data;

    public Collection $payments;

    protected array $rules = [
        'payments.*' => 'unique:App\Models\Account\TaxInvoiceItems',
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
        if($this->action==''){
            $this->action = 'view';
        }else{
            $this->action;
        }
        if($this->id!=''){
            $this->data = TaxInvoice::find($this->id);
            $this->payments = $this->data->items;
        }else{
            $this->action = 'create';
            $this->data = new TaxInvoice;
            $this->data->createID = Auth::user()->usercode;
            $this->payments = new Collection;
        }
    }

    public function addPayment() {
        $charge = Charges::find($this->chargeCode);
        $newCharge = new TaxInvoiceItems;
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
        $this->data->tax1 = $this->payments->filter(function (TaxInvoiceItems $item) {
            if($item->charge == null || $item->charge->chargesType == null) return false;
            return $item->charges->chargesType->amount == 1;
        })->sum(function(TaxInvoiceItems $payment) {
            return $payment->chargesReceive - $payment->chargesbillReceive;
        });
        $this->data->tax3 = $this->payments->filter(function (TaxInvoiceItems $item) {
            if($item->charge == null || $item->charge->chargesType == null) return false;
            return $item->charges->chargesType->amount == 3;
        })->sum(function(TaxInvoiceItems $payment) {
            return $payment->chargesReceive - $payment->chargesbillReceive;
        });
        $this->data->total_netamt = $this->data->total_amt - ($this->data->tax1 + $this->data->tax3);

    }

    public function save() {
        $this->data->editID = Auth::user()->usercode;
        $this->data->save();
        $this->data->items->filter(function($item){
            return !collect($this->payments->pluck('items'))->contains($item->items);
        })->each->delete();
        $this->data->items()->saveMany($this->payments);
        $this->redirectRoute(name: 'tax-invoice', navigate: true);
    }

    public function render()
    {
        return view('livewire.page.account.tax-invoice.form')->extends('layouts.main')->section('main-content');
    }
}
