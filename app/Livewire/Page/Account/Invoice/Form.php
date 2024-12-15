<?php

namespace App\Livewire\Page\Account\Invoice;

use App\Enum\FormMode;
use App\Enum\ViewMode;
use App\Models\Account\Invoice;
use App\Models\Account\InvoiceItems;
use App\Models\Common\Charges;
use App\Models\Marketing\JobOrder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Url;

class Form extends Component
{
    #[Url]
    public $action = "";
    #[Url]
    public $id = '';

    public ViewMode $mode;
    public FormMode $formMode;

    public string $chargeCode = '';
    public ?Invoice $data = null;

    public Collection $payments;

    #[Url]
    public $ref = '';

    private ?JobOrder $job_order;


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
            $this->payments = new Collection;
            if($this->ref != ''){
                $this->job_order = JobOrder::find($this->ref);
                $this->data->ref_jobID = $this->job_order->documentID;
                $this->data->cusCode = $this->job_order->cusCode;
                $this->data->saleman = $this->job_order->saleman;
                $this->data->carrier = $this->job_order->agentCode;
                $this->data->bound = $this->job_order->bound;
                $this->data->freight = $this->job_order->freight;
            }
        }
        // $this->mode = ViewMode::from($this->action);
        // $this->formMode = $this->mode->toFormMode();
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

    protected function save(bool|null $approve = false) {
        $this->data->editID = Auth::user()->usercode;
        $this->data->editTime = Carbon::now();
        if($approve){
            $this->data->documentStatus = 'A';
        }
        $this->data->save();
        // $this->data->items->filter(function(InvoiceItems $item){
        //     return !collect($this->payments->pluck('items'))->contains($item->items);
        // })->each->delete();
        // $this->data->items()->saveMany($this->payments);
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
        $this->redirectRoute(name: 'invoice', navigate: true);
    }
    
    public function render()
    {
        return view('livewire.page.account.invoice.form')->extends('layouts.main')->section('main-content');
    }
}
