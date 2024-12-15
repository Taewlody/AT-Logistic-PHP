<?php

namespace App\Livewire\Page\Marketing\TrailerBooking;

use App\Models\Marketing\JobOrder;
use App\Models\Marketing\TrailerBooking;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Url;
use Carbon\Carbon;
use App\Functions\Service;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;

class Form extends Component
{

    #[Url]
    public $action = '';
    #[Url]
    public $id = '';

    #[Url]
    public $ref = '';

    private ?JobOrder $job_order;

    public ?TrailerBooking $data = null;

    public function mount()
    {
        $this->data = TrailerBooking::findOrNew($this->id);
        $this->jobOrderSelecter = Service::JobOrderSelecter();
        if ($this->action == '') {
            $this->action = 'view';
        } else {
            $this->action;
        }

        if (!$this->data->exists) {
            $this->action = 'create';
            $this->data->createID = Auth::user()->usercode;
            $this->data->work_order = Auth::user()->usercode;
            $this->data->documentDate = Carbon::now()->format('Y-m-d');

            if($this->ref != ''){
                $this->job_order = JobOrder::find($this->ref);
                if($this->job_order != null){

                    $this->data->ref_jobID = $this->job_order->documentID;
                    $this->data->cusCode = $this->job_order->cusCode;
                    $this->data->feeder = $this->job_order->feeder;
                    $this->data->agent = $this->job_order->agentCode;
                }
            }
        }else {
            $this->data->editID = Auth::user()->usercode;
        }
    }

    #[On("updated-ref_jobID")]
    public function getJobDetail() {
        if($this->data->ref_jobID == null) {
            return;
        }
        // $job = JobOrder::where('documentID', $this->data->ref_jobID)->first();
        $job = JobOrder::find($this->data->ref_jobID);
        $this->data->documentDate = $job->documentDate;
        $this->data->cusCode = $job->cusCode;
        $this->data->feeder = $job->feeder;
        $this->data->agent = $job->agentCode;
        // dd($job);
        $this->dispatch('change-select2-feeder', data: $job->feeder);
        $this->dispatch('change-select2-cusCode', data: $job->cusCode);
        $this->dispatch('change-select2-agent', data: $job->agentCode);

    }

    public function save(bool|null $approve = false) {
        \DB::beginTransaction();
        try {
            $this->data->editID = Auth::user()->usercode;
            $this->data->editTime = Carbon::now();
            $this->data->save();

            \DB::commit();
            return true;

        } catch (\Exception $exception) {
            \DB::rollBack();
            dd($exception->getMessage());
            return false;
        }
    }

    public function submit(){
        $success = $this->save();
        // dd($success);
        if($success){
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Success', message: 'บันทึกข้อมูลสำเร็จ', type: 'success');
            return redirect()->route('trailer-booking.form', ['action' => 'edit', 'id' => $this->data->documentID]);
        }else{
            $this->dispatch('vaildated');
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Error', message: 'บันทึกข้อมูลไม่สำเร็จ', type: 'error');
        }
    }

    public function approve() {
        $success = $this->save(true);
        if($success){
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Success', message: 'บันทึกข้อมูลสำเร็จ', type: 'success');
            return redirect()->route('trailer-booking.form', ['action' => 'edit', 'id' => $this->data->documentID]);
        }else{
            $this->dispatch('vaildated');
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Error', message: 'บันทึกข้อมูลไม่สำเร็จ', type: 'error');
        }
    }

    public function update() {
        $success = $this->save(true);
        if($success){
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Success', message: 'บันทึกข้อมูลสำเร็จ', type: 'success');
            return redirect()->route('trailer-booking.form', ['action' => 'edit', 'id' => $this->data->documentID]);
        }else{
            $this->dispatch('vaildated');
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Error', message: 'บันทึกข้อมูลไม่สำเร็จ', type: 'error');
        }
    }

    public function render()
    {
        return view('livewire.page.marketing.trailer-booking.form')->extends('layouts.main')->section('main-content');
    }
}
