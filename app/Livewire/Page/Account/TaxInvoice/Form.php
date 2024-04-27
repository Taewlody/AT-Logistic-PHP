<?php

namespace App\Livewire\Page\Account\TaxInvoice;

use App\Models\Account\Invoice;
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

    public Collection $invoice;

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
            // $this->payments = new Collection;
            // $this->payments = $this->getInvoiceItem();
            // dd($this->payments);
            $this->getInvoiceItem();
            // dd($this->payments);
        }
    }


    public function getInvoiceItem(){
        $this->invoice = Invoice::where([['documentStatus', 'A'], ['taxivRef', null]])->get();
        $this->payments = new Collection;
        foreach($this->invoice as $inv){
            $inv->items()->each(function($inv_item) use ($inv){
                $newItem = new TaxInvoiceItems([
                    'invNo' => $inv->documentID,
                    'chargeCode' => $inv_item->chargeCode,
                    'detail' => $inv_item->detail,
                    'chargesCost' => $inv_item->chargesCost,
                    'chargesReceive' => $inv_item->chargesReceive,
                    'chargesbillReceive' => $inv_item->chargesReceive,
                ]);
                $this->payments->push($newItem);
            });
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

    public function save(bool|null $approve = false) {
        $this->data->editID = Auth::user()->usercode;
        if($approve){
            $this->data->documentStatus = 'A';
        }
        $this->data->save();
        $this->data->items->filter(function($item){
            return !collect($this->payments->pluck('items'))->contains($item->items);
        })->each->delete();
        $this->data->items()->saveMany($this->payments);
        $this->invoice->each->update(['taxivRef' => $this->data->documentID]);
    }

    public function submit(){
        $this->save();
        $this->backRoute();
    }

    public function approve()
    {
        $this->save(true);
        $this->backRoute();
    }

    public function backRoute(){
        $this->redirectRoute(name: 'tax-invoice', navigate: true);
    }

    public function render()
    {
        return view('livewire.page.account.tax-invoice.form')->extends('layouts.main')->section('main-content');
    }
}
