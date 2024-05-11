<?php

namespace App\Livewire\Page\Customer\AdvancePayment;

use App\Enum\Role;
use App\Models\Common\Customer;
use App\Models\Payment\AdvancePayment;
use Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class Page extends Component
{
    use WithPagination;

    public $dateStart;
    public $dateEnd;
    public $customerList = [];
    public $customerSearch = "";
    public $documentNo = "";
    public $jobNo = "";

    public $invoiceNo = "";
    public $query = [];

    public function mount(){
        $this->dateStart = null;
        $this->dateEnd = null;
        $this->customerList = Customer::all()->sortBy('custNameEN');
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
        if($this->jobNo != null) {
            $this->query[] = ['refJobNo', 'like', '%'.$this->jobNo.'%'];
        }
        if($this->invoiceNo != null) {
            $this->query[] = ['refInvoiceNo', 'like', '%'.$this->invoiceNo.'%'];
        }
        if($this->documentNo != null) {
            $this->query[] = ['documentID', 'like', '%'.$this->documentNo.'%'];
        }
        if($this->customerSearch != null) {
            $this->query[] = ['cusCode', $this->customerSearch];
        }
    }

    public function delete($id) {
        AdvancePayment::find($id)->delete();
    }

    public function render()
    {
        if(Auth::user()->UserType->userTypeName == Role::CUSTOMER){
            $data = AdvancePayment::whereHas('customer', function($q) {
                $q->where('usercode', Auth::user()->usercode);
            
            })->where($this->query)->orderBy('documentID', 'DESC')->paginate(20);
        }else{
            $data = AdvancePayment::with(['customer'])->where($this->query)->orderBy('documentID', 'DESC')->paginate(20);
        }   
        return view('livewire.page.customer.advance-payment.page', [ 'data'=> $data])->extends('layouts.main')->section('main-content');
    }
}
