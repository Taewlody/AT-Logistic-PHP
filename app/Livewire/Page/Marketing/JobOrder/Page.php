<?php

namespace App\Livewire\Page\Marketing\JobOrder;

use App\Enum\Role;
use Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

use App\Models\Marketing\JobOrder;
use App\Models\Common\Customer;
use App\Models\Common\Saleman;

class Page extends Component
{
    use WithPagination;

    public $dateStart;
    public $dateEnd;
    public $documentID = '';
    public $invoiceNo = '';
    public $invNo = '';
    public $bookingNo = '';
    public $bill_of_landing = '';

    public $customerList = [];
    public $customerSearch = "";
    public $salemanList = [];
    public $salemanSearch = "";
    public $query = [];

    public function mount(){
        $this->dateStart = null;
        $this->dateEnd = null;
        $this->customerList = Customer::all()->sortBy('custNameEN');
        $this->salemanList = Saleman::all()->sortBy('empName');
    }

    #[On('post-search')] 
    public function search() {
        $this->query = [];
        if($this->dateStart != null) {
            $this->query[] = ['documentDate', '>=', $this->dateStart];
        }
        if($this->dateEnd != null) {
            $this->query[] = ['documentDate', '<=', $this->dateEnd];
        }
        if($this->customerSearch != null) {
            $this->query[] = ['cusCode', '=', $this->customerSearch];
        }
        if($this->salemanSearch != null) {
            $this->query[] = ['saleman', '=', $this->salemanSearch];
        }
        if($this->documentID != null) {
            $this->query[] = ['documentID', 'like', '%'.$this->documentID.'%'];
        }
        // if($this->invoiceNo != null) {
        //     $this->query[] = ['invoiceNo', 'like', '%'.$this->invoiceNo.'%'];
        // }
        if($this->invNo != null) {
            $this->query[] = ['invNo', 'like', '%'.$this->invNo.'%'];
        }
        if($this->bookingNo != null) {
            $this->query[] = ['bookingNo', 'like', '%'.$this->bookingNo.'%'];
        }
        if($this->bill_of_landing != null) {
            $this->query[] = ['bill_of_landing', 'like', '%'.$this->bill_of_landing.'%'];
        }
    }

    public function delete($id) {
        JobOrder::find($id)->delete();
        $this->render();
    }

    public function createNewJobFromCopy($job) {
        
            \DB::beginTransaction();
            try {
                $newJob = new JobOrder;
                
                $newJob->createID = Auth::user()->usercode;
                $newJob->documentDate = Carbon::now()->format('Y-m-d');

                $newJob->bound = $job->bound;
                $newJob->port_of_landing = $job->port_of_landing;
                $newJob->freight = $job->freight;
                $newJob->port_of_discharge = $job->port_of_discharge;
                $newJob->etdDate = $job->etdDate;
                $newJob->etaDate = $job->etaDate;
                $newJob->closingDate = $job->closingDate;
                $newJob->closingTime = $job->closingTime;
                $newJob->deliveryType = $job->deliveryType;
                $newJob->cusCode = $job->cusCode;
                $newJob->agentCode = $job->agentCode;
                $newJob->saleman = $job->saleman;
                $newJob->feeder = $job->feeder;
                
                // dd($newJob, $job);

                $newJob->save();

                \DB::commit();
                return true;
            }catch (\Exception $exception) {
                \DB::rollBack();
                dd($exception->getMessage());
                echo "Exception caught: " . $exception->getMessage();
                return false;
            }
        
    }

    public function copy($id) {
        $job = JobOrder::find($id);
        $result = false;

        if($job) {
            $result = $this->createNewJobFromCopy($job);
        }

        if($result) {
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Success', message: 'Copy ข้อมูลสำเร็จ', type: 'success');
            $this->render();
        }else {
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Error', message: 'Copy ข้อมูลไม่สำเร็จ', type: 'error');
        }
    }

    public function render()
    {
        if(Auth::user()->hasRole(Role::CUSTOMER)){
           
        }
        $invoice = $this->invoiceNo?? '';
        // $data = JobOrder::with(['AdvancePayment', 'PettyCash', 'PaymentVoucher', 'invoice' => function($query) use ($invoice) {
        //     $query->where('documentID', $invoice);
        // }])
        // ->whereHas('invoice', function ($query) use ($invoice) {
        //     $query->where('documentID', $invoice);
        // })
        // ->where($this->query)
        // ->orderBy('documentID', 'DESC')
        // ->get();
        // dd($data);

        return view('livewire.page.marketing.job-order.page',[ 
            'data'=> JobOrder::with(['AdvancePayment', 'PettyCash', 'PaymentVoucher', 'invoice' => function($query) use ($invoice) {
                if ($invoice) {
                    $query->where('documentID', $invoice);
                }
            }])
            ->when($invoice, function ($query) use ($invoice) {
                $query->whereHas('invoice', function ($query) use ($invoice) {
                    $query->where('documentID', $invoice);
                });
            })
            ->where($this->query)
            ->orderBy('documentID', 'DESC')->paginate(20)
            ])->extends('layouts.main')->section('main-content');
        // return view('livewire.page.marketing.job-order.page',[ 
        //     'data'=> JobOrder::with(['AdvancePayment', 'PettyCash', 'PaymentVoucher'])->where($this->query)->orderBy('documentID', 'DESC')->paginate(20)
        //     ])->extends('layouts.main')->section('main-content');
    }
}
