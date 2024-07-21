<?php

namespace App\Livewire\page\Account\PaymentVoucher;

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
        return view('livewire.page.account.payment-voucher.page', [ 'data'=> PaymentVoucher::where($this->query)->orderBy('documentID', 'desc')->paginate(20)])->extends('layouts.main')->section('main-content');
    }
}
