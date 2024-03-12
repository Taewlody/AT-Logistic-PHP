<?php

namespace App\Livewire\Page\Account\ReceiptVoucher;

use App\Models\Account\ReceiptVoucher;
use App\Models\Account\ReceiptVoucherAttach;
use App\Models\Account\ReceiptVoucherItems;
use App\Models\AttachFile;
use App\Models\Common\Charges;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
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

    public ?ReceiptVoucher $data = null;

    public string $chargeCode = '';

    public Collection $payments;

    public Collection $attachs;

    public $file;

    protected array $rules = [
        'file' => 'mimes:png,jpg,jpeg,pdf|max:102400',
        'payments.*' => 'unique:App\Models\Account\ReceiptVoucherItems',
        'payments.*.autoid' => 'integer',
        'payments.*.comCode' => 'string',
        'payments.*.documentID' => 'string',
        'payments.*.invNo' => 'string',
        'payments.*.chargeCode' => 'string',
        'payments.*.chartDetail' => 'string',
        'payments.*.amount' => 'float',
        'attachs.*.items' => 'integer',
        'attachs.*.comCode' => 'string',
        'attachs.*.documentID' => 'string',
        'attachs.*.cusCode' => 'string',
        'attachs.*.fileDetail' => 'string',
        'attachs.*.fileName' => 'string',
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
            $this->attachs = $this->data->attachs;
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

    public function removePreFile() {
        $this->reset('file');
    }

    public function uploadFile() {
        // dd($this->file->extension());
        if($this->data->cusCode == null|| $this->data->cusCode == '') {
            $this->addError('cusCodeEmpty', 'Please select supplier');
            return;
        }
        $date = Carbon::now();
        $new_attach = new ReceiptVoucherAttach;
        $new_file = new AttachFile;
        $new_attach->documentID = $this->data->documentID;
        $new_attach->cusCode = $this->data->cusCode ?? '';
        $new_file->mimetype = $this->file->getMimeType();
        $new_file->blobfile = file_get_contents($this->file->getRealPath());
        $filename = $new_attach->cusCode.'-'.$date->format('ymd').$date->timestamp.'.'.$this->file->extension();
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
