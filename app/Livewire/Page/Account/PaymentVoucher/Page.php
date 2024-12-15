<?php

namespace App\Livewire\page\Account\PaymentVoucher;

use Auth;
use Livewire\Attributes\On;
use App\Models\Payment\PaymentVoucher;
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
    public $supplierList = [];
    public $supplierSearch = "";
    public $invoiceNo = "";
    public $jobNo = "";
    public $documentNo = "";
    public $documentstatus = "";
    public $query = [];

    public function mount(){
        $this->dateStart = null;
        $this->dateEnd = null;
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
        if($this->supplierSearch != null) {
            $this->query[] = ['supCode', '=', $this->supplierSearch];
        }
        if($this->documentNo != null) {
            $this->query[] = ['documentID', 'like', '%'.$this->documentNo.'%'];
        }
        if($this->jobNo != null) {
            $this->query[] = ['refjobNo', 'like', '%'.$this->jobNo.'%'];
        }
        if($this->documentstatus != null || $this->documentstatus != '') {
            $this->query[] = ['documentstatus', '=',  $this->documentstatus];
        }
    }

    public function delete($id) {
        \DB::beginTransaction();
        try {
            PaymentVoucher::find($id)->delete();
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
        if(Auth::user()->hasRole('Shipping Operation')) {
            $data = PaymentVoucher::where($this->query)
            ->where('createID', Auth::user()->usercode)
            ->orderBy('documentID', 'desc');

        } 
        else if(Auth::user()->hasRole('Supplier')) {
            $data = PaymentVoucher::whereHas('supplier', function($q) {
                $q->where('usercode', Auth::user()->usercode);
            
            })->where($this->query)
            ->orderBy('documentID', 'desc');
            
        }
        else {
            $data = PaymentVoucher::where($this->query)
            ->orderBy('documentID', 'desc');
        }

        return view('livewire.page.account.payment-voucher.page', [ 
            'data'=> $data->paginate(20)])
            ->extends('layouts.main')->section('main-content');
    }
}
