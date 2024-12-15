<?php

namespace App\Livewire\Page\Account\PaymentVoucher;

use App\Functions\Service;
use App\Enum\FormMode;
use App\Enum\ViewMode;
use App\Models\AttachFile;
use App\Models\Common\BankAccount;
use App\Models\Common\Charges;
use App\Models\Common\Supplier;
use App\Models\Marketing\JobOrder;
use App\Models\Marketing\JobOrderCharge;
use App\Models\Payment\PaymentVoucher;
use App\Models\Payment\PaymentVoucherAttach;
use App\Models\Payment\PaymentVoucherItems;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
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

    public ViewMode $viewMode;

    public FormMode $formMode;
    public $priceSum;

    public $purchasevat = false;

    public $jobOrderSelecter;

    protected array $rules = [
        'file' => 'nullable|mimes:png,jpg,jpeg,pdf|max:102400',
        'data.dueDate' => 'required|date',
        'data.supCode' => 'required|string',
        'data.accountCode' => 'required|string',
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

    public function calTax1($value) {
        
        $this->calPrice(tax1: $value ? $value : 0, tax3: $this->priceSum->tax3 ? $this->priceSum->tax3 : 0);
        $this->dispatch('refresh');
        
    }

    public function calTax3($value) {
        $this->calPrice(tax1: $this->priceSum->tax1 ? $this->priceSum->tax1 : 0, tax3: $value ? $value : 0);
        $this->dispatch('refresh');
    }

    // #[Computed]
    public function calPrice(float|null $tax1 = null, float|null $tax3 = null) {
        
        $cal_price = (object) [
            'total' => 0,
            'tax3' => 0,
            'tax1' => 0,
            'vatTotal' => 0,
            'grandTotal' => 0,
        ];
        if(!isset($this->payments)||$this->payments == null) {
            // return $cal_price;
            $this->priceSum = $cal_price;
        }
        $cal_price->total = $this->payments->sum('amount');
        if($tax3 != null) {
            // dd($tax3);
            $cal_price->tax3 = $tax3;
        } else {
            $cal_price->tax3 = $this->payments->filter(function ($item) {
                return $item->tax == 3;
            })->sum('taxamount');
        }
        if($tax1 != null) {
            // dd($tax1);
            $cal_price->tax1 = $tax1;
        } else {
            $cal_price->tax1 = $this->payments->filter(function ($item) {
                return $item->tax == 1;
            })->sum('taxamount');
        }
        $cal_price->vatTotal = $this->payments->filter(function ($item) {
            return $item->vat == 7;
        })->sum('vatamount');
        $cal_price->grandTotal = ($cal_price->total - ($cal_price->tax1 + $cal_price->tax3)) + $cal_price->vatTotal;
        // return $cal_price;
        
        $this->priceSum = $cal_price;
        $this->dispatch('cal-update');
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
            $this->purchasevat = $this->data->purchasevat == 1 ? true : false;
            // dd($this->data);
            $this->calPrice(tax1: $this->data->sumTax1 ? $this->data->sumTax1 : 0, tax3: $this->data->sumTax3 ? $this->data->sumTax3 : 0);
        } else {
            $this->action = 'create';
            $this->data->documentDate = Carbon::now()->toDateString();
            $this->data->createID = Auth::user()->usercode;
            $this->payments = new Collection;
            $this->attachs = new Collection;
            $this->calPrice();
        }

        $this->viewMode = ViewMode::from($this->action);
        $this->formMode = $this->viewMode->toFormMode();

        if($this->data->documentstatus == 'A' && !Auth::user()->hasRole('admin') && $this->viewMode == ViewMode::EDIT) {
            $this->formMode = FormMode::from('disabled');
        } 
        // $this->calPrice();
        // dd($this->data);
        $this->jobOrderSelecter = Service::JobOrderSelecter();
    }

    #[On("updated-refJobNo")]
    public function updateRefJob(){
        $selectedJob = JobOrder::find($this->data->refJobNo);
        if($selectedJob->invoice != null) {
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Warning', message: 'job นี้ได้มีการออก invoice แล้ว', type: 'warning');
        }
    }

    #[On('Add-Charge')]
    public function addCharge() {
        $newPayment = new PaymentVoucherItems;
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

    public function changeTax(int $value, int $index){
        $this->payments[$index]->taxamount = round($this->payments->get($index)->amount * ($value / 100), 2);
        $this->payments[$index]->GrandTotal = $this->payments[$index]->amount + ($this->payments[$index]->vatamount - $this->payments[$index]->taxamount);
        $this->calPrice();
    }

    public function changeVat(int $value, int $index) {
        $this->payments[$index]->vatamount = round($this->payments->get($index)->amount * ($value / 100), 2);
        $this->payments[$index]->GrandTotal = $this->payments[$index]->amount + ($this->payments[$index]->vatamount - $this->payments[$index]->taxamount);

        $this->calPrice();
    }
    
    public function changeGrandTotal(int $index) {
        if($this->payments->get($index)->tax == 1) {
            $this->priceSum->tax1 = round($this->payments->get($index)->amount * (0.01), 2);
            $this->payments[$index]->taxamount = round($this->payments->get($index)->amount * (0.01), 2);
        }else if ($this->payments->get($index)->tax == 3) {
            $this->priceSum->tax3 = round($this->payments->get($index)->amount * (0.03), 2);
            $this->payments[$index]->taxamount = round($this->payments->get($index)->amount * (0.03), 2);
        }
        

        $this->payments[$index]->GrandTotal = $this->payments[$index]->amount + ($this->payments[$index]->vatamount - $this->payments[$index]->taxamount);
        
        $this->calPrice(tax1: $this->priceSum->tax1 ? $this->priceSum->tax1 : 0, tax3: $this->priceSum->tax3 ? $this->priceSum->tax3 : 0);
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
        if(!$this->valid()) {
            return false;
        }
        $this->data->editID = Auth::user()->usercode;
        $this->data->editTime = Carbon::now();
        if($approve) {
            $this->data->documentstatus = 'A';
        }
        $this->data->sumTotal = $this->priceSum->total;
        $this->data->sumTax3 = $this->priceSum->tax3;
        $this->data->sumTax1 = $this->priceSum->tax1;
        $this->data->sumTax7 = $this->priceSum->vatTotal;
        $this->data->grandTotal = $this->priceSum->grandTotal;
        // dd($this->purchasevat);
        $this->data->save();
        $this->data->update(['purchasevat' => $this->purchasevat ? 1 : 0]);
        $this->data->items->filter(function($item){
            return !collect($this->payments->pluck('autoid'))->contains($item->autoid);
        })->each->delete();
        $this->data->items()->saveMany($this->payments);
        $this->data->attachs->filter(function($item){
            return !collect($this->attachs->pluck('items'))->contains($item->items);
        })->each->delete();
        $this->data->attachs()->saveMany($this->attachs);
        return true;
    }

    public function valid() {
        $vaidate = true;
        if($this->data->dueDate == null || $this->data->dueDate == '') {
            $this->addError('data.dueDate', 'Please select due date');
            $vaidate = false;
        }else {
            $this->resetErrorBag('data.dueDate');
        }

        if($this->data->supCode == null || $this->data->supCode == '') {
            $this->addError('data.supCode', 'Please select supplier');
            $vaidate = false;
        }else {
            $this->resetErrorBag('data.supCode');
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

        // if($this->data->refJobNo == null || $this->data->refJobNo == '') {
        //     $this->addError('data.refJobNo', 'Please select Ref. JobNo.');
        //     $vaidate = false;
        // }else {
        //     $this->resetErrorBag('data.refJobNo');
        // }

        return $vaidate;
    }

    public function submit(){
        // $this->save();
        // $this->redirectRoute(name: 'account-payment-voucher', navigate: true);
        $success = $this->save();
        if($success){
            // $this->redirectRoute(name: 'job-order', navigate: true);\
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Success', message: 'บันทึกข้อมูลสำเร็จ', type: 'success');
            return redirect()->route('account-payment-voucher.form', ['action' => 'edit', 'id' => $this->data->documentID]);
        }else{
            // $this->dispatch('vaildated');
            $this->dispatch('vaildated');
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Error', message: 'บันทึกข้อมูลไม่สำเร็จ', type: 'error');
            // $this->resetErrorBag();
        }
    }

    public function approve() {
        
        $success = $this->save(true);
        if($success) {
            if($this->data->refJobNo) {
                $this->job = JobOrderCharge::where('ref_paymentCode',$this->data->documentID);
                
                $this->job->delete();
            
                $this->payments->each(function($item){
                    $this->job->create([
                        'documentID' => $this->data->refJobNo,
                        'ref_paymentCode' => $this->data->documentID,
                        'chargeCode' => $item->chargeCode,
                        'detail' => $item->chartDetail,
                        'chargesCost' => $item->amount
                    ]);
                });
                
            }
            
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Success', message: 'บันทึกข้อมูลสำเร็จ', type: 'success');
            return redirect()->route('account-payment-voucher.form', ['action' => 'edit', 'id' => $this->data->documentID]);
        }else {
            $this->dispatch('vaildated');
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Error', message: 'บันทึกข้อมูลไม่สำเร็จ', type: 'error');
        }
    }

    public function update() {
        
        $success = $this->save(true);
        if($success) {
            if($this->data->refJobNo) {
                $this->job = JobOrderCharge::where('ref_paymentCode',$this->data->documentID);
                
                $this->job->delete();
            
                $this->payments->each(function($item){
                    $this->job->create([
                        'documentID' => $this->data->refJobNo,
                        'ref_paymentCode' => $this->data->documentID,
                        'chargeCode' => $item->chargeCode,
                        'detail' => $item->chartDetail,
                        'chargesCost' => $item->amount
                    ]);
                });
                
            }
            
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Success', message: 'บันทึกข้อมูลสำเร็จ', type: 'success');
            return redirect()->route('account-payment-voucher.form', ['action' => 'edit', 'id' => $this->data->documentID]);
        }else {
            $this->dispatch('vaildated');
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Error', message: 'บันทึกข้อมูลไม่สำเร็จ', type: 'error');
        }
    }

    #[Title('payment voucher')] 
    public function render()
    {
        return view('livewire.page.account.payment-voucher.form')->extends('layouts.main')->section('main-content');
    }
}
