<?php

namespace App\Livewire\Page\Shipping\PaymentVoucher;

use App\Models\Common\BankAccount;
use App\Models\Common\Supplier;
use App\Models\Marketing\JobOrder;
use App\Models\Payment\PaymentVoucher;
// use App\Models\Payment\ShipingPaymentVoucher;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\Attributes\Url;

class Form extends Component
{
    #[Url]
    public $action = '';
    #[Url]
    public $id = '';

    public ?PaymentVoucher $data = null;

    public Collection $payments;

    protected array $rules = [
        'payments.*' => 'unique:App\Models\Payment\PaymentVoucherItems',
        'payments.*.autoid' => 'integer',
        'payments.*.comCode' => 'string',
        'payments.*.documentID' => 'string',
        'payments.*.invNo' => 'string',
        'payments.*.chargeCode' => 'string',
        'payments.*.chartDetail' => 'string',
        'payments.*.amount' => 'float',
        'payments.*.tax' => 'integer',
        'payments.*.taxamount' => 'float',
        'payments.*.vat' => 'integer',
        'payments.*.vatamount' => 'float',
    ];

    #[Computed]
    public function calPrice() {
        $cal_price = [
            'total' => 0,
            'tax3' => 0,
            'tax1' => 0,
            'vatTotal' => 0,
            'grandTotal' => 0,
        ];
        if(!isset($this->payments)||$this->payments == null) {
            return (object) $cal_price;
        }
        $cal_charge['total'] = $this->payments->sum('amount');
        $cal_charge['tax3'] = $this->payments->filter(function ($item) {
            return $item->tax == 3;
        })->sum('taxamount');
        $cal_charge['tax1'] = $this->payments->filter(function ($item) {
            return $item->tax == 1;
        })->sum('taxamount');
        $cal_charge['vatTotal'] = $this->payments->filter(function ($item) {
            return $item->vat == 7;
        })->sum('vatamount');
        $cal_charge['grandTotal'] = ($cal_charge['total'] - ($cal_charge['tax1'] + $cal_charge['tax3'])) +  $cal_charge['vatTotal'];
        return (object) $cal_charge;
    }

    public function mount()
    {
        $this->data = new PaymentVoucher;
        if ($this->action == '') {
            $this->action = 'view';
        } else {
            $this->action;
        }

        if ($this->id != '') {
            $this->data = PaymentVoucher::find($this->id);
            if($this->data == null) {
                $this->data = new PaymentVoucher;
                $this->action = 'create';
                $this->id = '';
            }
            $this->payments = $this->data->items;
        } else {
            $this->action = 'create';
            $this->data->createID = Auth::user()->usercode;
        }
    }

    public function changeTax(int $value, int $index){
        $this->payments[$index]->taxamount = $this->payments->get($index)->amount * ($value / 100);
    }

    public function changeVat(int $value, int $index) {
        $this->payments[$index]->vatamount = $this->payments->get($index)->amount * ($value / 100);
    }

    public function save() {
        $this->data->editID = Auth::user()->usercode;
        $this->data->save();
        $this->data->items()->saveMany($this->payments);
        $this->redirectRoute(name: 'shipping-payment-voucher', navigate: true);
    }

    public function render()
    {
        return view('livewire.page.shipping.payment-voucher.form')->extends('layouts.main')->section('main-content');
    }
}
