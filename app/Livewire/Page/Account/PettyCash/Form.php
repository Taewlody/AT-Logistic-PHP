<?php

namespace App\Livewire\Page\Account\PettyCash;

use App\Functions\Service;
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
use Illuminate\Support\Facades\DB;
use App\Models\Marketing\JobOrderCharge;

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

    public $jobOrderSelecter;

    public $priceSum;

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

    public function calTax1($value) {
        
        $this->calPrice(tax1: $value ? $value : 0, tax3: $this->priceSum->tax3 ? $this->priceSum->tax3 : 0, tax7: $this->priceSum->tax7 ? $this->priceSum->tax7 : 0);
        $this->dispatch('refresh');
        
    }

    public function calTax3($value) {
        $this->calPrice(tax1: $this->priceSum->tax1 ? $this->priceSum->tax1 : 0, tax3: $value ? $value : 0, tax7: $this->priceSum->tax7 ? $this->priceSum->tax7 : 0);
        $this->dispatch('refresh');
    }

    public function calTax7($value) {
        $this->calPrice(tax1: $this->priceSum->tax1 ? $this->priceSum->tax1 : 0, tax3: $this->priceSum->tax3 ? $this->priceSum->tax3 : 0, tax7: $value ? $value : 0);
        $this->dispatch('refresh');
    }

    public function changeGrandTotal(int $index) {
        // $this->payments[$index]->GrandTotal = $this->payments[$index]->amount;
        // dd($this->payments, $this->priceSum);
        $this->calPrice();
        // $this->dispatch('refresh');
    }

    // #[Computed]
    public function calPrice(float|null $tax1 = null, float|null $tax3 = null, float|null $tax7 = null) {
        
        $cal_price = (object) [
            'total' => 0,
            'tax3' => 0,
            'tax1' => 0,
            'tax7' => 0,
            'grandTotal' => 0,
        ];
        if(!isset($this->payments)||$this->payments == null) {
            // return $cal_price;
            $this->priceSum = $cal_price;
        }
        $cal_price->total = $this->payments->sum('amount');
        // dd($cal_price->total);
        if($tax3 != null) {
            // dd($tax3);
            $cal_price->tax3 = $tax3;
        } 
        if($tax1 != null) {
            // dd($tax1);
            $cal_price->tax1 = $tax1;
        } 
        if($tax7 != null) {
            // dd($tax1);
            $cal_price->tax7 = $tax7;
        } 
        
        $cal_price->grandTotal = ($cal_price->total - ($cal_price->tax1 + $cal_price->tax3)) + $cal_price->tax7;
        // return $cal_price;
        
        $this->priceSum = $cal_price;
        $this->dispatch('cal-update');
    }

    public function mount()
    {
        $this->data = new PettyCash;
        if ($this->action == '') {
            $this->action = 'view';
        } else {
            $this->action;
        }

        if ($this->id != '') {
            $this->data = PettyCash::find($this->id);
            $this->payments = $this->data->items;

            // $this->calPrice(tax1: $this->data->sumTax1 ? $this->data->sumTax1 : 0, tax3: $this->data->sumTax3 ? $this->data->sumTax3 : 0, tax7: $this->data->sumTax7 ? $this->data->sumTax7 : 0);

        } else {
            $this->action = 'create';
            $this->data->documentDate = Carbon::now()->toDateString();
            $this->data->createID = Auth::user()->usercode;
            $this->data->dueDate = Carbon::now()->endOfMonth()->toDateString();
            $this->payments = new Collection;
        }
        $this->calPrice();

        $this->viewMode = ViewMode::from($this->action);
        $this->formMode = $this->viewMode->toFormMode();

        if($this->data->documentstatus == 'A' && !Auth::user()->hasRole('admin') && $this->viewMode == ViewMode::EDIT) {
            $this->formMode = FormMode::from('disabled');
        } 

        $this->jobOrderSelecter = Service::JobOrderSelecter();
        // dd($this->data);
    }

    // #[On("updated-refJobNo")]
    // public function updateRefJob(){
    //     $selectedJob = JobOrder::find($this->data->refJobNo);
    //     $this->dispatch("change-select2-supCode", data: $selectedJob->agentCode);
    // }

    #[On("updated-refJobNo")]
    public function updateRefJob(){
        $selectedJob = JobOrder::find($this->data->refJobNo);
        if($selectedJob->invoice != null) {
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Warning', message: 'job นี้ได้มีการออก invoice แล้ว', type: 'warning');
        }
    }

    #[On('Add-Charge')]
    public function addPayment() {
        $charge = Charges::find($this->chargeCode);
        $newCharge = new PettyCashItems;
        $newCharge->documentID = $this->data->documentID;
        $newCharge->chargeCode = $this->chargeCode;
        $newCharge->chartDetail = $charge->chargeName;
        $this->payments->push($newCharge);
        $this->reset('chargeCode');
        $this->dispatch('reset-select2-chargeCode');
        $this->dispatch('update-charges');
    }
    

    public function removePayment(int $index) {
        $this->payments->forget($index);
        $this->payments = $this->payments->values();
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
                // $this->data->dueDate = Carbon::now()->toDateString();
            }else {
                $this->data->dueDate = Carbon::now()->endOfMonth()->toDateString();
            }

            // $this->data->sumTotal = $this->calPrice->total;
            // $this->data->sumTax1 = $this->calPrice->tax1;
            // $this->data->sumTax3 = $this->calPrice->tax3;
            // $this->data->sumTax7 = $this->calPrice->tax7;
            // $this->data->grandTotal = $this->calPrice->grandTotal;
            $this->data->sumTotal = $this->priceSum->total;
            $this->data->sumTax3 = $this->priceSum->tax3;
            $this->data->sumTax1 = $this->priceSum->tax1;
            $this->data->sumTax7 = $this->priceSum->tax7;
            $this->data->grandTotal = $this->priceSum->grandTotal;
            $this->data->editID = Auth::user()->usercode;
            // dd($this->data);
            $this->data->save();

            $this->data->items()->delete();
            $job = JobOrder::where('documentID', $this->data->refJobNo)->first();
            foreach($this->payments as $pay) {
                $data = new PettyCashItems();
                $data->comCode = 'C01';
                $data->documentID = $this->data->documentID;
                $data->chargeCode = $pay->chargeCode;
                $data->chartDetail = $pay->chartDetail;
                $data->amount = $pay->amount;
                $data->invNo = $job->invNo;

                $this->data->items()->save($data);
            }

            \DB::commit();
            return true;
        } catch (\Exception $exception) {
            \DB::rollBack();
            dd($exception->getMessage());
            return false;
        }
    }

    public function valid() {
        $vaildated = true;
        if($this->data->dueDate == null || $this->data->dueDate == '') {
            $this->addError('dueDate', 'Please select due date');
            $vaildated = false;
        }else {
            $this->resetErrorBag('dueDate');
        }
        if($this->data->supCode == null || $this->data->supCode == '') {
            $this->addError('supCode', 'Please select supplier');
            $vaildated = false;
        }else {
            $this->resetErrorBag('supCode');
        }
        if($this->data->refJobNo == null || $this->data->refJobNo == '') {
            $this->addError('refJobNo', 'Please select Ref. JobNo.');
            $vaildated = false;
        }else {
            $this->resetErrorBag('refJobNo');
        }
        
        return $vaildated;
    }

    public function submit(){
        $success = $this->save();
        if($success){
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Success', message: 'บันทึกข้อมูลสำเร็จ', type: 'success');
            return redirect()->route('account-petty-cash.form', ['action' => 'edit', 'id' => $this->data->documentID]);
        }else{
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Error', message: 'บันทึกข้อมูลไม่สำเร็จ', type: 'error');
        }
    }

    public function approve() {
        $success = $this->save(true);
        if($success){
            $charge = $this->createJobOrderCharge();
            
            if($charge == true) {
                $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Success', message: 'Approve สำเร็จ', type: 'success');
                return redirect()->route('account-petty-cash.form', ['action' => 'edit', 'id' => $this->data->documentID]);
            }else if($charge == false) {
                $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Error', message: 'Approve ไม่สำเร็จ', type: 'error');
            }else {
                this->dispatch('modal.common.modal-alert', showModal: true, title: 'Success', message: 'Approve สำเร็จ', type: 'success');
                return redirect()->route('account-petty-cash.form', ['action' => 'edit', 'id' => $this->data->documentID]);
            }

        }else{
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Error', message: 'บันทึกข้อมูลไม่สำเร็จ', type: 'error');
        }
    }

    public function update() {
        $success = $this->save(true);
        if($success){
            $charge = $this->createJobOrderCharge();
            
            if($charge == true) {
                $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Success', message: 'Approve สำเร็จ', type: 'success');
                return redirect()->route('account-petty-cash.form', ['action' => 'edit', 'id' => $this->data->documentID]);
            }else if($charge == false) {
                $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Error', message: 'Approve ไม่สำเร็จ', type: 'error');
            }else {
                this->dispatch('modal.common.modal-alert', showModal: true, title: 'Success', message: 'Approve สำเร็จ', type: 'success');
                return redirect()->route('account-petty-cash.form', ['action' => 'edit', 'id' => $this->data->documentID]);
            }

        }else{
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Error', message: 'บันทึกข้อมูลไม่สำเร็จ', type: 'error');
        }
    }

    public function createJobOrderCharge()
    {
        DB::beginTransaction();
        try {
            $this->job = JobOrder::find($this->data->refJobNo);
            $check = JobOrderCharge::where('ref_paymentCode', $this->data->documentID)->get();
            
            if($check) {
                $test = JobOrderCharge::where('ref_paymentCode', $this->data->documentID)->delete();
            }
            
            foreach($this->data->items as $item){
                $data = new JobOrderCharge();
                $data->comCode = 'C01';
                $data->chargesCost = $item->amount;
                $data->chargesReceive = 0.00;
                $data->chargesbillReceive = 0.00;
                $data->documentID = $this->job->documentID;
                $data->ref_paymentCode = $this->data->documentID;
                $data->chargeCode = $item->chargeCode;
                $data->detail = $item->chartDetail;
                
                $data->save();
                
            };
            // dd(JobOrderCharge::where('ref_paymentCode', $this->data->documentID)->get());
            

            \DB::commit();
            return true;
        } catch (\Exception $exception) {
            \DB::rollBack();
            return false;
        }
    }


    public function render()
    {
        return view('livewire.page.account.petty-cash.form')->extends('layouts.main')->section('main-content');
    }
}
