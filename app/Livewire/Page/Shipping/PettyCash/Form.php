<?php

namespace App\Livewire\Page\Shipping\PettyCash;

use App\Models\Common\Charges;
use App\Models\Common\Supplier;
use App\Models\Marketing\JobOrder;
use App\Models\PettyCash\PettyCashShipping;
use App\Models\PettyCash\PettyCashShippingItems;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Carbon\Carbon;

class Form extends Component
{

    #[Url]
    public $action = '';
    #[Url]
    public $id = '';

    public string $chargeCode = '';

    public ?PettyCashShipping $data = null;

    public Collection $payments;

    protected array $rules = [
        'payments.*' => 'unique:App\Models\PettyCash\PettyCashShippingItems',
        'payments.*.autoid' => 'integer',
        'payments.*.comCode' => 'string',
        'payments.*.documentID' => 'string',
        'payments.*.invNo' => 'string',
        'payments.*.chargeCode' => 'string',
        'payments.*.chartDetail' => 'string',
        'payments.*.amount' => 'float'
    ];

    #[Computed]
    public function calPrice() {
        $cal_price = [
            'total' => 0,
            'tax3' => 0,
            'tax1' => 0,
            'tax7' => 0,
            'grandTotal' => 0,
        ];
        if(!isset($this->payments)||$this->payments == null) {
            return (object) $cal_price;
        }
        $cal_charge['total'] = $this->payments->sum('amount');
        $cal_charge['tax3'] = $this->payments->filter(function ($item) {
            if($item->charge == null || $item->charge->chargesType == null) return false;
            return $item->charges->chargesType->amount == 3;
        })->sum('amount');
        $cal_charge['tax1'] = $this->payments->filter(function ($item) {
            if($item->charge == null || $item->charge->chargesType == null) return false;
            return $item->charges->chargesType->amount == 1;
        })->sum('amount');
        $cal_charge['tax7'] = $this->payments->sum('amount') * 0.07;
        $cal_charge['grandTotal'] = ($cal_charge['total'] - ($cal_charge['tax1'] + $cal_charge['tax3'])) +  $cal_charge['tax7'];
        return (object) $cal_charge;
    }

    public function mount()
    {
        $this->data = new PettyCashShipping();
        if ($this->action == '') {
            $this->action = 'view';
        } else {
            $this->action;
        }

        if ($this->id != '') {
            $this->data = PettyCashShipping::find($this->id);
            $this->payments = $this->data->items;
        } else {
            $this->action = 'create';
            $this->data->createID = Auth::user()->usercode;
            $this->data->dueDate = Carbon::now()->endOfMonth()->toDateString();
            $this->payments = new Collection;
        }
    }

    public function addPayment() {
        $charge = Charges::find($this->chargeCode);
        $newCharge = new PettyCashShippingItems;
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
        $this->data->items->filter(function($item){
            return !collect($this->payments->pluck('autoid'))->contains($item->autoid);
        })->each->delete();
        $this->data->items()->saveMany($this->payments);
        $this->redirectRoute(name: 'shipping-petty-cash', navigate: true);
    }

    public function render()
    {
        return view('livewire.page.shipping.petty-cash.form')->extends('layouts.main')->section('main-content');
    }
}
