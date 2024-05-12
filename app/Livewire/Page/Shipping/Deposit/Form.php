<?php

namespace App\Livewire\Page\Shipping\Deposit;

use App\Models\AttachFile;
use App\Models\Common\BankAccount;
use App\Models\Common\Charges;
use App\Models\Common\Customer;
use App\Models\Common\Supplier;
use App\Models\Marketing\JobOrder;
use App\Models\Shipping\Deposit;
use App\Models\Shipping\DepositAttach;
use App\Models\Shipping\DepositItems;
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

    public string $chargeCode = '';

    public ?Deposit $data = null;

    public Collection $payments;

    public Collection $attachs;

    public $file;
    protected array $rules = [
        'file' => 'mimes:png,jpg,jpeg,pdf|max:102400',
        'payments.*' => 'unique:App\Models\Shipping\DepositItems',
        'payments.*.autoid' => 'integer',
        'payments.*.comCode' => 'string',
        'payments.*.documentID' => 'string',
        'payments.*.invNo' => 'string',
        'payments.*.chargeCode' => 'string',
        'payments.*.chartDetail' => 'string',
        'payments.*.amount' => 'float',
        'attachs.*'=> 'unique:App\Models\Shipping\DepositAttach',
        'attachs.*.items' => 'integer',
        'attachs.*.comCode' => 'string',
        'attachs.*.documentID' => 'string',
        'attachs.*.cusCode' => 'string',
        'attachs.*.fileDetail' => 'string',
        'attachs.*.fileName' => 'string',
    ];

    public function mount()
    {
        $this->data = new Deposit;
        if ($this->action == '') {
            $this->action = 'view';
        } else {
            $this->action;
        }

        if ($this->id != '') {
            $this->data = Deposit::find($this->id);
            $this->payments = $this->data->items;
            $this->attachs = $this->data->attachs;
        } else {
            $this->action = 'create';
            $this->data->createID = Auth::user()->usercode;
            $this->payments = new Collection;
            $this->attachs = new Collection;
            $this->data->dueDate = Carbon::now()->endOfMonth()->toDateString();
            $this->data->dueTime = Carbon::now('GMT+7')->format('H:i');
        }
    }

    public function addPayment() {
        $charge = Charges::find($this->chargeCode);
        $newCharge = new DepositItems;
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
        $new_attach = new DepositAttach;
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
        $vaild = true;
        if($this->data->cuscode == null || $this->data->cuscode == '') {
            $this->addError('cusCode', 'Please select customer');
            $vaild = false;
            return $vaild;
        }
        $this->data->editID = Auth::user()->usercode;
        if($approve) {
            $this->data->documentStatus = 'A';
        }
        $this->data->save();
        $this->data->items->filter(function($item){
            return !collect($this->payments->pluck('autoid'))->contains($item->autoid);
        })->each->delete();
        $this->data->items()->saveMany($this->payments);
        return $vaild;
    }

    public function submit() {

        $success = $this->save();
        if($success) $this->redirectRoute(name: 'deposit', navigate: true);
    }

    public function approve() {
        $this->save(true);
        $success = $this->save();
        if($success) $this->redirectRoute(name: 'deposit', navigate: true);
    }

    public function complete() {
        $this->data->documentStatus = 'C';
        $this->data->save();
        $this->redirectRoute(name: 'deposit', navigate: true);
    }

    public function render()
    {
        return view('livewire.page.shipping.deposit.form')->extends('layouts.main')->section('main-content');
    }
}
