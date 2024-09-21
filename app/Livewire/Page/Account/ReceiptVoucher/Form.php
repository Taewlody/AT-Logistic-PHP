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
use Illuminate\Support\Facades\DB;

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
            $this->data->documentDate = Carbon::now()->toDateString();
            $this->data->createID = Auth::user()->usercode;
            $this->payments = new Collection;
            $this->attachs = new Collection;
        }
    }

    #[On('Add-Charge')]
    public function addCharge() {
        $newPayment = new ReceiptVoucherItems;
        $charge = Charges::find($this->chargeCode);
        $newPayment->documentID = $this->data->documentID;
        $newPayment->chargeCode = $this->chargeCode;
        $newPayment->chartDetail = $charge != null ? $charge->chargeName : '';
        $newPayment->taxamount = 0;
        $newPayment->vatamount = 0;
        $this->payments->push($newPayment);
        $this->reset('chargeCode');
        $this->dispatch('reset-select2-chargeCode');
        $this->dispatch('update-charges');
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

    public function save(bool|null $approve = false) 
    {
        if(!$this->valid()) {
            return false;
        }
        DB::beginTransaction();
        try {
            $this->data->editID = Auth::user()->usercode;
            if($approve) {
                $this->data->documentstatus = 'A';
            }
            $this->data->save();
            // $this->data->items()->delete();
            $this->data->items->filter(function($item){
                return !collect($this->payments->pluck('autoid'))->contains($item->autoid);
            })->each->delete();
            $this->data->items()->saveMany($this->payments);
            
            \DB::commit();
            return true;

        } catch (\Exception $exception) {
            \DB::rollBack();
            dd($exception->getMessage());
            return false;
        }
    }

    public function valid() {
        $vaidate = true;
        if($this->data->dueDate == null || $this->data->dueDate == '') {
            $this->addError('data.dueDate', 'Please select due date');
            $vaidate = false;
        }else {
            $this->resetErrorBag('data.dueDate');
        }

        if($this->data->cusCode == null || $this->data->cusCode == '') {
            $this->addError('data.cusCode', 'Please select customer');
            $vaidate = false;
        }else {
            $this->resetErrorBag('data.cusCode');
        }

        if($this->data->accountCode == null && $this->data->accountCode !== " ") {
            $this->addError('data.accountCode', 'Please select account');
            $vaidate = false;
        }else {
            $this->resetErrorBag('data.accountCode');
        }

        if($this->data->payType == null || $this->data->payType == '') {
            $this->addError('data.payType', 'Please select pay type');
            $vaidate = false;
        }else {
            $this->resetErrorBag('data.payType');
        }

        return $vaidate;
    }

    public function submit(){
        $success = $this->save();
        if($success){
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Success', message: 'บันทึกข้อมูลสำเร็จ', type: 'success');
            return redirect()->route('receipt-voucher.form', ['action' => 'edit', 'id' => $this->data->documentID]);
        }else{
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Error', message: 'บันทึกข้อมูลไม่สำเร็จ', type: 'error');
        }
    }
    
    public function approve(){
        $success = $this->save(true);
        if($success){
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Success', message: 'บันทึกข้อมูลสำเร็จ', type: 'success');
            return redirect()->route('receipt-voucher.form', ['action' => 'edit', 'id' => $this->data->documentID]);
        }else{
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Error', message: 'บันทึกข้อมูลไม่สำเร็จ', type: 'error');
        }
    }


    public function render()
    {
        return view('livewire.page.account.receipt-voucher.form')->extends('layouts.main')->section('main-content');
    }
}
