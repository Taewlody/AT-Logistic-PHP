<?php

namespace App\Livewire\page\Account\PettyCash;

use App\Enum\Role;
use Auth;
use Livewire\Attributes\On;
use App\Models\PettyCash\PettyCash;
use App\Models\PettyCash\PettyCashItems;
use App\Models\Common\Customer;
use App\Models\Common\Saleman;
use App\Models\Common\Supplier;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Marketing\JobOrderCharge;

class Page extends Component
{
    
    use WithPagination;

    public $dateStart;
    public $dateEnd;
    public $customerList = [];
    public $supplierList = [];
    public $supplierSearch = "";
    public $customerSearch = "";
    public $documentNo = "";
    public $jobNo = "";
    public $query = [];

    public function mount(){
        $this->dateStart = null;
        $this->dateEnd = null;
        $this->customerList = Customer::all()->sortBy('custNameEN');
        $this->supplierList = Supplier::all()->sortBy('supNameEN');
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
        if($this->supplierSearch != null) {
            $this->query[] = ['supCode', '=', $this->supplierSearch];
        }
        if($this->documentNo != null) {
            $this->query[] = ['documentID', 'like', '%'.$this->documentNo.'%'];
        }
        if($this->jobNo != null) {
            $this->query[] = ['refJobNo', 'like', '%'.$this->jobNo.'%'];
        }
    }

    public function delete($id) {
        \DB::beginTransaction();
        try {
            PettyCash::find($id)->delete();
            PettyCashItems::where('documentID', $id)->delete();
            $check = JobOrderCharge::where('ref_paymentCode', $id)->get();
            if($check) {
                JobOrderCharge::where('ref_paymentCode', $id)->delete();
            }
            \DB::commit();
        } catch (\Exception $exception) {
            \DB::rollBack();
        }
    }

    public function render()
    {
        if(Auth::user()->UserType->userTypeName == Role::SUPPLIER){
            $data = PettyCash::whereHas('supplier', function($q) {
                $q->where('usercode', Auth::user()->usercode);
            
            })->where($this->query)->orderBy('documentID', 'DESC')->paginate(20);
        }else{
            $data = PettyCash::where($this->query)->orderBy('documentDate', 'desc')->paginate(20);
        }   
        return view('livewire.page.account.petty-cash.page', [ 'data'=> $data])->extends('layouts.main')->section('main-content');
    }
}
