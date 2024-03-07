<?php

namespace App\Livewire\Page\Account\ReceiptVoucher;

use App\Models\Account\ReceiptVoucher;
use App\Models\Account\ReceiptVoucherItems;
use App\Models\Common\BankAccount;
use App\Models\Common\Charges;
use App\Models\Common\Customer;
use App\Models\Common\Supplier;
use App\Models\Marketing\JobOrder;
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

    public ?ReceiptVoucher $data = null;

    public string $chargeCode = '';

    public Collection $payments;

    protected array $rules = [
        'payments.*' => 'unique:App\Models\Account\ReceiptVoucherItems',
        'payments.*.autoid' => 'integer',
        'payments.*.comCode' => 'string',
        'payments.*.documentID' => 'string',
        'payments.*.invNo' => 'string',
        'payments.*.chargeCode' => 'string',
        'payments.*.chartDetail' => 'string',
        'payments.*.amount' => 'float',
    ];

    public function mount()
    {
        $this->data = new ReceiptVoucher();
        if ($this->action == '') {
            $this->action = 'view';
        } else {
            $this->action;
        }

        if ($this->id != '') {
            $this->data = ReceiptVoucher::find($this->id);
            $this->payments = $this->data->items;
        } else {
            $this->action = 'create';
            $this->data->createID = Auth::user()->usercode;
        }
    }

    public function addPayment() {
        $newPayment = new ReceiptVoucherItems;
        $charge = Charges::find($this->chargeCode);
        $newPayment->documentID = $this->data->documentID;
        $newPayment->chargeCode = $this->chargeCode;
        $newPayment->chartDetail = $charge != null ? $charge->chargeName : '';
        $newPayment->taxamount = 0;
        $newPayment->vatamount = 0;
        $this->payments->push($newPayment);
        $this->reset('chargeCode');
    }

    public function removePayment(int $index) {
        $this->payments->forget($index);
        $this->payments = $this->payments->values();
    }

    // public function changeTax(int $value, int $index){
    //     $this->payments[$index]->taxamount = round($this->payments->get($index)->amount * ($value / 100), 2);
    // }

    // public function changeVat(int $value, int $index) {
    //     $this->payments[$index]->vatamount = round($this->payments->get($index)->amount * ($value / 100), 2);
    // }

    public function updatedPayments($value, $index) {
        $this->data->sumTotal = $this->payments->sum('amount');
        $this->data->grandTotal = $this->data->sumTotal - ($this->data->sumTax1 + $this->data->sumTax3) + $this->data->sumTax7;
    }

   public function updated($field, $value) {
        if ($field == 'data.sumTax1'||$field == 'data.sumTax3'||$field == 'data.sumTax7') {
            $this->data->grandTotal = $this->data->sumTotal - ($this->data->sumTax1 + $this->data->sumTax3) + $this->data->sumTax7;
        }
    }

    // public function updatedDataSumTax1($value) {
    //     dd($value);
    // }

    public function save() {
        $this->data->editID = Auth::user()->usercode;
        $this->data->save();
        // $this->data->items()->delete();
        $this->data->items()->saveMany($this->payments);
        $this->redirectRoute(name: 'receipt-voucher', navigate: true);
    }


    public function render()
    {
        return view('livewire.page.account.receipt-voucher.form')->extends('layouts.main')->section('main-content');
    }
}
