<?php

namespace App\Livewire\page\Account\ReceiptVoucher;

use Livewire\Attributes\On;
use App\Models\Account\ReceiptVoucher;
use App\Models\Account\ReceiptVoucherItems;
use App\Models\Common\Customer;
use App\Models\Common\Saleman;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Page extends Component
{
    use WithPagination;

    public $dateStart;
    public $dateEnd;
    public $customerList = [];
    public $customerSearch = "";
    public $documentNo = "";
    public $jobNo = "";
    public $query = [];

    public function mount(){
        $this->dateStart = null;
        $this->dateEnd = null;
        $this->customerList = Customer::all()->sortBy('custNameEN');
        $this->salemanList = Saleman::all()->sortBy('salemanNameEN');
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
            ReceiptVoucher::find($id)->delete();
            $check = ReceiptVoucherItems::where('documentID', $id)->get();
            if($check) {
                ReceiptVoucherItems::where('documentID', $id)->delete();
            }
            \DB::commit();
        } catch (\Exception $exception) {
            \DB::rollBack();
        }
    }

    public function render()
    {
        return view('livewire.page.account.receipt-voucher.page', [ 'data'=> ReceiptVoucher::where($this->query)->orderBy('documentID', 'desc')->paginate(20)])->extends('layouts.main')->section('main-content');
    }
}
