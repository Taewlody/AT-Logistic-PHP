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
        if($this->invoiceNo != null) {
            $this->query[] = ['invoiceNo', 'like', '%'.$this->invoiceNo.'%'];
        }
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

    public function render()
    {
        if(Auth::user()->hasRole(Role::CUSTOMER)){
           
        }
        // $data = JobOrder::with(['AdvancePayment', 'PettyCash', 'PaymentVoucher'])->where($this->query)->orderBy('documentID', 'DESC')->get();
        // dd($data[0]);
        return view('livewire.page.marketing.job-order.page',[ 
            'data'=> JobOrder::with(['AdvancePayment', 'PettyCash', 'PaymentVoucher'])->where($this->query)->orderBy('documentID', 'DESC')->paginate(20)
            ])->extends('layouts.main')->section('main-content');
    }
}
