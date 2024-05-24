<?php

namespace App\Livewire\Page\Account\PettyCash;

use App\Enum\FormMode;
use App\Enum\ViewMode;
use App\Models\Common\Charges;
use App\Models\Common\Supplier;
use App\Models\Marketing\JobOrder;
use App\Models\PettyCash\PettyCash;
use App\Models\PettyCash\PettyCashItems;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class Form extends Component
{

    #[Url]
    public $action = '';
    #[Url]
    public $id = '';

    public ?PettyCash $data = null;

    public string $chargeCode = '';

    public Collection $payments;

    public ViewMode $viewMode;

    public FormMode $formMode;

    protected array $rules = [
        'payments.*' => 'unique:App\Models\PettyCash\PettyCashItems',
        'payments.*.autoid' => 'integer',
        'payments.*.comCode' => 'string',
        'payments.*.documentID' => 'string',
        'payments.*.invNo' => 'string',
        'payments.*.chargeCode' => 'string',
        'payments.*.chartDetail' => 'string',
        'payments.*.amount' => 'float',
    ];

    // public function rules() {
    //     return [
    //         'data.dueDate' => 'required|date',
    //     ];
    // }

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
        $this->data = new PettyCash;
        if ($this->action == '') {
            $this->action = 'view';
        } 

        if ($this->id != '') {
            $this->data = PettyCash::find($this->id);
            $this->payments = $this->data->items;
        } else {
            $this->action = 'create';
            $this->data->createID = Auth::user()->usercode;
            $this->data->dueDate = Carbon::now()->endOfMonth()->toDateString();
            $this->payments = new Collection;
        }

        $this->viewMode = ViewMode::from($this->action);
        $this->formMode = $this->viewMode->toFormMode();

        if($this->data->documentstatus == 'A' && !Auth::user()->hasRole('admin') && $this->viewMode == ViewMode::EDIT) {
            $this->formMode = FormMode::from('disabled');
        } 
    }

    #[On("updated-refJobNo")]
    public function updateRefJob(){
        $selectedJob = JobOrder::find($this->data->refJobNo);
        $this->dispatch("change-select2-supCode", data: $selectedJob->agentCode);
    }

    public function addPayment() {
        $charge = Charges::find($this->chargeCode);
        $newCharge = new PettyCashItems;
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

    public function save(bool|null $approve = false) {
        if(!$this->valid()) {
            return false;
        }
        $this->data->editID = Auth::user()->usercode;
        if($approve) {
            $this->data->documentstatus = 'A';
        }

        $this->data->sumTotal = $this->calPrice->total;
        $this->data->sumTax1 = $this->calPrice->tax1;
        $this->data->sumTax3 = $this->calPrice->tax3;
        $this->data->sumTax7 = $this->calPrice->tax7;
        $this->data->grandTotal = $this->calPrice->grandTotal;
        $this->data->editID = Auth::user()->usercode;
        $this->data->save();
        $this->data->items->filter(function($item){
            return !collect($this->payments->pluck('autoid'))->contains($item->autoid);
        })->each->delete();
        $this->data->items()->saveMany($this->payments);
        // $this->redirectRoute(name: 'account-petty-cash', navigate: true);
        return true;
    }



    public function valid() {
        $vaildated = true;
        if($this->data->dueDate == null || $this->data->dueDate == '') {
            $this->addError('dueDate', 'Please select due date');
            $vaildated = false;
        }
        if($this->data->supCode == null || $this->data->supCode == '') {
            $this->addError('supCode', 'Please select supplier');
            $vaildated = false;
        }
        if($this->data->refJobNo == null || $this->data->refJobNo == '') {
            $this->addError('refJobNo', 'Please select Ref. JobNo.');
            $vaildated = false;
        }
        
        return $vaildated;
    }

    public function submit(){
        $success = $this->save();
        if($success){
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Success', message: 'บันทึกข้อมูลสำเร็จ', type: 'success');
        }else{
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Error', message: 'บันทึกข้อมูลไม่สำเร็จ', type: 'error');
        }
    }

    public function approve() {
        $success = $this->save(true);
        if($success){
            $this->job = JobOrder::find($this->data->refJobNo);
            $this->data->items->each(function($item){
                $this->job->charge()->create([
                    'documentID' => $this->job->documentID,
                    'ref_paymentCode' => $this->data->documentID,
                    'chargeCode' => $item->chargeCode,
                    'detail' => $item->chartDetail,
                    'chargesCost' => $item->amount,
                ]);
            });
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Success', message: 'บันทึกข้อมูลสำเร็จ', type: 'success');

        }else{
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Error', message: 'บันทึกข้อมูลไม่สำเร็จ', type: 'error');
        }
        
        // $this->redirectRoute(name: 'shipping-petty-cash', navigate: true);
    }



    public function render()
    {
        return view('livewire.page.account.petty-cash.form')->extends('layouts.main')->section('main-content');
    }
}
