<?php

namespace App\Livewire\Page\Customer\AdvancePayment;

use App\Enum\FormMode;
use App\Enum\ViewMode;
use App\Models\AttachFile;
use App\Models\Common\Charges;
use App\Models\Marketing\JobOrder;
use App\Models\Payment\AdvancePayment;
use App\Models\Payment\AdvancePaymentAttach;
use App\Models\Payment\AdvancePaymentItems;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Form extends Component
{

    use WithFileUploads;
    
    #[Url]
    public $action = '';
    #[Url]
    public $id = '';

    public ?AdvancePayment $data = null;

    public Collection $payments;

    public Collection $attachs;

    public $chargeCode = 'C-032';

    public $file;

    public ViewMode $viewMode;

    public FormMode $formMode;

    protected array $rules = [
        'file' => 'mimes:png,jpg,jpeg,pdf|max:102400',
        'payments.*' => 'unique:App\Models\Payment\AdvancePaymentItems',
        'payments.*.autoid' => 'integer',
        'payments.*.comCode' => 'string',
        'payments.*.documentID' => 'string',
        'payments.*.invNo' => 'string',
        'payments.*.chargeCode' => 'string',
        'payments.*.chartDetail' => 'string',
        'payments.*.amount' => 'float',
        'attachs.*'=> 'unique:App\Models\Payment\AdvancePaymentAttach',
        'attachs.*.items' => 'integer',
        'attachs.*.comCode' => 'string',
        'attachs.*.documentID' => 'string',
        'attachs.*.cusCode' => 'string',
        'attachs.*.fileDetail' => 'string',
        'attachs.*.fileName' => 'string',
    ];

    public function mount() {
        $this->data = new AdvancePayment();
        if ($this->action == '') {
            $this->action = 'view';
        }
        $this->data = AdvancePayment::findOrNew($this->id);
        if(!$this->data->exists) {
            $this->id = '';
            $this->action = 'create';
            $this->data->createID = Auth::user()->usercode;
        } 
        $this->payments = $this->data->items;
        $this->attachs = $this->data->attachs;
        $this->data->documentDate = Carbon::now()->toDateString();
        $this->data->dueDate = Carbon::now()->toDateString();
        $this->data->dueTime = Carbon::now()->timezone('Asia/Bangkok')->format('H:i');
        
        $this->viewMode = ViewMode::from($this->action);
        $this->formMode = $this->viewMode->toFormMode();

        if($this->data->documentstatus == 'A' && !Auth::user()->hasRole('admin') && $this->viewMode == ViewMode::EDIT) {
            $this->formMode = FormMode::from('disabled');
        } 
    }

    #[On("updated-refJobNo")]
    public function updateRefJob(){
        $selectedJob = JobOrder::find($this->data->refJobNo);
        $this->dispatch("change-select2-cusCode", data: $selectedJob->cusCode);
    }

    public function addCharge(){
        $charges = Charges::find($this->chargeCode);
        $newCharge = new AdvancePaymentItems;
        $newCharge->documentID = $this->data->documentID;
        $newCharge->chargeCode = $this->chargeCode;
        $newCharge->chartDetail = $charges->chargeName;
        $this->payments->push($newCharge);
        $this->reset('chargeCode');
    }

    public function removeCharge(int $index){
        $this->payments->forget($index);
        $this->payments = $this->payments->values();
    }

    public function removePreFile() {
        $this->reset('file');
        $this->file = null;
    }

    public function uploadFile() {
        // dd($this->file->extension());
        if($this->data->cusCode == null|| $this->data->cusCode == '') {
            $this->addError('cusCodeEmpty', 'Please select customer');
            return;
        }
        $date = Carbon::now();
        $new_attach = new AdvancePaymentAttach;
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

    public function save(bool|null $approve = false) {
        if(!$this->valid()) {
            return false;
        }
        if($approve) {
            $this->data->documentstatus = 'A';
        }
        $this->data->sumTotal = $this->payments->sum('amount');
        $this->data->editID = Auth::user()->usercode;
        $this->data->save();
        $this->data->items->filter(function($item){
            return !collect($this->payments->pluck('autoid'))->contains($item->autoid);
        })->each->delete();
        $this->data->items()->saveMany($this->payments);
        $this->data->attachs()->saveMany($this->attachs);
        return true;
        // $this->redirectRoute(name: 'advance-payment', navigate: true);
    }

    public function valid() {
        $vaidate = true;
        if($this->data->cusCode == null || $this->data->cusCode == '') {
            $this->addError('cusCode', 'Please select customer');
            $vaidate = false;
        }
        if($this->data->refJobNo == null || $this->data->refJobNo == '') {
            $this->addError('refJobNo', 'Please select Ref. JobNo.');
            $vaidate = false;
        }
        if($this->data->accountCode == null || $this->data->accountCode == '') {
            $this->addError('accountCode', 'Please select account');
            $vaidate = false;
        }
        if($this->data->payType == null || $this->data->payType == '') {
            $this->addError('payType', 'Please select pay type');
            $vaidate = false;
        }
        if($this->data->payType === 'b'){
            if($this->data->branch == null || $this->data->branch == '') {
                $this->addError('branch', 'Please select branch');
                $vaidate = false;
            }
            if($this->data->chequeNo == null || $this->data->chequeNo == '') {
                $this->addError('chequeNo', 'Please select cheque');
                $vaidate = false;
            }
        }
        
        return $vaidate;
    }

    public function submit() {
        $success = $this->save();
        if($success){
            // $this->redirectRoute(name: 'job-order', navigate: true);\
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Success', message: 'บันทึกข้อมูลสำเร็จ', type: 'success');
        }else{
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Error', message: 'บันทึกข้อมูลไม่สำเร็จ', type: 'error');
        }
    }

    public function approve() {
        // $this->data->editID = Auth::user()->usercode;
        // $this->data->documentstatus = 'A';
        // $this->data->save();
        // $this->job = JobOrder::find($this->data->refJobNo);
        // $this->data->items->each(function($item){
        //     $this->job->charge()->create([
        //         'documentID' => $this->job->documentID,
        //         'ref_paymentCode' => $this->data->documentID,
        //         'chargeCode' => $item->chargeCode,
        //         'detail' => $item->chartDetail,
        //         'chargesCost' => $item->amount,
        //         // 'chargesReceive' => $item->amount,
        //         // 'chargesbillReceive' => $item->amount,
        //     ]);
        // });
        $success = $this->save(true);
        if($success) {
            // $this->redirectRoute(name: 'advance-payment', navigate: true);
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Success', message: 'บันทึกข้อมูลสำเร็จ', type: 'success');
        }else {
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Error', message: 'บันทึกข้อมูลไม่สำเร็จ', type: 'error');
        }
        // $this->redirectRoute(name: 'shipping-payment-voucher', navigate: true);
    }

    public function render()
    {
        return view('livewire.page.customer.advance-payment.form')->extends('layouts.main')->section('main-content');
    }
}
