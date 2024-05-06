<?php

namespace App\Livewire\Page\Account\PaymentVoucher;

use App\Models\AttachFile;
use App\Models\Common\BankAccount;
use App\Models\Common\Charges;
use App\Models\Common\Supplier;
use App\Models\Marketing\JobOrder;
use App\Models\Payment\PaymentVoucher;
use App\Models\Payment\PaymentVoucherAttach;
use App\Models\Payment\PaymentVoucherItems;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;

    #[Url]
    public $action = '';
    #[Url]
    public $id = '';

    public ?PaymentVoucher $data = null;

    public string $chargeCode = '';

    public Collection $payments;

    public Collection $attachs;

    public $file;

    protected array $rules = [
        'file' => 'nullable|mimes:png,jpg,jpeg,pdf|max:102400',
        'data.dueDate' => 'required|date',
        'data.supCode' => 'required|string',
        'payments.*' => 'unique:App\Models\Payment\PaymentVoucherItems',
        'payments.*.autoid' => 'integer',
        'payments.*.comCode' => 'string',
        'payments.*.documentID' => 'string',
        'payments.*.invNo' => 'string',
        'payments.*.chargeCode' => 'string',
        'payments.*.chartDetail' => 'string',
        'payments.*.amount' => 'regex:/^\d*(\.\d{2})?$/',
        'payments.*.tax' => 'integer',
        'payments.*.taxamount' => 'regex:/^\d*(\.\d{2})?$/',
        'payments.*.vat' => 'integer',
        'payments.*.vatamount' => 'regex:/^\d*(\.\d{2})?$/',
        'attachs.*' => 'unique:App\Models\Payment\PaymentVoucherAttach',
        'attachs.*.items' => 'integer',
        'attachs.*.comCode' => 'string',
        'attachs.*.documentID' => 'string',
        'attachs.*.supCode' => 'string',
        'attachs.*.fileDetail' => 'string',
        'attachs.*.fileName' => 'string',
    ];

    // public function rules() {
    //     return [
    //     'data.dueDate' => 'required|date',
    //     'data.supCode' => 'required|string'
    //     ];
    // }

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
            $this->attachs = $this->data->attachs;
        } else {
            $this->action = 'create';
            $this->data->createID = Auth::user()->usercode;
            $this->payments = new Collection;
            $this->attachs = new Collection;
        }
    }

    public function addPayment() {
        $newPayment = new PaymentVoucherItems;
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

    public function changeTax(int $value, int $index){
        $this->payments[$index]->taxamount = round($this->payments->get($index)->amount * ($value / 100), 2);
    }

    public function changeVat(int $value, int $index) {
        $this->payments[$index]->vatamount = round($this->payments->get($index)->amount * ($value / 100), 2);
    }

    public function removePreFile() {
        $this->reset('file');
    }

    public function uploadFile() {
        // dd($this->file->extension());
        if($this->data->supCode == null|| $this->data->supCode == '') {
            $this->addError('supCodeEmpty', 'Please select supplier');
            return;
        }
        $date = Carbon::now();
        $new_attach = new PaymentVoucherAttach;
        $new_file = new AttachFile;
        $new_attach->documentID = $this->data->documentID;
        $new_attach->supCode = $this->data->supCode ?? '';
        $new_file->mimetype = $this->file->getMimeType();
        $new_file->blobfile = file_get_contents($this->file->getRealPath());
        $filename = $new_attach->supCode.'-'.$date->format('ymd').$date->timestamp.'.'.$this->file->extension();
        $new_file->filename = $filename;
        $new_attach->fileName = $filename;
        $new_attach->save();
        $new_file->save();
        $this->attachs->push($new_attach->refresh());
        $this->reset('file');
    }

    public function removeFile(int $index) {
        $removeFile = $this->attachs->get($index);
        $removeFile->delete();
        $this->attachs->forget($index);
        $this->attachs = $this->attachs->values();
    }

    public function save(bool|null $approve = false) {
        $this->data->editID = Auth::user()->usercode;
        if($approve) {
            $this->data->documentstatus = 'A';
        }
        $this->data->save();
        $this->data->items->filter(function($item){
            return !collect($this->payments->pluck('autoid'))->contains($item->autoid);
        })->each->delete();
        $this->data->items()->saveMany($this->payments);
        $this->data->attachs->filter(function($item){
            return !collect($this->attachs->pluck('items'))->contains($item->items);
        })->each->delete();
        $this->data->attachs()->saveMany($this->attachs);
    }

    public function valid() {
        $vaidate = true;
        if($this->data->dueDate == null || $this->data->dueDate == '') {
            $this->addError('data.dueDate', 'Please select due date');
            $vaidate = false;
        }
        if($this->data->supCode == null || $this->data->supCode == '') {
            $this->addError('data.supCode', 'Please select supplier');
            $vaidate = false;
        }
        return $vaidate;
    }

    public function submit(){
        if(!$this->valid()) {
            return;
        }
        $this->save();
        $this->redirectRoute(name: 'account-payment-voucher', navigate: true);
    }

    public function approve() {
        $this->validate();
        $this->save(true);
        $this->redirectRoute(name: 'shipping-payment-voucher', navigate: true);
    }

    #[Title('payment voucher')] 
    public function render()
    {
        return view('livewire.page.account.payment-voucher.form')->extends('layouts.main')->section('main-content');
    }
}
