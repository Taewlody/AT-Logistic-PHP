<?php

namespace App\Livewire\Page\Customer\AdvancePayment;

use App\Models\AttachFile;
use App\Models\Common\Charges;
use App\Models\Payment\AdvancePayment;
use App\Models\Payment\AdvancePaymentAttach;
use App\Models\Payment\AdvancePaymentItems;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
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
        } else {
            $this->action;
        }

        if ($this->id != '') {
            $this->data = AdvancePayment::find($this->id);
        } else {
            $this->action = 'create';
            $this->data->createID = Auth::user()->usercode;
        }
        $this->payments = $this->data->items;
        $this->attachs = $this->data->attachs;
        // dd($this->attachs->get(0)->blobFile);
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

    public function save() {
        $this->data->editID = Auth::user()->usercode;
        $this->data->save();
        $this->data->items()->saveMany($this->payments);
        $this->data->attachs()->saveMany($this->attachs);
        $this->redirectRoute(name: 'advance-payment', navigate: true);
    }

    public function render()
    {
        return view('livewire.page.customer.advance-payment.form')->extends('layouts.main')->section('main-content');
    }
}
